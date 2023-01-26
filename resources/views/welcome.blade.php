@extends('layouts.template')

@section('title')
เว็บแลกเปลี่ยนของรางวัล - Website
@stop

@section('stylesheet')

@stop('stylesheet')
@section('content')

    <div id="homepage-2">
        <div class="ps-home-banner">
            <div class="ps-carousel--nav-inside owl-slider" 
            data-owl-auto="true" 
            data-owl-loop="true" 
            data-owl-speed="5000" 
            data-owl-gap="0" 
            data-owl-nav="true" 
            data-owl-dots="true" 
            data-owl-item="1" 
            data-owl-item-xs="1" 
            data-owl-item-sm="1" 
            data-owl-item-md="1" 
            data-owl-item-lg="1"
             data-owl-duration="1000" 
             data-owl-mousedrag="on" 
             data-owl-animate-in="fadeIn" 
             data-owl-animate-out="fadeOut">

            @if(isset($slide))
            @foreach($slide as $u)
                <div class="ps-banner--autopart" ><img src="{{ url('/img/slide/'.$u->image) }}" alt="{{ $u->title }}" class="img-fluid"></div>
            @endforeach
            @endif
            </div>
        </div>
    </div>


    <div class="ps-product-list ps-recommend-for-you mt-30">
            <div class="container">
                <div class="ps-section__header" >
                    <h3>รางวัลยอดนิยม</h3>
                    
                </div>
                <div class="ps-section__content">
                    <div class="ps-carousel--nav owl-slider" 
                    data-owl-auto="true" 
                    data-owl-loop="true" 
                    data-owl-speed="10000" 
                    data-owl-gap="30" 
                    data-owl-nav="true" 
                    data-owl-dots="true" 
                    data-owl-item="5" 
                    data-owl-item-xs="4" 
                    data-owl-item-sm="4" 
                    data-owl-item-md="4"
                     data-owl-item-lg="4" 
                     data-owl-item-xl="5" 
                     data-owl-duration="1000" 
                     data-owl-mousedrag="on">

                    @if(isset($objs))
                        @foreach($objs as $u)
                        <div class="ps-product">
                            <div class="ps-product__thumbnail"><a 
                            onclick="setEventId({{ $u->id }})"
                            href="javascript:void(0)"
                            data-toggle="modal" 
                            data-target="#product-quickview" 
                            data-id="{{ $u->id }}"><img src="{{ url('assets/img/products/'.$u->image) }}" alt="" /></a>
                            </div>
                            <div class="ps-product__container">
                                <div class="ps-product__content">
                                    <a class="ps-product__title" href="javascript:void(0)" onclick="setEventId({{ $u->id }})" data-toggle="modal" 
                            data-target="#product-quickview" 
                            data-id="{{ $u->id }}">{{ $u->name }}</a>
                                    <a class="ps-btn" href="javascript:void(0)" onclick="setEventId({{ $u->id }})" data-toggle="modal" 
                            data-target="#product-quickview" 
                            data-id="{{ $u->id }}" style="padding: 3px 5px;font-size: 12px; margin-top:8px">{{number_format($u->point)}}</a>
                                </div>
                               
                            </div>
                        </div>
                        @endforeach
                    @endif
                    </div>
                </div>
            </div>
        </div>


        <div class="ps-product-list ps-recommend-for-you mt-40">
            <div class="container">
                <div class="ps-section__header" >
                    <h3>รางวัลสุดพรีเมี่ยม</h3>
                    
                </div>
                <br><br>
                <div class="ps-shopping-product">
                                        <div class="row">

                                        @if(isset($obj))
                                            @foreach($obj as $u)
                                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3 ">
                                            <div class="ps-product">
                                                <div class="ps-product__thumbnail"><a 
                                                onclick="setEventId({{ $u->id }})"
                                                href="javascript:void(0)"
                                                data-toggle="modal" 
                                                data-target="#product-quickview" 
                                                data-id="{{ $u->id }}"><img src="{{ url('assets/img/products/'.$u->image) }}" alt="" /></a>
                                                </div>
                                                <div class="ps-product__container">
                                                        <div class="ps-product__content">
                                                            <a class="ps-product__title" href="javascript:void(0)" onclick="setEventId({{ $u->id }})" data-toggle="modal" 
                                                    data-target="#product-quickview" 
                                                    data-id="{{ $u->id }}">{{ $u->name }}</a>
                                                            <a class="ps-btn" href="javascript:void(0)" onclick="setEventId({{ $u->id }})" data-toggle="modal" 
                                                    data-target="#product-quickview" 
                                                    data-id="{{ $u->id }}" style="padding: 3px 5px;font-size: 12px; margin-top:8px">{{number_format($u->point)}}</a>
                                                        </div>
                                                        
                                                    </div>
                                            </div>
                                            </div>
                                            @endforeach
                                         @endif
                                            
                                            


                                        </div>
                                    </div>

                                 
                                    @include('pagination.default', ['paginator' => $obj])
                                  
                                    
            </div>
        </div>



@endsection

@section('scripts')




@stop('scripts')