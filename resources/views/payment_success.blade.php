@extends('layouts.template')

@section('title')
เว็บแลกเปลี่ยนของรางวัล - Website
@stop

@section('stylesheet')

<style>
    .ps-block--payment-success p {
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
                    <li>Orders Success</li>
                </ul>
            </div>
        </div>
        <section class="ps-section--account" style="background-color: #fff;">
            <div class="container">
                <div class="ps-block--payment-success" style="padding-bottom:200px">
                <br><br>
                    <h3>Orders Success !</h3>
                    <p>ขอบคุณสำหรับการแลกของรางวัลของคุณ กรุณาเยี่ยมชม <a href="{{ url('invoice_detail/'.$obj) }}">ที่นี่</a> เพื่อตรวจสอบสถานะการสั่งซื้อของคุณ</p>
                    
                </div>
            </div>
        </section>
       
        
    </main>


@endsection

@section('scripts')
@stop('scripts')