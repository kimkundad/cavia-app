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
                    <li>ประวัติการแลก Credit</li>
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
                                        <li class=""><a href="{{ url('history') }}"><i class="icon-papers"></i> ประวัติการแลกเปลี่ยน</a></li>
                                        <li class="active"><a href="{{ url('changeCredit') }}"><i class="icon-papers"></i> ประวัติการแลก Credit</a></li>
                                        <li><a href="{{ url('my_point') }}"><i class="icon-papers"></i> สะสมแต้ม</a></li>
                                        {{-- <li><a href="{{ url('point_rewards') }}"><img src="{{ url('/img/coin.png') }}" class="chakra-coin">  Point Rewards</a></li> --}}
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
                                    <h3>ประวัติการแลก Credit</h3>
                                </div>
                                <div class="ps-section__content">
                                    <div class="table-responsive">
                                        <table class="table ps-table ps-table--invoices">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>วันที่แลก</th>
                                                    <th>ชื่อ credit</th>
                                                    <th>credit</th>
                                                    <th>point</th>
                                                    <th>point ของฉันล่าสุด</th>
                                                    <th>สถานะ</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            @if(isset($objs))
                                            @foreach($objs as $u)
                                                <tr>
                                                    <td>#{{ $u->id }}</td>
                                                    <td>{{ $u->created_at }}</td>

                                                    <td>{{ $u->product->name }}</td>
                                                    <td>{{ $u->credit }}</td>
                                                    <td>{{ $u->point }}</td>
                                                    <td>{{ $u->lastPoint }}</td>
                                                    @if($u->status == 0)
                                                    <td class="text-warning">
                                                        รอเจ้าหน้าที่ตรวจสอบ
                                                    </td>
                                                    @endif
                                                    @if($u->status == 1)
                                                    <td class="text-success">
                                                    สำเร็จ
                                                    </td>
                                                    @endif


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


                        </div>
                    </div>
                </div>
            </div>
        </section>



    </main>


@endsection

@section('scripts')
@stop('scripts')
