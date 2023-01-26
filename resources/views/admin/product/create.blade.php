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
      <h4 class="card-title">ข้อมูลสินค้า</h4>
      <p class="card-description">
        กรอกข้อมูลให้ครบ ในส่วนที่มีเครื่องหมาย <span class="text-danger">*</span>
      </p>

      <form class="forms-sample" method="POST" action="{{$url}}" enctype="multipart/form-data">
        {{ method_field($method) }}
        {{ csrf_field() }}
        <div class="form-group">
          <label for="exampleInputUsername1">ชื่อสินค้า <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="exampleInputUsername1" name="name" value="{{ old('name') }}">
        </div>

        <div class="form-group">
          <label for="exampleInputUsername1">พอยท์ <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="exampleInputUsername1" name="point" value="{{ old('point') }}">
        </div>

        <div class="form-group">
          <label for="exampleInputUsername1">จำนวนสินค้า <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="exampleInputUsername1" name="stock" value="{{ old('stock') }}">
        </div>

        <div class="form-group">
          <label for="exampleInputEmail1">รายละเอียด <span class="text-danger">*</span></label>
          <textarea class="summernote form-control" id="textareaAutosize" name="detail" >{{ old('detail') }}</textarea>
        </div>

        <div class="form-group">
          <br />
          <label for="exampleInputUsername1">รูปบสินค้า <span class="text-danger">*</span></label>
          <input type="file" class="dropify"  name="image" />
          <br />
        </div>

        <div class="form-group">
            <label for="exampleFormControlSelect2">กลุ่มสินค้า </label>
            <select class="form-control" name="status_2">
                <option value="0">รางวัลยอดนิยม</option>
                <option value="1">รางวัลสุดพรีเมี่ยม</option>
            </select>
        </div>

    
        
        
        <br />


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



@endsection

@section('scripts')


<script>

$(document).ready(function() {
  $('.summernote').summernote({
    fontSizes: ['8', '9', '10', '11', '12', '14', '18', '24', '36', '48' , '64', '82', '150'],
    fontNames: ['Arial', 'Prompt', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact', 'Tahoma', 'Times New Roman', 'Verdana', 'Roboto'],
    height: 550,
    toolbar: [
    // [groupName, [list of button]]
    ['style', ['bold', 'italic', 'underline', 'clear']],
    ['font', ['strikethrough', 'superscript', 'subscript']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['height', ['height']]
  ],
    popover: {
            image: [
                ['custom', ['imageAttributes']],
                ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                ['float', ['floatLeft', 'floatRight', 'floatNone']],
                ['remove', ['removeMedia']]
            ],
        },
        imageAttributes:{
            icon:'<i class="note-icon-pencil"/>',
            removeEmpty:false, // true = remove attributes | false = leave empty if present
            disableUpload: false // true = don't display Upload Options | Display Upload Options
        },
  callbacks: {
  onImageUpload: function(image) {
  editor = $(this);
  uploadImageContent(image[0], editor);
  }
  }
});



  function uploadImageContent(image, editor) {
    var data = new FormData();
    data.append("image", image);
    $.ajax({
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        url: "{{ url('api/upload_img') }}",
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        type: "post",
        success: function(url) {
        var image = $('<img>').attr({src: url, width: '100%'});
        $(editor).summernote("insertNode", image[0]);
        },
        error: function(data) {
        console.log(data);
        }
    });
  }



});

</script>
@stop('scripts')