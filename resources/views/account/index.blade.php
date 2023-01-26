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
                    <li>Account</li>
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
                                        <li class="active"><a href="{{ url('account') }}"><i class="icon-user"></i> ข้อมูลบัญชี</a></li>
                                        <li><a href="{{ url('history') }}"><i class="icon-papers"></i> ประวัติการแลกเปลี่ยน</a></li>
                                        <li><a href="{{ url('my_point') }}"><i class="icon-papers"></i> สะสมแต้ม</a></li>
                                        <li><a href="{{ url('logout') }}"><i class="icon-power-switch"></i>ออกจากระบบ</a></li>
                                    </ul>
                                </div>
                            </aside>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="ps-section__right">
                            <form class="ps-form--account-setting" action="{{url('update_user')}}" method="post">
                            {{ csrf_field() }}
                                <div class="ps-form__header">
                                    <h3>ข้อมูลบัญชีผู้ใช้งาน</h3>
                                </div>
                                <div class="ps-form__content">
                                    <div class="form-group">
                                        <label>ชื่อผู้ใช้งาน</label>
                                        <input class="form-control" name="name" value="{{ Auth::user()->name }}" type="text" placeholder="Please enter your name...">
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>หมายเลขโทรศัพท์</label>
                                                <input class="form-control" name="phone" value="{{ Auth::user()->phone }}" type="text" placeholder="Please enter phone number...">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input class="form-control" name="email" value="{{ Auth::user()->email }}" type="text" placeholder="Please enter your email..." >
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>วันเกิด</label>
                                                <input class="form-control" name="birthday" value="{{ Auth::user()->birthday }}" type="text" placeholder="Please enter your birthday...">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>เพศ</label>
                                                <select class="form-control" name="shop_id">
                                                    <option @if( Auth::user()->shop_id == 0)
                              selected='selected'
                              @endif> เลือกเพศ </option>
                                                    <option value="1" @if( Auth::user()->shop_id == 1)
                              selected='selected'
                              @endif>ชาย</option>
                                                    <option value="2" @if( Auth::user()->shop_id == 2)
                              selected='selected'
                              @endif>หญิง</option>
                                                    <option value="3" @if( Auth::user()->shop_id == 3)
                              selected='selected'
                              @endif>ไม่ระบุ</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group submit">
                                    <button type="submit" class="ps-btn">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        

    </main>


@endsection

@section('scripts')
@stop('scripts')