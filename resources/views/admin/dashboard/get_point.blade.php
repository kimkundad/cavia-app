@extends('admin.layouts.template')

@section('ga')
window.gaTitle = 'หน้าแรก';
@endsection

@section('stylesheet')

@stop('stylesheet')

@section('content')



<div class="row">


<div class="col-md-12">
  <br><br>
  <div class="card">
    <div class="card-body">
    <h4 class="card-title">อัพโหลดไฟล์ CSV.</h4>

    <form action="{{ url('import') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-group">
                      <label>File upload</label>
                      <input type="file" name="file" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                    </div>

    <div style="text-align: right;">
        <br /><br /><br />
        <button type="submit" class="btn btn-primary mr-2">อัพโหลดไฟล์ </button>
        <button class="btn btn-light">ยกเลิก</button>
        </div>

    </form>
    </div>
  </div>
</div>


<div class="col-md-12">
  <br /><br />
  <a href="{{ url('/points_export') }}" class="btn btn-success btn-fw" style="float:right"><i class="icon-plus"></i>Export Data</a>

</div>

<div class="col-md-12">
  <br><br>
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">ข้อมูลการสะสมแต้ม ทั้งหมด ( {{ ($point_count) }} รายการ )</h4>

      <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>วันที่</th>
                          <th>ผู้ใช้งาน</th>
                          <th>เทริร์นโอเวอร์</th>
                          <th>Point</th>
                          <th>คะแนนรวม (ล่าสุด)</th>
                        </tr>
                      </thead>
                      <tbody>
                      @if(isset($point))
                      @foreach($point as $u)
                        <tr>
                          <td>{{ ($u->date) }}</td>
                          <td><a href="{{ url('admin/users/'.$u->idu.'/edit') }}">{{ $u->name }}</a></td>
                          <td>@if($u->type == 1)
                                                        {{ $u->detail }}
                                                        @else
                                                        {{ number_format($u->total_valid_bet_amount, 2) }}
                                                        @endif</td>
                          <td> @if($u->type == 1)
                                                       <span class="text-danger"> - {{ number_format($u->points, 2) }}  </span>
                                                        @else
                                                        <span class="text-success">+ {{ number_format($u->points, 2) }} </span>
                                                        @endif</td>
                          <td>{{ number_format($u->last_point, 2) }}</td>
                          <td>
                          @if($u->type != 1)
                          <a href="{{ url('api/del_point_user_2/'.$u->idp) }}" onclick="return confirm('Are you sure?')" class="btn btn-outline-danger btn-sm">ลบ</a>
                          @endif
                          </td>
                        </tr>
                        @endforeach
                          @endif

                      </tbody>
                    </table>
                  </div>

                  {{-- @include('admin.pagination.default', ['paginator' => $point]) --}}

                  {{ $point->links('admin.pagination.custom') }}


    </div>
  </div>
</div>

</div>
<br><br><br><br><br><br><br><br>


@endsection

@section('scripts')


<script>



</script>
@stop('scripts')
