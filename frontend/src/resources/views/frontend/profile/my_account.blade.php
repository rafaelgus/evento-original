@extends('frontend.layouts.app')

@section('content')

    <!-- main-container -->
    <div class="main-container col2-right-layout">
        <div class="main container">
            <div class="row">
                <section class="col-sm-9 wow bounceInUp animated">
                    <div class="col-main">
                        <div class="my-account">
                            <div class="page-title">
                                <h2>Mi cuenta</h2>
                            </div>
                            <div class="dashboard">
                                <div class="welcome-msg"> <strong>Hola, {{ Auth::user()->getName() }}!</strong>
                                    {{--<p>Desde Mi Cuenta prodá ver toda tu actividad reciente y actualizar tus datos personales.</p>--}}
                                </div>
                                <div class="recent-orders">
                                    <div class="title-buttons"><strong>{{ trans('frontend/my_account.recent_orders') }}</strong> <a href="#">{{ trans('frontend/my_account.view_all_orders') }}</a> </div>
                                    <div class="table-responsive">
                                        <table class="data-table" id="my-orders-table">
                                            <col>
                                            <col>
                                            <col>
                                            <col width="1">
                                            <col width="1">
                                            <col width="1">
                                            <thead>
                                            <tr class="first last">
                                                <th>Órden #</th>
                                                <th>Fecha</th>
                                                <th><span class="nobr">Total</span></th>
                                                <th>Estado</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($orders as $order)
                                            <tr class="first odd">
                                                <td>{{$order->getId()}}</td>
                                                <td>{{$order->getCreateDate()->format('Y-m-d H:i:s')}}</td>
                                                <td><span class="price">$ {{ formatted_money($order->getTotal())}}</span></td>
                                                <td><em>{{$order->getStatus()}}</em></td>
                                                <td class="a-center last"><span class="nobr"> <a href="/{{$order->getId()}}/detalle">Ver Órden</a></span></td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="box-account">
                                    <div class="page-title">
                                        <h2>{{ trans('frontend/my_account.personal_data') }}</h2>
                                    </div>
                                    <div class="col2-set">
                                        <div class="col-1">
                                            <h4>Informacion de contacto</h4>
                                            <a href="#">Editar</a>
                                            <p> Jon Doe<br>
                                                jond@gmail.com<br>
                                                <a href="#">Cambiar contraseña</a> </p>
                                        </div>
                                        <div class="col-2">

                                        </div>
                                    </div>
                                    <div class="col2-set">
                                        <div class="col-1">
                                            <h4>Dirección de facturación</h4>
                                            <address>
                                                Jon D<br>
                                                Hunts Ville<br>
                                                MG,  Alabama, 46532<br>
                                                United States<br>
                                                T: 454541 <br>
                                                <a href="#">Editar</a>
                                            </address>
                                        </div>
                                        <div class="col-2">
                                            <h4>Dirección de envio</h4>
                                            <address>
                                                Jon D<br>
                                                Hunts Ville<br>
                                                MG,  Alabama, 46532<br>
                                                United States<br>
                                                T: 454541 <br>
                                                <a href="#">Editar</a>
                                            </address>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> </div>
                </section>

                @include('frontend.partials.my_account_sidebar')

            </div>
        </div>
    </div>
    <!--End main-container -->
@endsection