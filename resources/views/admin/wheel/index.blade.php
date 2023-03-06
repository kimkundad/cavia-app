@extends('admin.layouts.template')

@section('ga')
window.gaTitle = 'หน้าแรก';
@endsection

@section('stylesheet')

@stop('stylesheet')

@section('content')



<div class="row">
                <div class="col-md-12">
                  <a href="{{ url('admin/get_point/create') }}" class="btn btn-success btn-fw" style="float:right"><i class="icon-plus"></i>เพิ่มรางวัลกงล้อ</a>
                  <br /><br />
                </div>

                
                <div class="col-md-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">รางวัลกงล้อมหาสนุก</h4>

                      <div class="table-responsive">


                      <table class="table">
                        <thead>

                          <tr>
                            <th>#</th>
                            <th>รางวัล</th>
                            <th>ชื่อรางวัล</th>
							<th>message</th>
                            <th>เปอร์เซ็น</th>
                            <th>minDegree</th>
                            <th>maxDegree</th>
                          </tr>
                        </thead>
                        <tbody>
                      
						@if(isset($objs))
                      @foreach($objs as $u)
                          <tr>
                            <td>
                              {{$u->id}}
                            </td>
                            <td>
                              {{$u->value}}
                            </td>
                            <td>
                                {{$u->text}}
                            </td>
							<td>
                                {{$u->message}}
                            </td>
                            <td>
                                {{$u->percent}}
                              </td>
                              <td>
                                  {{$u->minDegree}}
                              </td>
                              <td>
                                  {{$u->maxDegree}}
                              </td>
                            <td>
                              <a href="{{ url('admin/edit_point/'.$u->id) }}" class="btn btn-outline-primary btn-sm">แก้ไข</a>
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




@stop('scripts')