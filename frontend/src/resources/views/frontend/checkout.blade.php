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

                                    <fieldset class="group-select">
                                        <ul>
                                            <li id="billing-new-address-form">
                                                <fieldset>
                                                    <legend>Datos</legend>
                                                    <input type="hidden" name="billing[address_id]" value="4269" id="billing:address_id">
                                                    <ul>
                                                        <li>
                                                            <div class="customer-name">
                                                                <div class="input-box name-firstname">
                                                                    <label for="billing:firstname">{{ trans('frontend/checkout.name')}} <span class="required">*</span> </label>
                                                                    <br>
                                                                    <input type="text" id="billing:firstname" name="name" value="{{ old('name', $customer->getFirstName()) }}" title="First Name" class="input-text required-entry">
                                                                </div>
                                                                <div class="input-box name-lastname">
                                                                    <label for="billing:lastname"> {{ trans('frontend/checkout.lastName') }} <span class="required">*</span> </label>
                                                                    <br>
                                                                    <input type="text" id="billing:lastname" name="lastName" value="{{old('lastName', $customer->getLastName())}}" title="Last Name" class="input-text required-entry">
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="input-box">
                                                                <label for="billing:company">{{trans('frontend/checkout.company')}}</label>
                                                                <br>
                                                                <input type="text" id="billing:company" name="company" value="" title="Company" class="input-text">
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="input-box">
                                                                <label for="billing:telephone">{{trans('frontend/checkout.phone')}}<span class="required">*</span></label>
                                                                <br>
                                                                <input type="text" name="phone" value="{{ old('phoneNumber', $customer->getPhoneNumber()) }}" title="Telephone" class="input-text required-entry" id="billing:telephone">
                                                            </div>
                                                        </li>
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
                                                        <div class="new-directio" style="display: none;">
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
                                                </fieldset>
                                            </li>
                                        </ul>
                                        <p class="require"><em class="required">* </em>Required Fields</p>
                                        <button type="button" class="button continue" onclick="billing.save()"><span>Continue</span></button>
                                    </fieldset>
                            </div>
                        </li>
                        <li id="opc-shipping" class="section">
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
                                            <button type="button" class="button continue"><span>Volver</span></button>
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
                                <table class="data-table cart-table table-responsive" id="shopping-cart-table">
                                    <colgroup>
                                        <col width="1">
                                        <col width="1">
                                        <col width="1">
                                        <col width="1">
                                    </colgroup>
                                    <thead>
                                    <tr class="first last">
                                        <th></th>
                                        <th>Articulo</th>
                                        <th>Cantidad</th>
                                        <th>Precio unitario</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr class="first last">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="a-right last" colspan="50">
                                            Total: {{array_sum(array_column($cartItems, 'price'))}}
                                        </td>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($cartItems as $item)
                                        <tr class="first odd">
                                            <td>
                                                <a class="product-image" title="ThinkPad X1 Ultrabook" href=""><img width="75" alt="ThinkPad Ultrabook" src="/articles/storage/{{$item['image']}}"></a>
                                            </td>
                                            <td>
                                                {{$item['name']}}
                                            </td>
                                            <td>
                                                {{$item['qty']}}
                                            </td>
                                            <td>
                                                {{$item['price']}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <ul>
                                    <li>
                                        <label for="shipping-address-select">vouchers de descuento</label>
                                        <br>
                                        <input type="text" name="voucher" class="input-text required-entry" placeholder="agregar voucher">
                                        <button type="button" class="button continue" ><span>Agregar voucher</span></button>
                                    </li>
                                </ul>
                                <br>
                                <div class="buttons-set1" id="shipping-buttons-container">
                                    <button type="button" class="button continue"><span>Volver</span></button>
                                    <button type="button" class="button continue"><span>Pagar</span></button>
                                </div>
                            </div>
                        </li>
                    </ol>
                </form>
            </div>
        </div>
    </section>
@endsection


@section('scripts_body')
    <script type="text/javascript">

    </script>
@endsection