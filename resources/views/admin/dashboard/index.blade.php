@extends('admin.layouts.template')

@section('ga')

@endsection

@section('stylesheet')

@stop('stylesheet')

@section('content')



<div class="row">
            <div class="col-12 grid-margin">
              <div class="card card-statistics">
                <div class="card-body p-0">
                  <div class="row">
                    <div class="col-md-6 col-lg-3">
                      <div class="d-flex justify-content-between border-right card-statistics-item">
                        <div>
                          <h1>{{ $order }}</h1>
                          <p class="text-muted mb-0">รายการแลก ทั้งหมด</p>
                        </div>
                        <i class="icon-wallet  text-primary icon-lg"></i>
                      </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                      <div class="d-flex justify-content-between border-right card-statistics-item">
                        <div>
                          <h1>{{ $slide }}</h1>
                          <p class="text-muted mb-0">รูปสไลด์</p>
                        </div>
                        <i class="icon-camera text-primary icon-lg"></i>
                      </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                      <div class="d-flex justify-content-between border-right card-statistics-item">
                        <div>
                          <h1>{{ $User }}</h1>
                          <p class="text-muted mb-0">ผู้ใช้งานทั้งหมด</p>
                        </div>
                        <i class="icon-people  text-primary icon-lg"></i>
                      </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                      <div class="d-flex justify-content-between card-statistics-item">
                        <div>
                          <h1>{{ $product }}</h1>
                          <p class="text-muted mb-0">สินค้าทั้งหมด</p>
                        </div>
                        <i class="icon-grid text-primary icon-lg"></i>
                      </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                      <div class="d-flex justify-content-between card-statistics-item">
                        <div>
                          <h1>{{ $count_wheel }}</h1>
                          <p class="text-muted mb-0">การหมุนกงล้อวันนี้</p>
                        </div>
                        <i class="icon-fire text-primary icon-lg"></i>
                      </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                      <div class="d-flex justify-content-between card-statistics-item">
                        <div>
                          <h1>{{ number_format($sum_wheel, 0) }}</h1>
                          <p class="text-muted mb-0">การเงินทั้งหมดกงล้อวันนี้</p>
                        </div>
                        <i class="icon-badge text-primary icon-lg"></i>
                      </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                      <div class="d-flex justify-content-between card-statistics-item">
                        <div>
                          <h1>{{ number_format($sum_wheel_all, 0) }}</h1>
                          <p class="text-muted mb-0">การเงินทั้งหมดกงล้อ</p>
                        </div>
                        <i class="icon-badge text-primary icon-lg"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <div class="col-6 grid-margin">

              <div class="card card-statistics">
                <div class="card-body">
                  <h4 class="card-title">การหมุนกงล้อทั้งหมด ( {{ count($objs) }} ครั้ง )</h4>

                  <div class="table-responsive">


                    <table class="table">
                      <thead>
                        <tr>
                            <th>#</th>
                            <th>วัน/เวลา</th>
                            <th>จำนวน</th>
                        </tr>
                    </thead>
                    <tbody>

                      @if(isset($objs))
                      @foreach($objs as $u)
                      <tr>
                        <td>{{ $u->phone }}</td>  
                        <td>{{ $u->date_time }}</td>  
                        <td><img style="height:24px; width:24px" src="{{ url('/img/coin.png') }}" class="chakra-coin2">  {{ number_format($u->coins, 0) }} </td>  
                      </tr>  
                      @endforeach                                                                                                                                    
                      @endif

                    </tbody>
                </table>
                </div>
                @include('admin.pagination.default', ['paginator' => $objs])

                </div>
              </div>

            </div>


          </div>


          
          



@endsection

@section('scripts')

@stop('scripts')