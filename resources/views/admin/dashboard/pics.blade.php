@extends('admin.layouts.template')

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
      <h4 class="card-title">เอกสารข้อมูล</h4>
      <p class="card-description">
        กรอกข้อมูลให้ครบ ในส่วนที่มีเครื่องหมาย <span class="text-danger">*</span>
      </p>

      <form class="forms-sample" method="POST" action="{{ url('api/post_pics') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        
                <div class="form-group">
                      <label>รูป : วางแผนการลงทุน</label>
                      <br>
                      <img src="{{ url('img/head/'.$objs->page1) }}" style="width: 300px; border: 2px solid #439aff;" >
                      <br><br>
                      <input type="file" name="page1" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                </div>
                <br>
                <hr>
                <br>
                <div class="form-group">
                      <label>รูป : วางแผนเกษียณ</label>
                      <br>
                      <img src="{{ url('img/head/'.$objs->page2) }}" style="width: 300px; border: 2px solid #439aff;" >
                      <br><br>
                      <input type="file" name="page2" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                </div>
                <br>
                <hr>
                <br>
                <div class="form-group">
                      <label>รูป : วางแผนภาษี</label>
                      <br>
                      <img src="{{ url('img/head/'.$objs->page3) }}" style="width: 300px; border: 2px solid #439aff;" >
                      <br><br>
                      <input type="file" name="page3" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                </div>
                <br>
                <hr>
                <br>
                <div class="form-group">
                      <label>รูป : วางแผนการศึกษา</label>
                      <br>
                      <img src="{{ url('img/head/'.$objs->page4) }}" style="width: 300px; border: 2px solid #439aff;" >
                      <br><br>
                      <input type="file" name="page4" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                </div>
                <br>
                <hr>
                <br>
                <div class="form-group">
                      <label>รูป : วางแผนบริหารความเสี่ยง</label>
                      <br>
                      <img src="{{ url('img/head/'.$objs->page5) }}" style="width: 300px; border: 2px solid #439aff;" >
                      <br><br>
                      <input type="file" name="page5" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                </div>
                <br>
                <hr>
                <br>
                <div class="form-group">
                      <label>รูป : วางแผนมรดก</label>
                      <br>
                      <img src="{{ url('img/head/'.$objs->page6) }}" style="width: 300px; border: 2px solid #439aff;" >
                      <br><br>
                      <input type="file" name="page6" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                </div>  
                <br>
                <hr>
                <br>
                <div class="form-group">
                      <label>รูป : สัมมนาให้ความรู้การเงินแก่พนักงาน</label>
                      <br>
                      <img src="{{ url('img/head/'.$objs->page7) }}" style="width: 300px; border: 2px solid #439aff;" >
                      <br><br>
                      <input type="file" name="page7" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                </div>
                <br>
                <hr>
                <br>
                <div class="form-group">
                      <label>รูป : ให้คำปรึกษาสร้างสวัสดิการแก่พนักงาน</label>
                      <br>
                      <img src="{{ url('img/head/'.$objs->page8) }}" style="width: 300px; border: 2px solid #439aff;" >
                      <br><br>
                      <input type="file" name="page8" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                </div>
                <br>
                <hr>
                <br>
                <div class="form-group">
                      <label>รูป : จัดตั้งกองทุนสำรองเลี้ยงชีพ</label>
                      <br>
                      <img src="{{ url('img/head/'.$objs->page9) }}" style="width: 300px; border: 2px solid #439aff;" >
                      <br><br>
                      <input type="file" name="page9" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                </div>
                <br>
                <hr>
                <br>
                <div class="form-group">
                      <label>รูป : ที่ปรึกษาด้านบัญชีและภาษีสำหรับองค์กร</label>
                      <br>
                      <img src="{{ url('img/head/'.$objs->page10) }}" style="width: 300px; border: 2px solid #439aff;" >
                      <br><br>
                      <input type="file" name="page10" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                </div>
                <br>
                <hr>
                <br>
                <div class="form-group">
                      <label>รูป : ที่ปรึกษาด้านการซื้อขายกิจการ</label>
                      <br>
                      <img src="{{ url('img/head/'.$objs->page11) }}" style="width: 300px; border: 2px solid #439aff;" >
                      <br><br>
                      <input type="file" name="page11" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                </div>
                <br>
                <hr>
                <br>
                <div class="form-group">
                      <label>รูป : ที่ปรึกษาการทำประกันชีวิต_บุคคลสำคัญขององค์กร</label>
                      <br>
                      <img src="{{ url('img/head/'.$objs->page12) }}" style="width: 300px; border: 2px solid #439aff;" >
                      <br><br>
                      <input type="file" name="page12" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                </div>
                <br>
                <hr>
                <br>

                <div class="form-group">
                      <label>รูป : จัดตั้งบริษัทโฮลดิ้ง_ทำแผนสืบทอดกิจการและธรรมนูญครอบครัว</label>
                      <br>
                      <img src="{{ url('img/head/'.$objs->page13) }}" style="width: 300px; border: 2px solid #439aff;" >
                      <br><br>
                      <input type="file" name="page13" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                </div>
                <br>
                <hr>
                <br>
                <div class="form-group">
                      <label>รูป : ประกันชีวิต</label>
                      <br>
                      <img src="{{ url('img/head/'.$objs->page14) }}" style="width: 300px; border: 2px solid #439aff;" >
                      <br><br>
                      <input type="file" name="page14" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                </div>
                <br>
                <hr>
                <br>
                <div class="form-group">
                      <label>รูป : ประกันวินาศภัย</label>
                      <br>
                      <img src="{{ url('img/head/'.$objs->page15) }}" style="width: 300px; border: 2px solid #439aff;" >
                      <br><br>
                      <input type="file" name="page15" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                </div>
                <br>
                <hr>
                <br>
                <div class="form-group">
                      <label>รูป : กองทุนรวม</label>
                      <br>
                      <img src="{{ url('img/head/'.$objs->page16) }}" style="width: 300px; border: 2px solid #439aff;" >
                      <br><br>
                      <input type="file" name="page16" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                </div>
                <br>
                <hr>
                <br>
                <div class="form-group">
                      <label>รูป : หลักทรัพย์</label>
                      <br>
                      <img src="{{ url('img/head/'.$objs->page17) }}" style="width: 300px; border: 2px solid #439aff;" >
                      <br><br>
                      <input type="file" name="page17" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                </div>
                <br>
                <hr>
                <br>
                <div class="form-group">
                      <label>รูป : คลาสสอนการเงินให้เด็กก่อนวัยรุ่น</label>
                      <br>
                      <img src="{{ url('img/head/'.$objs->page18) }}" style="width: 300px; border: 2px solid #439aff;" >
                      <br><br>
                      <input type="file" name="page18" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                </div>
                <br>
                <hr>
                <br>
                <div class="form-group">
                      <label>รูป : คลาสการเงินสำหรับผู้ใหญ่</label>
                      <br>
                      <img src="{{ url('img/head/'.$objs->page19) }}" style="width: 300px; border: 2px solid #439aff;" >
                      <br><br>
                      <input type="file" name="page19" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                </div>
                <br>
                <hr>
                <br>
                <div class="form-group">
                      <label>รูป : คำนวณการเงินแบบง่ายๆ</label>
                      <br>
                      <img src="{{ url('img/head/'.$objs->page20) }}" style="width: 300px; border: 2px solid #439aff;" >
                      <br><br>
                      <input type="file" name="page20" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
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


@stop('content')



@section('scripts')
<script src="{{ url('back/js/file-upload.js') }}"></script>




@stop('scripts')
