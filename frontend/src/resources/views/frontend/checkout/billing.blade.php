@extends('frontend.layouts.app')


@section('content')
    <section class="main-container col1-layout">
        <div class="main container">
            <div class="col-main">
                <div class="page-title">
                    <h1>Checkout</h1>
                </div>
                <form method="post" action="/checkout/shipping" id="frmBilling">

                    <input type="hidden" name="orderId" value="{{$orderId}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

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
                                                                <input type="text" id="name" name="name" value="{{ old('name', $customer->getFirstName()) }}" title="First Name" class="input-text required-entry" required>
                                                            </div>
                                                            <div class="input-box name-lastname">
                                                                <label for="billing:lastname"> {{ trans('frontend/checkout.lastName') }} <span class="required">*</span> </label>
                                                                <br>
                                                                <input type="text" id="lastName" name="lastName" value="{{old('lastName', $customer->getLastName())}}" title="Last Name" class="input-text required-entry" required>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="input-box">
                                                            <label for="billing:company">{{trans('frontend/checkout.company')}}</label>
                                                            <br>
                                                            <input type="text" id="company" name="company" value="" title="Company" class="input-text">
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="input-box">
                                                            <label for="billing:telephone">{{trans('frontend/checkout.phone')}}<span class="required">*</span></label>
                                                            <br>
                                                            <input type="text" id="telephone" name="telephone" value="{{ old('phoneNumber', $customer->getPhoneNumber()) }}" title="Telephone" class="input-text required-entry" id="billing:telephone" required>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <label for="billing-address-select">Seleccione una direccion</label>
                                                        <br>
                                                        <select name="addressId" id="billing-address-select" class="address-select" title="" onchange="billing.newAddress(!this.value)">
                                                            @foreach($addresses as $address)
                                                                <option value="{{$address->getId()}}">{{$address->getAddress() . ', ' . $address->getCountry()->getName() . ', ' .  $address->getProvince(). ', ' .$address->getPostalCode()}}</option>
                                                            @endforeach
                                                        </select>
                                                        <button type="button" class="button continue" onclick="showFormAddress();"><span>Nueva</span></button>
                                                        <input type="hidden" value="0" name="newAddress" id="newAddress">
                                                    </li>
                                                    <div id="newAddressForm" style="display: none;">
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
                                    <p class="require"><em class="required">* </em>Campos obligatorios</p>
                                    <button type="button" onclick="postForm()" class="button continue"><span>{{ trans('buttons.continue') }}</span></button>
                                </fieldset>
                            </div>
                        </li>
                        <li id="opc-shipping" class="section">
                            <div class="step-title"> <span class="number">2</span>
                                <h3 class="one_page_heading">Envio</h3>
                                <!--<a href="#">Edit</a>-->
                            </div>
                            <div id="checkout-step-shipping" class="step a-item">

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

@section('scripts_body')
    <script>

        function showFormAddress() {
            var div = document.getElementById('newAddressForm');

            if (div.style.display === "block") {
                document.getElementById('newAddress').value = 0;
                div.style.display = 'none';
            } else {
                div.style.display = 'block';
                document.getElementById('newAddress').value = 1;
            }
        }
        
        function postForm() {
            var name = document.getElementById('name').value;
            var lastName = document.getElementById('lastName').value;
            var company = document.getElementById('company').value;
            var telephone = document.getElementById('telephone').value;

            if (name === '' || lastName === '' || telephone === '') {
                alert('Complete todos los campos requeridos (*)');
            } else {
                document.getElementById('frmBilling').submit();
            }
        }
    </script>
@endsection