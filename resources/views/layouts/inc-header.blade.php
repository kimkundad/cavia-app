<header class="header header--standard header--autopart" data-sticky="true">
        <div class="header__top">
            <div class="container">
                <div class="header__left">
                    <p> cavia168point รับพอยท์แลกของรางวัลมากมาย ส่งตรงถึงมือคุณ</p>
                </div>
                <div class="header__right">
                    <ul class="header__top-links">
                        <li><a href="{{ url('term') }}">เงื่อนไขการแลกสินค้า</a></li>
                        <li>
                            <div class="ps-block--user-header">
                                <div class="ps-block__left"><i class="icon-user"></i></div>
                                @if (Auth::guest())
                                <div class="ps-block__right"><a href="{{ url('login') }}">เข้าสู่ระบบ</a></div>
                                @else
                                <div class="ps-block__right"><a href="{{ url('account') }}">{{Auth::user()->name}}</a></div>
                                @endif
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="header__content">
            <div class="container">
                <div class="header__content-left"><a class="ps-logo" href="{{  url('/') }}"><img src="{{ url('assets/img/LOGO CV-Full-Orange.gif') }}" alt=""></a>
                    
                </div>
                <div class="header__content-center">
                    
                </div>
                <div class="header__content-right">
                    <div class="header__actions">
                        <div class="ps-block--header-hotline">
                            <div class="ps-block__left"><a href="{{ setting()->line_oa_url }}" target="_blank"><img src="{{ url('assets/img/line.png') }}" height="44"></a></div>
                            <div class="ps-block__right">
                                <p><a href="{{ setting()->line_oa_url }}" target="_blank">Line ID<strong>{{ setting()->line_oa }}</strong></a></p>
                            </div>
                        </div>
                        <div class="ps-cart--mini">
                            <a class="header__extra" href="#">
                                <i class="icon-bag2"></i>
                                <?php
                                $cart = session()->get('cart');
                                $total = 0;
                                 ?>
                                    @if(Session::get('cart') != null)
                                        <span><i>{{count($cart)}}</i></span>
                                    @else
                                        <span><i>0</i></span>
                                    @endif
                            </a>
                            @if(Session::get('cart') != null)
                            <div class="ps-cart__content">
                                <div class="ps-cart__items">
                                
                                    @foreach ($cart as $product_item)
                                    <div class="ps-product--cart-mobile">
                                        <div class="ps-product__thumbnail"><a href="#"><img src="{{ url('assets/img/products/'.$product_item['image']) }}" alt=""></a></div>
                                        <div class="ps-product__content">
                                            <a class="ps-product__remove" href="{{url('/deleteCart/'.$product_item['id'])}}"><i class="icon-cross"></i></a>
                                            <a href="#">{{$product_item['name_product']}}</a><br>
                                            <small>point : {{$product_item['point']}}</small>
                                        </div>
                                    </div>
                                    <?php
                                          $total += ($product_item['point']);
                                         ?>
                                    @endforeach
                                    
                                </div>
                                <div class="ps-cart__footer">
                                    <h3>Point Total:<strong>{{ $total }}</strong></h3>
                                    <figure><a class="ps-btn" href="{{ url('cart') }}">View Cart</a><a class="ps-btn" href="{{ url('checkout') }}">Checkout</a></figure>
                                </div>
                            </div>
                            @endif
                        </div>
                        @if (Auth::guest())
                        @else
                        <div class="ps-block--header-hotline">
                            <div class="ps-block__left">
                                <a class="header__extra" href="#"><i class="icon-gift"></i></a>
                            </div>
                            <div class="ps-block__right" style="padding-left: 10px;">
                                <p><a href="https://line.me/R/ti/p/@859zubjc" target="_blank">Point<strong>{{number_format((float)Auth::user()->point, 0, '.', '')}}</strong></a></p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <nav class="navigation">
            <div class="container">
                <ul class="menu menu--technology text-center">
                    <li class="current-menu-item "><a href="{{ url('/') }}">หน้าหลัก</a>
                    </li>
                    <li class="current-menu-item "><a href="{{ url('/my_point') }}">สะสมแต้ม</a>
                    </li>
                    <li class="current-menu-item "><a href="{{ url('/history') }}">ประวัติแลกของรางวัล</a>
                    </li>
                    <li class="current-menu-item "><a href="{{ url('/contact') }}">ติดต่อเรา</a>
                    </li>
                    <li class="current-menu-item "><a href="https://www.cavia168.com/" target="_blank">เข้าสู่เว็บไซวต์ cavia168.com</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <header class="header header--mobile autopart" data-sticky="true">
        
        <div class="navigation--mobile">
            <div class="navigation__left"><a class="ps-logo" href="{{  url('/') }}"><img src="{{ url('assets/img/LOGO CV-Full-Orange.gif') }}" alt="" height="45" ></a></div>
            <div class="navigation__right">
                <div class="header__actions">
                    <!--
                    <div class="ps-cart--mini"><a class="header__extra" href="#"><i class="icon-bag2"></i><span><i>0</i></span></a>
                        <div class="ps-cart__content">
                            <div class="ps-cart__items">
                                <div class="ps-product--cart-mobile">
                                    <div class="ps-product__thumbnail"><a href="#"><img src="{{ url('assets/img/products/clothing/7.jpg') }}" alt=""></a></div>
                                    <div class="ps-product__content"><a class="ps-product__remove" href="#"><i class="icon-cross"></i></a><a href="product-default.html">MVMTH Classical Leather Watch In Black</a>
                                        <p><strong>Sold by:</strong> YOUNG SHOP</p><small>1 x $59.99</small>
                                    </div>
                                </div>
                                <div class="ps-product--cart-mobile">
                                    <div class="ps-product__thumbnail"><a href="#"><img src="{{ url('assets/img/products/clothing/5.jpg') }}" alt=""></a></div>
                                    <div class="ps-product__content"><a class="ps-product__remove" href="#"><i class="icon-cross"></i></a><a href="product-default.html">Sleeve Linen Blend Caro Pane Shirt</a>
                                        <p><strong>Sold by:</strong> YOUNG SHOP</p><small>1 x $59.99</small>
                                    </div>
                                </div>
                            </div>
                            <div class="ps-cart__footer">
                                <h3>Sub Total:<strong>$59.99</strong></h3>
                                <figure><a class="ps-btn" href="#">View Cart</a><a class="ps-btn" href="checkout.html">Checkout</a></figure>
                            </div>
                        </div>
                    </div> -->

                    @if (Auth::guest())
                    <div class="ps-block--user-header" style="padding-top: 10px;">
                        <div class="ps-block__left"><i class="icon-user"></i></div>
                        <div class="ps-block__right" style="display: block;"><a href="#">Login</a></div>
                    </div>
                        @else

                       <!-- <div class="ps-block--user-header">
                            <div class="ps-block__left"><i class="icon-gift" style="font-size: 28px;"></i></div>
                            <div class="ps-block__right"><a href="#">Point</a><a href="#">{{number_format((float)Auth::user()->point, 0, '.', '')}}</a></div>
                        </div> -->
                        <div class="dropdown show text-left" style=" margin-top: 8px;">
                        <a href="#" class="dropdown-toggle dropdown_style " role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                        <i class="icon-gift" style="font-size: 16px;"></i> {{number_format((float)Auth::user()->point, 0, '.', '')}} <br> <i class="icon-user" style="font-size: 16px;"></i> {{Auth::user()->name}} </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" >
                                <li style="padding: 7px 13px; font-size:14px"><a href="{{ url('account') }}" >ข้อมูลบัญชี</a></li>
                                <li style="padding: 7px 13px; font-size:14px"><a href="{{ url('history') }}" >ประวัติ</a></li>
                                <li style="padding: 7px 13px; font-size:14px"><a href="{{ url('my_point') }}" >สะสมแต้ม</a></li>
                                <li style="padding: 7px 13px; font-size:14px"><a href="{{ url('term') }}">เงื่อนไขการแลกสินค้า</a></li>
                                <li style="padding: 7px 13px; font-size:14px"><a href="{{ url('logout') }}" >ออกจากระบบ</a></li>
                            </ul>
                        </div>
                        </div>
                    
                        @endif
                    
                </div>
            </div>
        </div>
        
    </header>
    <div class="ps-panel--sidebar" id="cart-mobile">
        <div class="ps-panel__header">
            <h3>Shopping Cart</h3>
        </div>
        <div class="navigation__content">
            
        
        </div>
    </div>

    <div class="ps-panel--sidebar" id="navigation-mobile">
        <div class="ps-panel__header">
            <h3>Categories</h3>
        </div>
        <div class="ps-panel__content">
            <ul class="menu--mobile">
                <li class="current-menu-item "><a href="#">Hot Promotions</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="navigation--list" style="background-color: #000000;">
        <div class="navigation__content">
            <a class="navigation__item" href="{{ url('my_point') }}" >
            <img src="{{ url('/img/icon/point.png') }}" class="icon_foot">
                <span> สะสมแต้ม</span>
            </a>
            <a class="navigation__item" href="{{ url('/cart') }}">
            <img src="{{ url('/img/icon/cart.png') }}" class="icon_foot">
                <span> ตะกร้า</span>
            </a>
            
            <a class="navigation__item " href="https://www.cavia168.com/" target="_blank">
                <strong class="red_btn"><img src="{{ url('assets/img/LOGO-CV-Line-Orange-Black-01.png') }}"></strong>
                <span class="red_btn_text"> cavia168 </span>
            </a>
            <a class="navigation__item " href="{{ url('/history') }}">
            <img src="{{ url('/img/icon/his.png') }}" class="icon_foot">
                <span> ประวัติ</span>
            </a>
            <a class="navigation__item " href="{{ url('/contact') }}">
            <img src="{{ url('/img/icon/line.png') }}" class="icon_foot">
                <span> ติดต่อเรา</span>
            </a>
            
        </div>
    </div>
    <div class="ps-panel--sidebar" id="search-sidebar">
        <div class="ps-panel__header">
            <form class="ps-form--search-mobile" action="{{  url('/') }}" method="get">
                <div class="form-group--nest">
                    <input class="form-control" type="text" placeholder="Search something...">
                    <button><i class="icon-magnifier"></i></button>
                </div>
            </form>
        </div>
        <div class="navigation__content"></div>
    </div>
    <div class="ps-panel--sidebar" id="menu-mobile">
        <div class="ps-panel__header">
            <h3>Menu</h3>
        </div>
        <div class="ps-panel__content">
            <ul class="menu--mobile">
                <li class="menu-item-has-children">
                    <a href="{{  url('/') }}">Home</a>
                </li>
            </ul>
        </div>
    </div>