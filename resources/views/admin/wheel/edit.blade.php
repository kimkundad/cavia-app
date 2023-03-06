@extends('admin.layouts.template')

@section('ga')
window.gaTitle = 'หน้าแรก';
@endsection

@section('stylesheet')
<style>
.note-editor.note-frame .note-editing-area .note-editable {
    padding: 35px;
    overflow: auto;
    color: #000;
    background-color: #fff;
}
</style>
@stop('stylesheet')

@section('content')



<div class="row">

<div class="col-md-12">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">แก้ไข้รางวัลที่ {{ $id }}</h4>
      <p class="card-description">
        กรอกข้อมูลให้ครบ ในส่วนที่มีเครื่องหมาย <span class="text-danger">*</span>
      </p>

      <form class="forms-sample" method="POST" action="{{ url('api/post_wheel/'.$id) }}" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="form-group">
          <label for="exampleInputUsername1">ชื่อรางวัล <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="text" value="{{ $objs->text }}">
        </div>

     <div class="form-group">
          <label for="exampleInputUsername1">จำนวนรางวัล <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="value" value="{{ $objs->value }}">
        </div>

        <div class="form-group">
            <label for="exampleInputUsername1">message <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="message" value="{{ $objs->message }}">
          </div>

          <div class="form-group">
            <label for="exampleInputUsername1">เปอร์เซ็นการได้ <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="percent" value="{{ $objs->percent }}">
          </div>

          <div class="form-group">
            <label for="exampleInputUsername1">minDegree <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="minDegree" value="{{ $objs->minDegree }}">
          </div>

          <div class="form-group">
            <label for="exampleInputUsername1">maxDegree <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="maxDegree" value="{{ $objs->maxDegree }}">
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