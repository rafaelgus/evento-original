@extends('frontend.layouts.app')

@section('content')
    <section class="main-container col1-layout">
        <div class="main container">
            <div class="col-main">
                <div class="page-title">
                    <h1>Checkout</h1>
                </div>
                <form method="post" action="/payment" id="frmCheckout">
                    <ol class="one-page-checkout" id="checkoutSteps">
                        <li id="opc-billing" class="section allow active">
                            <div class="step-title"> <span class="number">1</span>
                                <h3>{{ trans('frontend/checkout.billing-information') }}</h3>
                                <!--<a href="#">Edit</a> -->
                            </div>
                            <div id="checkout-step-billing" class="step a-item" style="">

                            </div>
                        </li>
                        <li id="opc-shipping" class="section allow active">
                            <div class="step-title"> <span class="number">2</span>
                                <h3 class="one_page_heading">Envio</h3>
                                <!--<a href="#">Edit</a>-->
                            </div>
                            <div id="checkout-step-shipping" class="step a-item">
                                <fieldset class="group-select">
                                    <ul>
                                        <li>
                                            <label for="shipping-address-select">Seleccione envio, o retiro en la sucursal</label>
                                            <br>
                                            <select name="shipping_address_id" id="shipping-address-select" class="address-select" title="" onchange="shipping.newAddress(!this.value)">
                                                <option>Retiro sucursal</option>
                                                <option>Envio a domicilio</option>
                                            </select>
                                        </li>

                                        <div class="new-directio" style="display: none;">
                                            <li>
                                                <label for="billing-address-select">Seleccione una direccion</label>
                                                <br>
                                                <select name="billingAddress" id="billing-address-select" class="address-select" title="" onchange="billing.newAddress(!this.value)">
                                                    @foreach($addresses as $address)
                                                        <option value="{{$address->getId()}}">{{$address->getAddress() . ', ' . $address->getCountry()->getName() . ', ' .  $address->getProvince(). ', ' .$address->getPostalCode()}}</option>
                                                    @endforeach
                                                </select>
                                                <button type="button" class="button continue"><span>Nueva</span></button>
                                            </li>
                                            <li>
                                                <div class="input-box">
                                                    <label for="billing:city">{{trans('frontend/checkout.address')}} <span class="required">*</span></label>
                                                    <br>
                                                    <input type="text" title="Address" name="address" value="" class="input-text required-entry" id="billing:city">
                                                </div>
                                                <div class="input-box">
                                                    <label for="billing:city">{{trans('frontend/checkout.city')}} <span class="required">*</span></label>
                                                    <br>
                                                    <input type="text" title="City" name="city" value="" class="input-text required-entry" id="billing:city">
                                                </div>
                                                <div id="" class="input-box">
                                                    <label for="billing:region">{{trans('frontend/checkout.state')}}<span class="required">*</span></label>
                                                    <br>
                                                    <input type="text" name="state" class="input-text required-entry">
                                                    <input type="text" id="billing:region" name="billing[region]" value="Alabama" title="State/Province" class="input-text required-entry" style="display: none;">
                                                </div>
                                            </li>
                                            <li>
                                                <div class="input-box">
                                                    <label for="billing:postcode">{{ trans('frontend/checkout.postal-code')  }}<span class="required">*</span></label>
                                                    <br>
                                                    <input type="text" title="Zip/Postal Code" name="postalCode" id="billing:postcode" value="46532" class="input-text validate-zip-international required-entry">
                                                </div>
                                                <div class="input-box">
                                                    <label for="billing:country_id">{{trans('frontend/checkout.country')}}<span class="required">*</span></label>
                                                    <br>
                                                    <select name="country" id="billing:country_id" class="validate-select" title="Country">
                                                        <option>Seleccione un pais</option>
                                                        @foreach($countries as $country)
                                                            <option value="{{$country->getId()}}">{{$country->getName()}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </li>
                                        </div>
                                    </ul>
                                    <p class="require"><em class="required">* </em>Required Fields</p>
                                    <div class="buttons-set1" id="shipping-buttons-container">
                                        <button type="button" class="button continue"><span>Continue</span></button>
                                    </div>
                                </fieldset>
                            </div>
                        </li>
                        <li id="opc-review" class="section">
                            <div class="step-title"> <span class="number">3</span>
                                <h3 class="one_page_heading">Resumen</h3>
                                <!--<a href="#">Edit</a>-->
                            </div>
                            <div id="checkout-step-review" class="step a-item">

                            </div>
                        </li>
                    </ol>
                </form>
            </div>
        </div>
    </section>
@endsection