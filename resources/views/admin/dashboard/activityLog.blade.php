@extends('admin.layouts.template')

@section('ga')
window.gaTitle = 'หน้าแรก';
@endsection

@section('stylesheet')

@stop('stylesheet')

@section('content')



<div class="row">

  <div class="col-md-12">
    <a href="{{ url('/activityLog_export') }}" class="btn btn-success btn-fw" style="float:right"><i class="icon-plus"></i>Export Data</a>
    <br /><br />
  </div>

                <div class="col-md-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">ActivityLog </h4>

                      <div class="table-responsive">


                      <table class="table">
                        <thead>

                          <tr>
                            <th>วันที่</th>
                            <th>Admin</th>
                            <th>กิจกรรม</th>
                            <th>รายละเอียด</th>
                          </tr>
                        </thead>
                        <tbody>

						       @foreach($logs as $log)
                                    <tr>
                                        <td>{{ $log->created_at }}</td>
                                        <td>{{ $log->admin ? $log->admin->name : 'ไม่มีข้อมูล' }}</td>
                                        <td>{{ $log->action }}</td>
                                        <td>{{ $log->details }}</td>
                                    </tr>
                                @endforeach


                        </tbody>
                      </table>
                      </div>
                       {{ $logs->links('admin.pagination.custom') }}
                    </div>
                  </div>
                </div>


              </div>



@endsection

@section('scripts')

<script>




</script>


@stop('scripts')
