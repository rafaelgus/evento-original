@extends('frontend.layouts.app')

@section('content')
    <section class="main-container col1-layout">
        <div class="main container">
            <div class="col-main">
                <form method="post" action="/payment" id="frmCheckout">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="cart-collaterals row">
                        <div class="col-sm-4">
                            <div class="customer-information">
                                <h3>{{ trans('frontend/checkout.customer-information') }}</h3>
                                <div class="form-customer">
                                    <ul class="form-list">
                                        <li>
                                            <label class="required" for="country"><em>*</em>{{  trans('frontend/checkout.address') }}</label>
                                            <div class="input-box">
                                                <input type="text" name="address" class="input-text fullwidth"/>
                                            </div>
                                        </li>
                                        <li>
                                            <label class="required" for="country"><em>*</em>{{  trans('frontend/checkout.address-number') }}</label>
                                            <div class="input-box">
                                                <input type="text" name="addressNumber" class="input-text fullwidth"/>
                                            </div>
                                        </li>

                                        <li>
                                            <label class="required" for="country"><em>*</em>{{  trans('frontend/checkout.billing-address') }}</label>
                                            <div class="input-box">
                                                <input type="text" name="billingAddress" class="input-text fullwidth"/>
                                            </div>
                                        </li>

                                        <li>
                                            <label class="required" for="country"><em>*</em>{{  trans('frontend/checkout.billing-address-number') }}</label>
                                            <div class="input-box">
                                                <input type="text" name="billingAddressNumber" class="input-text fullwidth"/>
                                            </div>
                                        </li>
                                        <li>
                                            <label class="required" for="country"><em>*</em>{{  trans('frontend/checkout.phone') }}</label>
                                            <div class="input-box">
                                                <input type="text" name="phone" class="input-text fullwidth"/>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="customer-information">
                                <h3>{{trans('frontend/checkout.shipping-options')}}</h3>
                                <div class="form-customer">
                                    <ul class="form-list">
                                        <li>
                                            <label class="required" for="country"><em>*</em>{{  trans('frontend/checkout.shipping') }}</label>
                                            <div class="input-box">
                                                <select class="validate-select" name="shippingType">
                                                    <option>Retiro en sucursal</option>
                                                    <option>Envío a domicilio</option>
                                                </select>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="customer-information">
                                <h3>{{trans('frontend/checkout.summary')}}</h3>
                                <div class="form-customer">
                                    <div class="resume-items">
                                        @foreach($cartItems as $item)
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <a class="product-image" title="ThinkPad X1 Ultrabook" href=""><img width="75" alt="ThinkPad Ultrabook" src="/articles/storage/{{$item['image']}}"></a>
                                                </div>
                                                <div class="col-sm-4">
                                                    <span>{{$item['name']}}</span>
                                                </div>
                                                <div class="col-sm-4">
                                                    <span>{{$item['price']}}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                        <h4>{{trans('frontend/checkout.voucher')}}</h4>
                                        <ul class="form-list">
                                            <li>
                                                <label class="required" for="country"><em>*</em>{{  trans('frontend/checkout.voucher') }}</label>
                                                <div class="input-box">
                                                    <input type="text" class="input-text fullwidth"/>
                                                </div>
                                                <div class="">
                                                    <br>
                                                </div>
                                                <div class="input-box">
                                                    <button value="Apply Coupon" class="button coupon " title="Apply Coupon" type="button"><span>{{trans('frontend/checkout.button-add-voucher')}}</span></button>
                                                </div>
                                            </li>
                                        </ul>
                                    <div style="height: 15px"></div>
                                    <div class="input-box">
                                        <button class="button btn-proceed-checkout" title="Pagar" onclick="document.getElementById('frmCheckout').submit()" type="button"><span>Pagar</span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection