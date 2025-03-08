
<script src="{{ url('assets/plugins/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ url('assets/plugins/nouislider/nouislider.min.js') }}"></script>
    <script src="{{ url('assets/plugins/popper.min.js') }}"></script>
    <script src="{{ url('assets/plugins/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ url('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('assets/plugins/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ url('assets/plugins/masonry.pkgd.min.js') }}"></script>
    <script src="{{ url('assets/plugins/isotope.pkgd.min.js') }}"></script>
    <script src="{{ url('assets/plugins/jquery.matchHeight-min.js') }}"></script>
    <script src="{{ url('assets/plugins/slick/slick/slick.min.js') }}"></script>
    <script src="{{ url('assets/plugins/jquery-bar-rating/dist/jquery.barrating.min.js') }}"></script>
    <script src="{{ url('assets/plugins/slick-animation.min.js') }}"></script>
    <script src="{{ url('assets/plugins/lightGallery-master/dist/js/lightgallery-all.min.js') }}"></script>
    <script src="{{ url('assets/plugins/sticky-sidebar/dist/sticky-sidebar.min.js') }}"></script>
    <script src="{{ url('assets/plugins/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ url('assets/plugins/gmap3.min.js') }}"></script>
    <!-- custom scripts-->
    <script src="{{ url('assets/js/main.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script type="text/javascript">
@if ($message = Session::get('add_success'))

$(document).ready(function(){

 // swal("เพิ่มสินค้าลงตะกร้าสำเร็จ!", "", "success");

  Swal.fire({
    title: "เพิ่มสินค้าลงตะกร้าสำเร็จ!",
    icon: "success",
    draggable: true
    });

    });

@endif

@if ($message = Session::get('pay_error'))

$(document).ready(function(){

  //  swal("Point ของคุณไม่เพียงพอ!");

    Swal.fire("Point ของคุณไม่เพียงพอ!");

    });

@endif

@if ($message = Session::get('pay_success'))

$(document).ready(function(){

 // swal("ส่งรายการแลกสินค้าสำเร็จ!", "", "success");

  Swal.fire({
    title: "ส่งรายการแลกสินค้าสำเร็จ!",
    icon: "success",
    draggable: true
    });


    });

@endif

@if ($message = Session::get('user_update'))

$(document).ready(function(){

 // swal("อัพเดทข้อมูลส่วนตัวสำเร็จ!", "", "success");

  Swal.fire({
    title: "อัพเดทข้อมูลส่วนตัวสำเร็จ!",
    icon: "success",
    draggable: true
    });

    });

@endif


@if ($message = Session::get('del_success'))

$(document).ready(function(){

 // swal("ลบสินค้าในตะกร้าสำเร็จ!", "", "success");

  Swal.fire({
    title: "ลบสินค้าในตะกร้าสำเร็จ!",
    icon: "success",
    draggable: true
    });

    });

@endif

@if ($message = Session::get('error_point'))

$(document).ready(function(){

    Swal.fire("Point ของคุณไม่เพียงพอ!");

    });

@endif


</script>

    <script>

            function setEventId(product_id, type, point, credit, myPoint) {
    console.log('--->', product_id, 'Type:', type, 'point:', point, 'credit:', credit, 'myPoint:', myPoint);

    // เช็คว่า Point พอหรือไม่
    if (myPoint < point) {
        Swal.fire({
            title: "Point ของคุณไม่เพียงพอ",
            text: `คุณมี ${myPoint} Point แต่ต้องการ ${point} Point เพื่อแลก Credit`,
            icon: "error",
            confirmButtonColor: "#d33",
            confirmButtonText: "ตกลง"
        });
        return; // หยุดการทำงาน
    }

    if (type == 1) {
        Swal.fire({
            title: "ยืนยันการแลก Point?",
            text: `คุณต้องการแลก ${point} Point เป็น Credit จำนวน ${credit} ใช่หรือไม่?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "ยืนยันการแลก",
            cancelButtonText: "ยกเลิก"
        }).then((result) => {
            if (result.isConfirmed) {
                // ส่งข้อมูลไปยังเซิร์ฟเวอร์
                $.ajax({
                    type: "POST",
                    url: "{{ url('/api_change_point') }}", // API Endpoint
                    data: {
                        product_id: product_id,
                        point: point,
                        credit: credit,
                        _token: "{{ csrf_token() }}" // สำหรับ Laravel CSRF Protection
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: "แลก Point สำเร็จ!",
                                text: `รายการแลกเครดิตจะถูกปรับให้ทุกเที่ยงคืนของวันถัดไป`,
                                icon: "success"
                            }).then(() => {
                                location.reload(); // รีโหลดหน้าหลังจากแลกสำเร็จ
                            });
                        } else {
                            Swal.fire({
                                title: "เกิดข้อผิดพลาด!",
                                text: response.message,
                                icon: "error"
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: "เกิดข้อผิดพลาด!",
                            text: "ไม่สามารถดำเนินการได้ กรุณาลองใหม่",
                            icon: "error"
                        });
                    }
                });
            }
        });

    } else {
        // โหลด modal ปกติผ่าน AJAX
        $.ajax({
            type: "GET",
            url: "{{ url('get_modal/') }}/" + product_id,
            success: function(resp) {
                $("#getCode").html(resp).show();
                $("#product-quickview").modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Error fetching modal:", error);
            }
        });
    }
}





        $(document).ready(function(){


        });
    </script>
