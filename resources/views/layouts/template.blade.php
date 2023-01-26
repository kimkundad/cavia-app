<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="shortcut icon" href="{{ url('assets/img/LOGO-CV-Line-Orange-Black-01.png') }}" />

    <title> @yield('title')</title>
    @if(isset(setting()->facebook_image))
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="{{ setting()->facebook_title }} ">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ url('img/setting/'.setting()->facebook_image) }}">
    <meta property="og:description" content="{{ setting()->facebook_detail }}">
    @endif

    @include('layouts.inc-style')
    @yield('stylesheet')

    
</head>

<body>

    @include('layouts.inc-header')

    @yield('content')
    
    @include('layouts.inc-footer')


    <div id="back2top"><i class="pe-7s-angle-up"></i></div>
    <div class="ps-site-overlay"></div>
    <div id="loader-wrapper">
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>
    <div class="ps-search" id="site-search"><a class="ps-btn--close" href="#"></a>
        <div class="ps-search__content">
            <form class="ps-form--primary-search" action="do_action" method="post">
                <input class="form-control" type="text" placeholder="Search for...">
                <button><i class="aroma-magnifying-glass"></i></button>
            </form>
        </div>
    </div>

    <div class="modal fade" id="product-quickview" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="product-quickview" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content"><span class="modal-close" data-dismiss="modal"><i class="icon-cross2"></i></span>
    <div id="getCode"></div>
    </div>
    </div>
    </div>
  

    <!-- JavaScripts -->
    @include('layouts.inc-script')
    @yield('scripts')

    
</body>

</html>