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
      <h4 class="card-title">ข้อมูล รายการแลกของ</h4>
      

      <form class="forms-sample" method="POST" action="{{$url}}" enctype="multipart/form-data">
        {{ method_field($method) }}
        {{ csrf_field() }}
        <div class="form-group">
          <label for="exampleInputUsername1">Order No. </label>
          <input type="text" class="form-control" value="{{ $objs->order_no }}" readonly>
        </div>

        <div class="form-group">
          <label for="exampleInputUsername1">ชื่อผู้รับสินค้า </label>
          <input type="text" class="form-control" value="{{ $objs->name_order }}" name="name_order">
        </div>

        <div class="form-group">
          <label for="exampleInputUsername1">เบอร์ติดต่อ </label>
          <input type="text" class="form-control" value="{{ $objs->telephone_order }}" name="telephone_order">
        </div>

        <div class="form-group">
          <label for="exampleInputUsername1">ที่อยู่จัดส่ง </label>
          <textarea class="form-control" name="address" rows="4">{{ $objs->address }}</textarea>
        </div>

        <div class="form-group">
          <label for="exampleInputUsername1">เลขพัสุดุ </label>
          <input type="text" class="form-control"  name="track_no" value="{{ $objs->track_no }}">
        </div>

        <div class="form-group">
          <label for="exampleInputUsername1">พอยท์ที่ใช้ </label>
          <input type="text" class="form-control"  name="point" value="{{ $objs->sum_point }}" readonly>
        </div>

        <div class="form-group">
          <label for="exampleInputUsername1">การจัดส่ง </label>
          <select class="form-control" name="shipping">
                <option value="ยังไม่ระบุ" @if( $objs->shipping == null)
                                        selected='selected'
                                        @endif>ยังไม่ระบุ</option>
                                        <option value="ไปรษณีย์ไทย" @if( $objs->shipping == 'ไปรษณีย์ไทย')
                                        selected='selected'
                                        @endif>ไปรษณีย์ไทย</option>
                                        <option value="SCG EXPRESS" @if( $objs->shipping == 'SCG EXPRESS')
                                        selected='selected'
                                        @endif>SCG EXPRESS</option>
                                        <option value="Lalamove" @if( $objs->shipping == 'Lalamove')
                                        selected='selected'
                                        @endif>Lalamove</option>
                                        <option value="Kerry Express" @if( $objs->shipping == 'Kerry Express')
                                        selected='selected'
                                        @endif>Kerry Express</option>
                                        <option value="Lineman" @if( $objs->shipping == 'Lineman')
                                        selected='selected'
                                        @endif>Lineman</option>
                                        <option value="Grab Express" @if( $objs->shipping == 'Grab Express')
                                        selected='selected'
                                        @endif>Grab Express</option>
                                        <option value="DHL Express" @if( $objs->shipping == 'DHL Express')
                                        selected='selected'
                                        @endif>DHL Express</option>
                                        <option value="Ninja Van" @if( $objs->shipping == 'Ninja Van')
                                        selected='selected'
                                        @endif>Ninja Van</option>
                                        <option value="Skootar" @if( $objs->shipping == 'Skootar')
                                        selected='selected'
                                        @endif>Skootar</option>
                                        <option value="SHOPEE" @if( $objs->shipping == 'SHOPEE')
                                        selected='selected'
                                        @endif>SHOPEE</option>
                                        <option value="J&T" @if( $objs->shipping == 'J&T')
                                        selected='selected'
                                        @endif>J&T</option>
            </select>
        </div>


        <div class="form-group">
          <label for="exampleInputUsername1">สถานะการจัดส่ง </label>
          <select class="form-control" name="status">
                <option value="0" @if( $objs->status == 0)
                                        selected='selected'
                                        @endif>รอเจ้าหน้าที่ตรวจสอบ</option>
                                        <option value="1" @if( $objs->status == 1)
                                        selected='selected'
                                        @endif>อยู่ระหว่างการจัดส่ง</option>
                                        <option value="2" @if( $objs->status == 2)
                                        selected='selected'
                                        @endif>จัดสั่งสำเร็จ</option>
                                        <option value="3" @if( $objs->status == 3)
                                        selected='selected'
                                        @endif>คืนสินค้า</option>
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
      <h4 class="card-title">ข้อมูล สินค้า</h4>

      <div class="table-responsive">
                                        <table class="table ps-table">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Point</th>
                                                    <th>จำนวน</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            @if(isset($detail))
                                            @foreach($detail as $u)
                                                <tr>
                                                    <td>
                                                        <div class="ps-product--cart">
                                                            <div class="ps-product__thumbnail"><a href="{{ url('admin/product/'.$u->pro_id.'/edit') }}"><img src="{{ url('assets/img/products/'.$u->pro_image) }}" alt=""></a></div>
                                                            <div class="ps-product__content"><a href="{{ url('admin/product/'.$u->pro_id.'/edit') }}">{{ $u->pro_name }}</a>
                                                              
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><span> {{ number_format((float)$u->pro_point, 0, '.', '') }}</span></td>
                                                    <td>{{ $u->amount }}</td>
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
<br><br><br><br><br><br><br><br>


@endsection

@section('scripts')


<script>



</script>
@stop('scripts')