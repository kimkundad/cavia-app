
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

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script type="text/javascript">
@if ($message = Session::get('add_success'))

$(document).ready(function(){

  swal("เพิ่มสินค้าลงตะกร้าสำเร็จ!", "", "success");
  
    });

@endif

@if ($message = Session::get('pay_success'))

$(document).ready(function(){

  swal("ส่งรายการแลกสินค้าสำเร็จ!", "", "success");
  
    });

@endif

@if ($message = Session::get('user_update'))

$(document).ready(function(){

  swal("อัพเดทข้อมูลส่วนตัวสำเร็จ!", "", "success");
  
    });

@endif


@if ($message = Session::get('del_success'))

$(document).ready(function(){

  swal("ลบสินค้าในตะกร้าสำเร็จ!", "", "success");
  
    });

@endif

@if ($message = Session::get('error_point'))

$(document).ready(function(){

    swal("Point ของคุณไม่เพียงพอ!");
  
    });

@endif


</script>

    <script>

            function setEventId(event_id){
                console.log('--->', event_id)
                
                
                $.ajax({
                type: "get",
                url: "{{ url('get_modal/') }}/"+event_id,
                success: function(resp)
                {
                    
              
            
                
                    $("#getCode").html(resp).show();
                    $("#product-quickview").modal('show');
                }

            });

                
            }


        $(document).ready(function(){

            

            
        });
    </script>
