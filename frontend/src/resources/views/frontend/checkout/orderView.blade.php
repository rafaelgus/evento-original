@extends('frontend.layouts.app')

@section('content')
    <section class="main-container col1-layout">
        <div class="main container">
            <div class="col-main">
                <div class="page-title">
                    <h1>Checkout</h1>
                </div>
                <form method="post" action="/payment/{{$order->getId()}}" id="frmCheckout">
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