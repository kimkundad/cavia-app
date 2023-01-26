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
</style>

@stop('stylesheet')
@section('content')


<div class="ps-page--simple">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{ url('/') }}">หน้าหลัก</a></li>
                    <li>ติดต่อเรา</li>
                </ul>
            </div>
        </div>

        <div class="ps-checkout ps-section--shopping" style="background-color: #fff; padding: 100px 0px 200px 0px">
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col-md-8">
                        <div class="ps-form__header text-center">
                            <h2> ติดต่อเรา</h2>
                        </div>
                        <div class="ps-section__content text-center">
                            <h4>เพิ่มเพื่อนใน LINE ด้วยคิวอาร์โค้ด</h4>
                            <a href="{{ setting()->line_oa_url }}" target="_blank">
                        <img src="{{ url('img/setting/'.setting()->line_img) }}" >
                        </a>
                        <br><br>
                        
                                    
                        
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>


@endsection

@section('scripts')
@stop('scripts')