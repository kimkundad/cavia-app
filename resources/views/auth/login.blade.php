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
    .ps-section__content p {
        color:#000 
    }
    .ps-section__desc p{
        color:#000 
    }
    .ps-my-account-2 .ps-section__desc {
    border-bottom: 1px solid #eaeaea;
    margin-bottom: 0px;
    padding-bottom: 10px;
}
</style>

@stop('stylesheet')
@section('content')


<div class="ps-page--my-account">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{ url('/') }}">หน้าหลัก</a></li>
                    <li> เข้าสู่ระบบ</li>
                </ul>
            </div>
        </div>
        <div class="ps-my-account-2" style="background-color: #fff; padding: 100px 0px 200px 0px">
            <div class="container">
                <div class="ps-section__wrapper">
                    <div class="ps-section__left">
                        <form class="ps-form--account ps-tab-root" method="POST" action="{{url('login')}}">
                            {{ csrf_field() }}
                            <div class="ps-tabs">
                                <div class="ps-tab active" id="sign-in">
                                    <div class="ps-form__content">
                                        <div class="text-center">
                                            <img src="{{ url('assets/img/LOGO-CV-Line-Orange-Black-01.png') }}" style="height:150px">
                                            <br><br>
                                            <h5>เข้าสู่ระบบบัญชีของคุณ</h5>
                                        </div>
                                        

                                        @error('name')
                                        <div class="alert alert-warning" role="alert">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                        @error('password')
                                        <div class="alert alert-warning" role="alert">
                                            {{ $message }}
                                        </div>
                                        @enderror


                                        <div class="form-group">
                                            <input class="form-control" type="text" name="name" placeholder="บัญชีผู้ใช้งาน">
                                        </div>
                                        <div class="form-group form-forgot">
                                            <input class="form-control" type="password" name="password"  placeholder="รหัสผ่าน"> <!-- <a href="#">ลืมรหัส?</a> -->
                                        </div>
                                        <div class="form-group">
                                            <div class="ps-checkbox">
                                                <input class="form-control" type="checkbox" id="remember-me" name="remember-me">
                                                <label for="remember-me">จดจำฉันไว้ในระบบ</label>
                                            </div>
                                        </div>
                                        <div class="form-group submit">
                                            <button class="ps-btn ps-btn--fullwidth" type="submit">เข้าสู่ระบบ</button>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                    <style>
                        .ps-my-account-2 .ps-section__desc .ps-list li {
    margin-bottom: 0px;
    display: -webkit-box;
    display: flex;
    -webkit-box-align: center;
    align-items: center;
}
.ps-my-account-2 .ps-section__desc p {
    margin-bottom: 15px;
}
                    </style>
                    <div class="ps-section__right">
                        <figure class="ps-section__desc">
                            <figcaption> สิทธิพิเศษสำหรับ Cavia168 </figcaption>
                            <p>ลงทะเบียนวันนี้รับคะแนนแลกของรางวัลได้เลย</p>
                            <ul class="ps-list">
                                <li><img src="{{ url('assets/img/website.png') }}" height="50"><span> เว็บตรง การันตีความมั่นคง อันดับ 1 ในประเทศ</span></li>
                                <li><img src="{{ url('assets/img/gift_con.png') }}" height="50"><span> มีของรางวัลมาให้แลกมากมาย</span></li>
                                <li><img src="{{ url('assets/img/24_Hr.png') }}" height="50"><span> ฝากด่วน ถอนไว บริการ 24 ชั่วโมง</span></li>
                            </ul>
                        </figure>
                      
                        <img src="{{ url('img/setting/'.setting()->banner_login) }}" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
       

    </div>


@endsection

@section('scripts')
@stop('scripts')