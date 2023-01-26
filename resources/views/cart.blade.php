@extends('layouts.template')

@section('title')
เว็บแลกเปลี่ยนของรางวัล - Website
@stop

@section('stylesheet')

@stop('stylesheet')
@section('content')

    <div class="ps-page--simple">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{ url('/') }}">หน้าหลัก</a></li>
                    <li>Cart</li>
                </ul>
            </div>
        </div>

        <div class="ps-section--shopping ps-shopping-cart" style="background-color: #fff;">
            <div class="container">
                <div class="ps-section__header">
                    <h1>Cart</h1>
                </div>
                <div class="ps-section__content">
                    <div class="table-responsive">
                        <table class="table ps-table--shopping-cart">
                            <thead>
                                <tr>
                                    <th>Product name</th>
                                    <th>POINT</th>
                                    <th>QUANTITY</th>
                                    <th>TOTAL</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                $shipping_price = 0;
                                $sum = 0;
                                ?>
                            @if(Session::get('cart') != null)

                            <?php
                                
                                $cart = session()->get('cart');
                                ?>
                                @foreach ($cart as $product_item)
                                <?php
                                    $total += ( $product_item['point']);
                                ?>
                                <tr>
                                    <td>
                                        <div class="ps-product--cart">
                                            <div class="ps-product__thumbnail"><a href="#"><img src="{{ url('assets/img/products/'.$product_item['image']) }}" alt=""></a></div>
                                            <div class="ps-product__content"><a href="#">{{$product_item['name_product']}}</a>
                                               
                                            </div>
                                        </div>
                                    </td>
                                    <td class="price text-center">{{ number_format((float)$product_item['point'], 0, '.', '') }}</td>
                                    <td class="price text-center">
                                        1
                                    </td>
                                    <td class="price text-center">{{ number_format((float)$product_item['point'], 0, '.', '') }}</td>
                                    <td class="price text-center"><a href="{{url('/deleteCart2/'.$product_item['id'])}}"><i class="icon-cross"></i></a></td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">-- ไม่มีสินค้าในตะกร้อ -- </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    
                </div>
                <div class="ps-section__footer">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                            
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                        
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                            <div class="ps-block--shopping-total">
                               
                                <div class="ps-block__content">
                                    
                                    <h3>Total Point<span> {{ number_format((float)$total, 0, '.', '') }}</span></h3>
                                </div>
                            </div><a class="ps-btn ps-btn--fullwidth" href="{{ url('checkout') }}">ดำเนินการถัดไป</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
@stop('scripts')