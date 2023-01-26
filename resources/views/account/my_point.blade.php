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
                                        <li ><a href="{{ url('history') }}"><i class="icon-papers"></i> ประวัติการแลกเปลี่ยน</a></li>
                                        <li class="active"><a href="{{ url('my_point') }}"><i class="icon-papers"></i> สะสมแต้ม</a></li>
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
                                    <h3>สะสมแต้ม</h3>
                                </div>
                                <div class="ps-section__content">
                                    <div class="table-responsive">
                                        <table class="table ps-table ps-table--invoices">
                                            <thead>
                                                <tr>
                                                    <th>วันที่</th>
                                                    <th>เทริร์นโอเวอร์</th>
                                                    <th>Point</th>
                                                    <th>คะแนนรวม (ล่าสุด)</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            @if(isset($objs))
                                            @foreach($objs as $u)
                                                <tr>
                                                    
                                                    <td>{{ ($u->date) }}</td>

                                                    <td>
                                                    @if($u->type == 1)
                                                        {{ $u->detail }}
                                                        @elseif($u->type == 2)
                                                        {{ $u->detail }}
                                                        @else
                                                        {{ number_format((float)$u->total_valid_bet_amount, 0, '.', '') }}
                                                        @endif
                                                        
                                                    </td>

                                                    <td>
                                                        @if($u->type == 1)
                                                       <span class="text-danger"> - {{ number_format((float)$u->point, 0, '.', '') }} </span>
                                                        @else
                                                        <span class="text-success">+ {{ number_format((float)$u->point, 0, '.', '') }} </span>
                                                        @endif
                                                        
                                                    </td>
                                                    <td>{{ number_format((float)$u->last_point, 0, '.', '') }}</td>
                                                    
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
                            <img src="{{ url('img/setting/'.setting()->banner_point) }}" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        

    </main>


@endsection

@section('scripts')
@stop('scripts')