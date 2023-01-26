@extends('layouts.template')

@section('title')
เว็บแลกเปลี่ยนของรางวัล - Website
@stop

@section('stylesheet')

<style>
    .ps-block__header p {
       color:#000 
    }
</style>

@stop('stylesheet')
@section('content')

    <div class="ps-page--simple">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{ url('/') }}">หน้าหลัก</a></li>
                    <li>Checkout</li>
                </ul>
            </div>
        </div>

        <div class="ps-checkout ps-section--shopping" style="background-color: #fff;">
            <div class="container">
                <div class="ps-section__header">
                    <h1>Checkout</h1>
                </div>
                <div class="ps-section__content">
                    <form  method="POST"  action="{{url('add_my_order')}}">
                                {{ csrf_field() }}
                        <div class="row">
                            <div class="col-xl-7 col-lg-8 col-md-12 col-sm-12  ">
                                <div class="ps-form__billing-info">
                                    <h3 class="ps-form__heading">กรอกรายละเอียดการรับสินค้า</h3>
                                    <div class="form-group">
                                        <label>ชื่อ-นามสกุล ผู้รับสินค้า<sup>*</sup>
                                        </label>
                                        <div class="form-group__content">
                                            <input class="form-control" type="text" name="name_order">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>เบอร์โทรศัพท์<sup>*</sup>
                                        </label>
                                        <div class="form-group__content">
                                            <input class="form-control" type="text" name="telephone_order">
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    <div class="form-group">
                                        <label>ที่อยู่ในการจัดส่ง<sup>*</sup>
                                        </label>
                                        <div class="form-group__content">
                                        <textarea class="form-control" rows="4" name="address" placeholder="บ้านเลขที่ เขต จังหวัด รหัสไปรษณีย์..."></textarea>
                                        </div>
                                    </div>
                                 
                                    <h3 class="mt-40"> ข้อมูลเพิ่มเติม</h3>
                                    <div class="form-group">
                                        <label>หมายเหตุการสั่งซื้อ</label>
                                        <div class="form-group__content">
                                            <textarea class="form-control" rows="7" name="note" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-5 col-lg-4 col-md-12 col-sm-12  ">
                                <div class="ps-form__total">
                                    <h3 class="ps-form__heading">รายการแลกของคุณ</h3>
                                    <div class="content">
                                        <div class="ps-block--checkout-total">
                                            
                                            <div class="ps-block__content">

                                            <?php
                                $total = 0;
                                $shipping_price = 0;
                                $sum = 0;
                                ?>

                                                <table class="table ps-block__products">

                                                <thead>
                                                    <tr>
                                                    <th scope="col">Product</th>
                                                    <th scope="col">Total</th>
                                                    </tr>
                                                </thead>
                                                    <tbody>
                                                    @if(Session::get('cart') != null)
                                                    <?php
                                
                                                        $cart = session()->get('cart');
                                                        ?>
                                                        @foreach ($cart as $product_item)
                                                        <?php
                                                            $total += ( $product_item['point']);
                                                        ?>
                                                        <tr>
                                                            <td><a href="#"> {{$product_item['name_product']}}</a>
                                                            </td>
                                                            <td>{{ number_format((float)$product_item['point'], 0, '.', '') }}</td>
                                                        </tr>
                                                        @endforeach
                                                        @endif
                                                        
                                                    </tbody>
                                                </table>
                                               
                                             
                                                <h3>Total Point<span> {{ number_format((float)$total, 0, '.', '') }}</span></h3>
                                            </div>
                                            <input class="form-control" type="hidden" name="total" value="{{ $total }}">
                                        </div><button type="submit" class="ps-btn ps-btn--fullwidth" href="{{ url('payment_success') }}">แลกของรางวัล</button>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
@stop('scripts')