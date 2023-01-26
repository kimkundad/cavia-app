
                <article class="ps-product--detail ps-product--fullwidth ps-product--quickview" style="display: block;">
                    <div class="row">
                        <div class="col-md-5 col-sm-6 col-6" >
                            <div class="ps-product__images" >
                                <div class="item"><img src="{{ url('assets/img/products/'.$objs->image) }}" alt=""></div>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-6 col-6">
                            <form  method="POST"  action="{{url('add_session_value')}}">
                                {{ csrf_field() }}
                                <h1>{{ $objs->name }}</h1>
                                <input type="hidden" name="product_id"  value="{{$objs->id}}"/>
                                <h4 class="ps-product__price">Point {{number_format($objs->point)}}</h4>
                                
                                <div class="ps-product__shopping">
                                    <button type="submit" class="ps-btn ps-btn--black" href="#">หยิบใส่ตะกร้า</button>
                                    <a class="ps-btn" href="{{ url('add_to_checkout/'.$objs->id) }}">แลกของรางวัล</a>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-12">
                                <div class="ps-product__desc">
                                {!! $objs->detail !!}
                                </div>
                        </div>
                    </div>
                </article>
            
