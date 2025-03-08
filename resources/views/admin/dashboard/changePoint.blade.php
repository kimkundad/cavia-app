@extends('admin.layouts.template')

@section('ga')
window.gaTitle = 'หน้าแรก';
@endsection

@section('stylesheet')

@stop('stylesheet')

@section('content')



<div class="row">

  <div class="col-md-12">
    <a href="{{ url('/changePoint_export') }}" class="btn btn-success btn-fw" style="float:right"><i class="icon-plus"></i>Export Data</a>
    <br /><br />
  </div>

                <div class="col-md-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">รายการแลกเครดิตทั้งหมด</h4>

                      <div class="table-responsive">


                      <table class="table">
                        <thead>

                          <tr>
                            <th>Id</th>
                            <th>วันที่แลก</th>
                            <th>ลูกค้า</th>
                            <th>ชื่อ credit</th>
                            <th>credit</th>
                            <th>point</th>
                            <th>point ของฉันล่าสุด</th>
                            <th>สถานะ</th>
                            <th>ดำเนินการ</th>
                          </tr>
                        </thead>
                        <tbody>

						      @if(isset($objs))
                      @foreach($objs as $u)
                          <tr access_id="{{$u->id}}">
                            <td>#{{ $u->id }}</td>
                                                    <td>{{ $u->created_at }}</td>
                                                    <td><a href="{{ url('admin/users/'.$u->user->id.'/edit') }}">{{$u->user->name}}</a></td>
                                                    <td>{{ $u->product->name }}</td>
                                                    <td>{{ $u->credit }}</td>
                                                    <td>{{ $u->point }}</td>
                                                    <td>{{ $u->lastPoint }}</td>
                                                    <td class="{{ $u->status == 1 ? 'text-success' : 'text-warning' }}">
                                                        {{ $u->status == 1 ? 'สำเร็จ' : 'รอเจ้าหน้าที่ตรวจสอบ' }}
                                                    </td>
                            <td>
                              <div class="form-check form-check-flat">
                              <label class="form-check-label">
                                <input class="checkbox" type="checkbox" @if($u->status == 1)
                                  checked="checked"
                                  @endif>
                                รอตรวจสอบ / ตรวจสอบแล้ว
                              </label>
                            </div>
                            </td>
                          </tr>
                          @endforeach
                          @endif


                        </tbody>
                      </table>
                      </div>
                       {{ $objs->links('admin.pagination.custom') }}
                    </div>
                  </div>
                </div>


              </div>



@endsection

@section('scripts')

<script>

$(document).ready(function() {
    $("input.checkbox").change(function(event) {
        var credit_id = $(this).closest('tr').attr('access_id');
        var checkbox = $(this);

        console.log('Credit ID: ' + credit_id);
        $.ajax({
            type: 'POST',
            url: '{{url('api/credit_status')}}',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            data: { "credit_id": credit_id },
            success: function(data) {
                if (data.data.success) {
                    // อัปเดต UI
                    let statusText = checkbox.closest('tr').find('td.text-warning, td.text-success');
                    if (data.data.status == 1) {
                        statusText.removeClass('text-warning').addClass('text-success').text('สำเร็จ');
                    } else {
                        statusText.removeClass('text-success').addClass('text-warning').text('รอเจ้าหน้าที่ตรวจสอบ');
                    }

                    // แจ้งเตือน Toast
                    $.toast({
                        heading: 'Success',
                        text: 'ระบบทำการแก้ไขข้อมูลให้แล้ว.',
                        showHideTransition: 'slide',
                        icon: 'success',
                        loaderBg: '#f96868',
                        position: 'top-right'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Error updating credit status:", error);
                Swal.fire({
                    title: "เกิดข้อผิดพลาด!",
                    text: "ไม่สามารถอัปเดตสถานะได้ กรุณาลองใหม่",
                    icon: "error"
                });
            }
        });
    });
});



</script>


@stop('scripts')
