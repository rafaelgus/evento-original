@extends('frontend.layouts.app')

@section('content')
    <section class="main-container col1-layout">
        <div class="main container">
            <div class="col-main">
                <div class="page-title">
                    <h1>Checkout</h1>
                </div>
                <ol class="one-page-checkout" id="checkoutSteps">
                    <li id="opc-billing" class="section">
                        <div class="step-title"> <span class="number">1</span>
                            <h3>{{ trans('frontend/checkout.billing-information') }}</h3>
                            <!--<a href="#">Edit</a> -->
                        </div>
                        <div id="checkout-step-billing" class="step a-item" style="">
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
                    <li id="opc-review" class="section allow active">
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
                                        Total: {{$total}}
                                    </td>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($cartItems as $item)
                                    <tr class="first odd">
                                        <td>
                                            <a class="product-image" title="ThinkPad X1 Ultrabook" href=""><img width="75" alt="ThinkPad Ultrabook" src="{{$item['image'] ? '/articles/storage/'.$item['image'] : '/images/voucher.jpeg'}}"></a>
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
                                <form method="post" action="/checkout/addVoucher">
                                    <input type="hidden" name="orderId" value="{{$order->getId()}}">

                                    <li>
                                        <label for="shipping-address-select">vouchers de descuento</label>
                                        <br>
                                        <input type="text" name="voucher" class="input-text required-entry" placeholder="agregar voucher">
                                        <button type="submit" class="button continue" ><span>Agregar voucher</span></button>
                                    </li>
                                </form>
                            </ul>
                            <br>
                            <div class="buttons-set1" id="shipping-buttons-container">
                                <form method="post" action="/payment/{{$order->getId()}}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" id="btnPay" onclick="disabledButton()" class="button continue"><span>Pagar</span></button>
                                </form>
                            </div>
                        </div>
                    </li>
                </ol>
            </div>
        </div>
    </section>
@endsection

@section('scripts_body')
    <script>
        function disabledButton() {
            document.getElementById("btnPay").disabled = false;
        }
    </script>
@endsection
