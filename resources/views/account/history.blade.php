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
</style>

@stop('stylesheet')
@section('content')


    <main class="ps-page--my-account">
        <div class="ps-breadcrumb">
            <div class="container">
                
                <ul class="breadcrumb">
                    <li><a href="{{ url('/') }}">หน้าหลัก</a></li>
                    <li><a href="{{ url('/account') }}">Account</a></li>
                    <li>ประวัติการแลกเปลี่ยน</li>
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
                                    <h3>ประวัติการแลกเปลี่ยน</h3>
                                </div>
                                <div class="ps-section__content">
                                    <div class="table-responsive">
                                        <table class="table ps-table ps-table--invoices">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>วันที่แลก</th>
                                                    <th>สินค้า</th>
                                                    <th>point</th>
                                                    <th>Status</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            @if(isset($objs))
                                            @foreach($objs as $u)
                                                <tr>
                                                    <td><a href="{{ url('invoice_detail/'.$u->order_no) }}" class="text-primary">{{ $u->order_no }}</a></td>
                                                    <td>{{ formatDateThat($u->created_at) }}</td>
                                                    <td><a href="{{ url('invoice_detail/'.$u->order_no) }}">

                                                    @if(isset($u->option))
                                                        @foreach($u->option as $j)
                                                        {{ $j->pro_name }},
                                                        @endforeach
                                                    @endif
                                                    
                                                    </a></td>
                                                    
                                                    <td>{{ number_format((float)$u->sum_point, 0, '.', '') }}</td>
                                                    
                                                        
                                                    @if($u->status == 0)
                                                    <td class="text-warning">
                                                        รอเจ้าหน้าที่ตรวจสอบ
                                                    </td>
                                                    @endif
                                                    @if($u->status == 1)
                                                    <td class="text-warning">
                                                    อยู่ระหว่างการจัดส่ง
                                                    </td>
                                                    @endif
                                                    @if($u->status == 2)
                                                    <td class="text-success">
                                                    จัดสั่งสำเร็จ
                                                    </td>
                                                    @endif
                                                    @if($u->status == 3)
                                                    <td class="text-danger">
                                                    คืนสินค้า
                                                    </td>
                                                    @endif

                                                    <td>
                                                        <a class="ps-btn" href="{{ url('invoice_detail/'.$u->order_no) }}" style="padding: 5px 15px;font-size: 12px;">ดูข้อมูล</a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @endif
                                                
                                                
                                            </tbody>
                                        </table>
                                    </div>

                                    @if(count($objs) > 15)
                                    @include('pagination.default', ['paginator' => $objs])
                                    @endif
                                    
                                </div>
                            </div>

                            <br>
                            <img src="{{ url('img/setting/'.setting()->banner_his) }}" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        

    </main>


@endsection

@section('scripts')
@stop('scripts')