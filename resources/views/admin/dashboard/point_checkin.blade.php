@extends('admin.layouts.template')

@section('ga')
window.gaTitle = 'หน้าแรก';
@endsection

@section('stylesheet')

<style>
    .t-coins{
        color: #f6a700;
        font-size: 1.25rem;
    }
</style>

@stop('stylesheet')

@section('content')



<div class="row">
                
      <div class="col-md-12">
        <a href="{{ url('api/del_checkin_all') }}" onclick="return confirm('Are you sure?')" class="btn btn-success btn-fw" style="float:right"><i class="icon-magic-wand"></i> ล้างข้อมูลทั้งหมด</a>
        <br /><br />
      </div>
                
                <div class="col-md-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">เช็คอินทุกวันเพื่อรับ Points</h4>

                      <div class="table-responsive">


                      <table class="table">
                        <thead>

                          <tr>
                            <th>วันที่</th>
                            <th></th>
                            <th>รางวัล</th>
                            <th>user</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                      
						@if(isset($objs))
                      @foreach($objs as $u)
                          <tr>
                            <td>
                              {{$u->point_date}} {{ date("H:i:s", strtotime($u->created_ats))}}
                            </td>
                            <td>
                                ได้ Point {{$u->coins}} จากการเช็คอินรายวัน 
                            </td>
                            <td>
                                <strong class="t-coins">+{{$u->coins}}</strong>
                            </td>
							<td>
                                {{$u->phone}}
                            </td>
                            
                            <td>
                              <a href="{{ url('admin/edit_point_checkin/'.$u->id_q) }}" class="btn btn-outline-primary btn-sm">แก้ไข</a>
                            </td>
                          </tr>
                          @endforeach
                          @endif


                        </tbody>
                      </table>
                      </div>
                      <br>
                      @include('admin.pagination.default', ['paginator' => $objs])
                    </div>
                  </div>
                </div>


              </div>



@endsection

@section('scripts')




@stop('scripts')