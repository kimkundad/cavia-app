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
    .card-yello{
        width: 100%;
    height: 100%;
    text-align: center;
    background-image: linear-gradient(to bottom, #ffbc01 0%, #f87f01 100%);
    border-radius: 0.125rem;
    padding: 15px;
    isolation: isolate;
    border-radius: 15px;
    }
    .text-white{
        color: #fff;
    }
    .pcmall{
        font-family: 'Kanit', sans-serif;
        width: 46px;
        margin: 5px
    }
    .pcmall-dailycheckin{
        
        width: 100%;
        text-align: center;
        border-radius: 4px;
        background-color: #f5f5f5;
        position: relative;
        margin-bottom: 8px;
        padding:5px
    }
    .card-wh{
        background-color: #fff;
    box-shadow: 0px 0px 9px rgb(0 0 0 / 12%);
    border-radius: 10px;
    padding: 1.25rem 0;
    margin-top: 0.75rem;
    }
    .pcmall-point{
        font-size: 14px;
        font-weight: 600;
    }
    .mt-10{
        margin-top: 10px;
        margin-bottom: 10px;
    }
    .pcmall-dailycheckin_btn{
        font-family: 'Kanit', sans-serif;
        display: block;
    border-radius: 1.875rem;
    border: none;
    color: #fff;
    font-weight: 500;
    background: none;
    background-color: #ee4d2d;
    font-size: 14px;
    padding: 5px 20px;
    margin: 1.25rem auto 0;
    }
    .pcmall .active{
        color: #ee4d2d;
        background-color: #fef6f5;
    border: 1px solid #ee4d2d;
    }

    @media (max-width: 479px) {
        .card-yello{
        width: 100%;
    height: 100%;
    text-align: center;
    background-image: linear-gradient(to bottom, #ffbc01 0%, #f87f01 100%);
    border-radius: 0.125rem;
    padding: 15px 8px;
    isolation: isolate;
    border-radius: 15px;
    }

        .pcmall{
        font-family: 'Kanit', sans-serif;
        width: 42px;
        margin: 2px
    }
    .pcmall span{
        font-family: 'Kanit', sans-serif;
        font-size: 12px;
    }
    .chakra-coin {
    width: 20px;
    height: 20px;
}
    .pcmall-dailycheckin{
        
        width: 100%;
        text-align: center;
        border-radius: 4px;
        background-color: #f5f5f5;
        position: relative;
        margin-bottom: 8px;
        padding:5px
    }
    .card-wh{
        background-color: #fff;
    box-shadow: 0px 0px 9px rgb(0 0 0 / 12%);
    border-radius: 10px;
    padding: 1.25rem 0;
    margin-top: 0.75rem;
    }
    .pcmall-point{
        font-size: 11px;
        font-weight: 600;
    }
    .mt-10{
        margin-top: 10px;
        margin-bottom: 10px;
    }
    .pcmall-dailycheckin_btn{
        font-family: 'Kanit', sans-serif;
        display: block;
    border-radius: 1.875rem;
    border: none;
    color: #fff;
    font-weight: 500;
    background: none;
    background-color: #ee4d2d;
    font-size: 14px;
    padding: 5px 20px;
    margin: 1.25rem auto 0;
    }

    }

    .pcmall-dailycheckin_btn[data-inactive=true] {
    color: rgba(0,0,0,.5);
    background-color: #f6f6f6;
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
                    <li>เช็คอินทุกวันเพื่อรับ Points</li>
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
                                        <li><a href="{{ url('history') }}"><i class="icon-papers"></i> ประวัติการแลกเปลี่ยน</a></li>
                                        <li><a href="{{ url('my_point') }}"><i class="icon-papers"></i> สะสมแต้ม</a></li>
                                        {{-- <li class="active"><a href="{{ url('point_rewards') }}"><img src="{{ url('/img/coin.png') }}" class="chakra-coin">  Point Rewards</a></li> --}}
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
                                    <h3><img src="{{ url('/img/coin.png') }}" class="chakra-coin"> เช็คอินทุกวันเพื่อรับ Points</h3>
                                </div>
                                <div class="ps-section__content">
                                    
                                <div class="card-yello text-center">
                                    <h4 class="text-white">Cavia168 Point Rewards</h4>
                                    <div class="d-flex justify-content-center">
                                        <img src="{{ url('/img/coin.png') }}" style="height: 40px; margin-right:15px">
                                        <h2 class="text-white" id="my_point_old">{{number_format((float)Auth::user()->point, 0, '.', '')}}</h2>
                                    </div>
                                    
                                    <div class="card-wh">
                                        <div class="d-flex justify-content-center">
                                            <div class="pcmall">
                                                <div class="pcmall-dailycheckin 
                                                @if($check_point_day == 0 || $check_point_day > 0)
                                                active
                                                @endif
                                                ">
                                                    <div class="pcmall-point">
                                                        +{{first_day()}}
                                                    </div>
                                                    <img src="{{ url('/img/coin.png') }}" class="chakra-coin mt-10">
                                                </div>
                                                <span>วันที่ 1</span>
                                            </div>
                                            <div class="pcmall">
                                                <div class="pcmall-dailycheckin 
                                                @if($next_day > 1)
                                                active
                                                @endif
                                                ">
                                                    <div class="pcmall-point">
                                                        +{{mid_day()}}
                                                    </div>
                                                    <img src="{{ url('/img/coin.png') }}" class="chakra-coin mt-10">
                                                </div>
                                                <span>วันที่ 2</span>
                                            </div>
                                            <div class="pcmall">
                                                <div class="pcmall-dailycheckin
                                                @if($next_day > 2)
                                                active
                                                @endif
                                                ">
                                                    <div class="pcmall-point">
                                                        +{{mid_day()}}
                                                    </div>
                                                    <img src="{{ url('/img/coin.png') }}" class="chakra-coin mt-10">
                                                </div>
                                                <span>วันที่ 3</span>
                                            </div>
                                            <div class="pcmall">
                                                <div class="pcmall-dailycheckin
                                                @if($next_day > 3)
                                                active
                                                @endif
                                                ">
                                                    <div class="pcmall-point">
                                                        +{{mid_day()}}
                                                    </div>
                                                    <img src="{{ url('/img/coin.png') }}" class="chakra-coin mt-10">
                                                </div>
                                                <span>วันที่ 4</span>
                                            </div>
                                            <div class="pcmall">
                                                <div class="pcmall-dailycheckin
                                                @if($next_day > 4)
                                                active
                                                @endif
                                                ">
                                                    <div class="pcmall-point">
                                                        +{{mid_day()}}
                                                    </div>
                                                    <img src="{{ url('/img/coin.png') }}" class="chakra-coin mt-10">
                                                </div>
                                                <span>วันที่ 5</span>
                                            </div>
                                            <div class="pcmall">
                                                <div class="pcmall-dailycheckin
                                                @if($next_day > 5)
                                                active
                                                @endif
                                                ">
                                                    <div class="pcmall-point">
                                                        +{{mid_day()}}
                                                    </div>
                                                    <img src="{{ url('/img/coin.png') }}" class="chakra-coin mt-10">
                                                </div>
                                                <span>วันที่ 6</span>
                                            </div>
                                            <div class="pcmall">
                                                <div class="pcmall-dailycheckin
                                                @if($next_day == 7 || $check_point_day == 7)
                                                active
                                                @endif
                                                ">
                                                    <div class="pcmall-point">
                                                        +{{last_day()}}
                                                    </div>
                                                    <img src="{{ url('/img/coin.png') }}" class="chakra-coin mt-10">
                                                </div>
                                                <span>วันที่ 7</span>
                                            </div>
                                        </div>
                                        <button class="pcmall-dailycheckin_btn" id="dailycheckin_btn" 
                                        @if($check_point == 0)
                                        data-inactive="false"
                                        @else
                                        data-inactive="true"
                                        @endif
                                        > เช็คอินทุกวันเพื่อรับ Point </button>
                                    </div>


                                </div>

                                    
                                    
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

<script>

const PostPoint = async() => {
  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
        }
    });
    try {
      var result;
    await $.ajax({
            type: "GET",
            url: "{{url('api/addPointCheckin')}}",
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            dataType: 'json',
            success: function (data) {

              result = data;
              
            }
        });
        return result;
      } catch (err) {
        console.log(err);
    }

}

    var my_coints;
    var my_cointsxx;
    var my_point_old;
    let spinBtn = document.getElementById("dailycheckin_btn");

    @if($check_point == 0)
    spinBtn.disabled = false;
    @else
    spinBtn.disabled = true;
    spinBtn.innerText = "แวะเข้ามาอีกพรุ่งนี้ รับเลย "+ {{ $point_return }} +" coins";
    @endif

    spinBtn.addEventListener("click", () => {

        PostPoint().then(function(res) {
        spinBtn.disabled = true;

        my_coints = document.getElementById("my_coints").innerText;
        my_cointsxx = document.getElementById("my_cointsxx").innerText;
        my_point_old = document.getElementById("my_point_old").innerText;
        document.getElementById("my_coints").innerHTML = '';
        document.getElementById("my_coints").innerHTML = parseInt(my_coints)+(res.point_return);
        document.getElementById("my_cointsxx").innerHTML = '';
        document.getElementById("my_cointsxx").innerHTML = parseInt(my_coints)+(res.point_return);
        document.getElementById("my_point_old").innerHTML = '';
        document.getElementById("my_point_old").innerHTML = parseInt(my_coints)+(res.point_return);

        spinBtn.innerText = "แวะเข้ามาอีกพรุ่งนี้ รับเลย "+res.next_point+" coins";
        document.getElementById("dailycheckin_btn").setAttribute('data-inactive', true);

        });

    });

</script>

@stop('scripts')