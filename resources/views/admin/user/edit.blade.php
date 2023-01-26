@extends('admin.layouts.template')

@section('ga')
window.gaTitle = 'หน้าแรก';
@endsection

@section('stylesheet')

@stop('stylesheet')

@section('content')



<div class="row">

<div class="col-md-6">
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
          <input type="text" class="form-control" id="exampleInputUsername1" name="name" value="{{ $objs->name }}">
        </div>

        <div class="form-group">
          <label for="exampleInputUsername1">Key User <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="exampleInputUsername1" name="phone" value="{{ $objs->phone }}">
        </div>

        <div class="form-group">
          <label for="exampleInputUsername1">พอยท์ <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="exampleInputUsername1" name="point" value="{{ $objs->point }}">
        </div>


        <div class="form-group">
          <label for="exampleInputUsername1">รหัสผ่าน ( 8 ตัวขึ้นไป ) <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="exampleInputUsername1" name="password" value="{{ $objs->code_user }}">
        </div>

        <div class="form-group">
            <label for="exampleFormControlSelect2"> Role User </label>
            <select class="form-control" name="status_2">
                <option value="0" @if( $cat2->role_id == 3)
                                        selected='selected'
                                        @endif>ผู้ใช้งานทั่วไป</option>
                <option value="1" @if( $cat2->role_id == 1)
                                        selected='selected'
                                        @endif>แอดมิน</option>
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




<div class="col-md-6">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">เพิ่ม เทริร์นโอเวอร์ ผู้ใช้งาน</h4>

      <form class="forms-sample" method="POST" action="{{ url('admin/add_point_user/'.$objs->phone) }}" enctype="multipart/form-data">
        {{ csrf_field() }}

                                        @error('date')
                                        <div class="alert alert-warning" role="alert">
                                            กรุณาใส่วันที่
                                        </div>
                                        @enderror
                                        @error('phone')
                                        <div class="alert alert-warning" role="alert">
                                            กรุณาใส่ Key User
                                        </div>
                                        @enderror
                                        @error('xpoint')
                                        <div class="alert alert-warning" role="alert">
                                        กรุณาใส่พอยท์
                                        </div>
                                        @enderror

        <div class="form-group">
        <h4 class="card-title">วันที่เพิ่ม เทริร์นโอเวอร์</h4>
                      <div id="datepicker-popup" class="input-group date datepicker" data-date-format="yyyy-mm-dd">
                        <input type="text" name="date" class="form-control">
                        <span class="input-group-addon input-group-append border-left">
                          <span class="icon-calendar input-group-text"></span>
                        </span>
                      </div>
        </div>

        <div class="form-group">
          <label for="exampleInputUsername1">Key User <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="exampleInputUsername1" name="phone" value="{{ $objs->phone }}">
          <input type="hidden" class="form-control" id="exampleInputUsername1" name="myid" value="{{ $objs->id }}">
        </div>

        <div class="form-group">
          <label for="exampleInputUsername1">เทริร์นโอเวอร์ ที่ต้องการเพิ่ม<span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="exampleInputUsername1" name="xpoint" >
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




<div class="col-md-12">
  <br><br>
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">ข้อมูลการสะสมแต้ม</h4>

      
      <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>วันที่</th>
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
                          <td>@if($u->type == 1)
                                                        {{ $u->detail }}
                                                        @elseif($u->type == 2)
                                                        {{ $u->detail }}
                                                        @else
                                                        {{ number_format((float)$u->total_valid_bet_amount, 0, '.', '') }}
                                                        @endif
                                                      
                                                      </td>
                          <td> @if($u->type == 1)
                                                       <span class="text-danger"> - {{ number_format((float)$u->point, 0, '.', '') }} </span>
                                                        @else
                                                        <span class="text-success">+ {{ number_format((float)$u->point, 0, '.', '') }} </span>
                                                        @endif</td>
                          <td>{{ $u->last_point }}</td>
                          <td><a href="{{ url('api/del_point_user/'.$u->id) }}" onclick="return confirm('Are you sure?')" class="btn btn-outline-danger btn-sm">ลบ</a></td>
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