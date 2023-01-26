@extends('layouts.template')

@section('title')
เว็บแลกเปลี่ยนของรางวัล - Website
@stop

@section('stylesheet')

<style>
    .ps-block__header p {
       color:#000 
    }
    .img-fluid{
        width:100%;
        border-radius:10px;
    }
    .ps-block__content p {
        color:#000 
    }
</style>

@stop('stylesheet')
@section('content')


    <main class="ps-page--my-account">
        <div class="ps-breadcrumb">
            <div class="container">
                
                <ul class="breadcrumb">
                    <li><a href="{{ url('/') }}">หน้าหลัก</a></li>
                    <li><a href="{{ url('/account') }}">Account</a></li>
                    <li>รายละเอียดการแลกเปลี่ยน</li>
                </ul>
            </div>
        </div>

        <section class="ps-section--account" style="background-color: #fff; padding: 100px 0px 200px 0px">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="ps-section__left">
                            <aside class="ps-widget--account-dashboard">
                                <div class="ps-widget__header"><img src="{{ url('/img/avatar/'.Auth::user()->avatar) }}" alt="">
                                    <figure>
                                        <figcaption>Hello</figcaption>
                                        <p><a href="#">{{Auth::user()->name}}</a></p>
                                    </figure>
                                </div>
                                <div class="ps-widget__content">
                                    <ul>
                                        <li><a href="{{ url('account') }}"><i class="icon-user"></i> ข้อมูลบัญชี</a></li>
                                        <li class="active"><a href="{{ url('history') }}"><i class="icon-papers"></i> ประวัติการแลกเปลี่ยน</a></li>
                                        <li><a href="{{ url('my_point') }}"><i class="icon-papers"></i> สะสมแต้ม</a></li>
                                        <li><a href="{{ url('logout') }}"><i class="icon-power-switch"></i>ออกจากระบบ</a></li>
                                    </ul>
                                </div>
                            </aside>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        
                    <div class="ps-section__right">
                            <div class="ps-section--account-setting">
                                <div class="ps-section__header">
                                    <h3>Invoice #{{ $objs->order_no }} -<strong> @if($objs->status == 0)
                                                    <td class="text-warning">
                                                    รอเจ้าหน้าที่ตรวจสอบ
                                                    </td>
                                                    @endif
                                                    @if($objs->status == 1)
                                                    <td class="text-warning">
                                                    อยู่ระหว่างการจัดส่ง
                                                    </td>
                                                    @endif
                                                    @if($objs->status == 2)
                                                    <td class="text-success">
                                                    จัดสั่งสำเร็จ
                                                    </td>
                                                    @endif
                                                    @if($objs->status == 3)
                                                    <td class="text-danger">
                                                    คืนสินค้า
                                                    </td>
                                                    @endif </strong></h3>
                                </div>
                                <div class="ps-section__content">
                                    <div class="row">
                                        <div class="col-md-4 col-12">
                                            <figure class="ps-block--invoice">
                                                <figcaption>ที่อยู่จัดส่ง</figcaption>
                                                <div class="ps-block__content"><strong> นาย {{ $objs->name_order }}</strong>
                                                    <p>Address: {{ $objs->address }} </p>
                                                    <p>Phone: {{ $objs->telephone_order }}</p>
                                                </div>
                                            </figure>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <figure class="ps-block--invoice">
                                                <figcaption>การจัดส่ง</figcaption>
                                                <div class="ps-block__content">
                                                    <p>{{ $objs->shipping }}</p>
                                                </div>
                                            </figure>
                                            <figure class="ps-block--invoice">
                                                <figcaption>วันที่แลก</figcaption>
                                                <div class="ps-block__content">
                                                    <p>{{ formatDateThat($objs->created_at) }}</p>
                                                </div>
                                            </figure>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <figure class="ps-block--invoice">
                                                <figcaption>เลขพัสุดุ</figcaption>
                                                <div class="ps-block__content">
                                                    <p>{{ $objs->track_no }}</p>
                                                </div>
                                            </figure>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table ps-table">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Point</th>
                                                    <th>จำนวน</th>
                                                    <th>Point คงเหลือ</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            @if(isset($objs2))
                                            @foreach($objs2 as $u)
                                                <tr>
                                                    <td>
                                                        <div class="ps-product--cart">
                                                            <div class="ps-product__thumbnail"><a href="#"><img src="{{ url('assets/img/products/'.$u->pro_image) }}" alt=""></a></div>
                                                            <div class="ps-product__content"><a href="#">{{ $u->pro_name }}</a>
                                                              
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><span> {{ number_format((float)$u->pro_point, 0, '.', '') }}</span></td>
                                                    <td>{{ $u->amount }}</td>
                                                    <td><span> {{ number_format((float)$objs->old_point, 0, '.', '') }}</span></td>
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
                </div>
            </div>
        </section>

        

    </main>


@endsection

@section('scripts')
@stop('scripts')