@extends('admin.layouts.template')

@section('ga')
window.gaTitle = 'หน้าแรก';
@endsection

@section('stylesheet')

@stop('stylesheet')

@section('content')



<div class="row">

<div class="col-md-12">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">ข้อมูล ผู้ใช้งาน</h4>
      <p class="card-description">
        กรอกข้อมูลให้ครบ ในส่วนที่มีเครื่องหมาย <span class="text-danger">*</span>
      </p>

      <form class="forms-sample" method="POST" action="{{$url}}" enctype="multipart/form-data">
        {{ method_field($method) }}
        {{ csrf_field() }}
        <div class="form-group">
          <label for="exampleInputUsername1">ชื่อผู้ใช้งาน <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="exampleInputUsername1" name="name" value="{{ old('name') }}">
        </div>

        <div class="form-group">
          <label for="exampleInputUsername1">Key User <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="exampleInputUsername1" name="phone" value="{{ old('phone') }}">
        </div>

        <div class="form-group">
          <label for="exampleInputUsername1">พอยท์ <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="exampleInputUsername1" name="point" value="0" readonly>
        </div>


        <div class="form-group">
          <label for="exampleInputUsername1">รหัสผ่าน ( 8 ตัวขึ้นไป ) <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="exampleInputUsername1" name="password" value="{{ $pass }}">
        </div>

        <div class="form-group">
            <label for="exampleFormControlSelect2"> Role User </label>
            <select class="form-control" name="status_2">
                <option value="0">ผู้ใช้งานทั่วไป</option>
                <option value="1">แอดมิน</option>
            </select>
        </div>

        


        <div style="text-align: right;">
        <br /><br /><br />
        <button type="submit" class="btn btn-primary mr-2">บันทึก</button>
        <button class="btn btn-light">ยกเลิก</button>
        </div>

      </form>
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