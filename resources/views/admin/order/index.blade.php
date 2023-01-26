@extends('admin.layouts.template')

@section('ga')
window.gaTitle = 'หน้าแรก';
@endsection

@section('stylesheet')

@stop('stylesheet')

@section('content')



<div class="row">
                

                
                <div class="col-md-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">รายการแลกสินค้าทั้งหมด</h4>

                      <div class="table-responsive">


                      <table class="table">
                        <thead>

                          <tr>
                            <th>Order No.</th>
                            <th>วันที่แลก</th>
                            <th>point</th>
							<th>ผู้ใช้งาน</th>
                            <th>สถานะ</th>
                            <th>ดำเนินการ</th>
                          </tr>
                        </thead>
                        <tbody>
                      
						@if(isset($objs))
                      @foreach($objs as $u)
                          <tr access_id="{{$u->id}}">
                            <td>
                              {{$u->order_no}}
                            </td>
                            <td>
                            {{ formatDateThat($u->created_at)}}
                            </td>
                            <td>
                            {{$u->sum_point}}
                            </td>
							<td>
                            <a href="{{ url('users/'.$u->user_idx.'/edit') }}">{{$u->user_name}}</a>
                            </td>
                            @if($u->status == 0)
                                                    <td class="text-warning">
                                                        รอเจ้าหน้าที่ตรวจสอบ
                                                    </td>
                                                    @endif
                                                    @if($u->status == 1)
                                                    <td class="text-warning">
                                                    อยู่ระหว่างการจัดส่ง
                                                    </td>
                                                    @endif
                                                    @if($u->status == 2)
                                                    <td class="text-success">
                                                    จัดสั่งสำเร็จ
                                                    </td>
                                                    @endif
                                                    @if($u->status == 3)
                                                    <td class="text-danger">
                                                    คืนสินค้า
                                                    </td>
                                                    @endif
                            <td>
                              <a href="{{ url('admin/order/'.$u->id.'/edit') }}" class="btn btn-outline-primary btn-sm">แก้ไข</a>
                              <a href="{{ url('api/del_order/'.$u->id) }}" onclick="return confirm('Are you sure?')" class="btn btn-outline-danger btn-sm">ลบ</a>
                            </td>
                          </tr>
                          @endforeach
                          @endif


                        </tbody>
                      </table>
                      </div>
					  {{ $objs->links() }}
                    </div>
                  </div>
                </div>


              </div>



@endsection

@section('scripts')

<script>

$(document).ready(function(){


	$("input.checkbox").change(function(event) {

	var course_id = $(this).closest('tr').attr('access_id');

	console.log('fea : '+course_id);
	$.ajax({
					type:'POST',
					url:'{{url('api/product_status')}}',
					headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
					data: { "user_id" : course_id },
					success: function(data){
						if(data.data.success){


              $.toast({
                heading: 'Success',
                text: 'ระบบทำการแก้ไขข้อมูลให้แล้ว.',
                showHideTransition: 'slide',
                icon: 'success',
                loaderBg: '#f96868',
                position: 'top-right'
              })



						}
					}
			});
	});

  	});


</script>


@stop('scripts')