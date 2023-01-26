@extends('admin.layouts.template')

@section('ga')
window.gaTitle = 'หน้าแรก';
@endsection

@section('stylesheet')

@stop('stylesheet')

@section('content')



<div class="row">

                <div class="col-md-12">
                <form class="form-horizontal" action="{{url('admin/user_search')}}" method="GET" enctype="multipart/form-data">
                          {{ csrf_field() }}
                <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="search" value="{{$search}}" placeholder="ค้นหารายชื่อ..." aria-label="Recipient's username">
                      <div class="input-group-append">
                        <button class="btn btn-sm btn-twitter" type="submit">
                          <i class="icon-magnifier"></i>
                        </button>
                      </div>
                    </div>
                  </div>

                  </form>

                  <a href="{{ url('admin/users/create') }}" class="btn btn-success btn-fw" style="float:right"><i class="icon-plus"></i>เพิ่มผู้ใช้งาน</a>
                  <br /><br />
                </div>

                
                <div class="col-md-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">ผู้ใช้งานทั้งหมด ( {{ count($objs) }} )</h4>

                      <div class="table-responsive">


                      <table class="table">
                        <thead>

                          <tr>
                            <th>ชื่อผู้ใช้งาน</th>
                            <th>พอยท์</th>
							              <th>User Key</th>
                            <th>วันที่สร้าง</th>
                            <th>ดำเนินการ</th>
                          </tr>
                        </thead>
                        <tbody>
                      
						@if(isset($objs))
                      @foreach($objs as $u)
                          <tr access_id="{{$u->id}}">
                            <td>
                              {{$u->name}}
                            </td>
                            <td>
                              {{$u->point}}
                            </td>
							<td>
                              {{$u->phone}}
                            </td>
                            <td>
                              {{ formatDateThat($u->created_at)}}
                            </td>
                            <td>
                              <a href="{{ url('admin/users/'.$u->id.'/edit') }}" class="btn btn-outline-primary btn-sm">แก้ไข</a>
                              <a href="{{ url('api/del_users/'.$u->id) }}" onclick="return confirm('Are you sure?')" class="btn btn-outline-danger btn-sm">ลบ</a>
                            </td>
                          </tr>
                          @endforeach
                          @endif

                        </tbody>
                      </table>
                      </div>
					  
                    </div>
                  </div>
                </div>


              </div>



@endsection

@section('scripts')

<script>



</script>


@stop('scripts')