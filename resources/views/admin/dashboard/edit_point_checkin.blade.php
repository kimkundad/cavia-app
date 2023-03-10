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
      <h4 class="card-title">แก้ไข้เช็คอินรายวันของ {{ $objs->phone }}</h4>
      <p class="card-description">
        กรอกข้อมูลให้ครบ ในส่วนที่มีเครื่องหมาย <span class="text-danger">*</span>
      </p>

      <form class="forms-sample" method="POST" action="{{ url('api/post_point_checkin/'.$id) }}" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="form-group">
          <label for="exampleInputUsername1"> จำนวน Point ที่ได้รับ<span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="coins" value="{{ $objs->coins }}" disabled>
        </div>

        <div class="form-group">
          <label for="exampleInputUsername1">วันที่เช็คอิน <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="point_date" value="{{ $objs->point_date }}">
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