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
    <h4 class="card-title">อัพโหลดไฟล์ CSV</h4>

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
  <br><br>
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">ข้อมูลการสะสมแต้ม ทั้งหมด ( {{ count($point) }} รายการ )</h4>

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
                                                        {{ number_format((float)$u->total_valid_bet_amount, 0, '.', '') }}
                                                        @endif</td>
                          <td> @if($u->type == 1)
                                                       <span class="text-danger"> - {{ number_format((float)$u->points, 0, '.', '') }} </span>
                                                        @else
                                                        <span class="text-success">+ {{ number_format((float)$u->points, 0, '.', '') }} </span>
                                                        @endif</td>
                          <td>{{ $u->last_point }}</td>
                          <td><a href="{{ url('api/del_point_user_2/'.$u->idp) }}" onclick="return confirm('Are you sure?')" class="btn btn-outline-danger btn-sm">ลบ</a></td>
                        </tr>
                        @endforeach
                          @endif
                       
                      </tbody>
                    </table>
                  </div>
                  {{ $point->links() }}


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