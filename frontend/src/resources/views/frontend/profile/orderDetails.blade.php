@extends('frontend.layouts.app')

@section('content')
    <div class="main-container col2-right-layout">
        <div class="main container">
            <div class="row">
                <section class="col-sm-9 wow bounceInUp animated">
                    <div class="col-main">
                        <div class="my-account">
                            <div class="page-title">
                                <h2>Detalles de la orden numero {{$orderNumber}}</h2>
                            </div>
                            <div class="dashboard">
                                <div class="welcome-msg"> <strong>Hola, {{ Auth::user()->getName() }}!</strong>
                                    {{--<p>Desde Mi Cuenta prodá ver toda tu actividad reciente y actualizar tus datos personales.</p>--}}
                                </div>
                                <div class="recent-orders">
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
                                                <th>Cantidad #</th>
                                                <th>Nombre</th>
                                                <th><span class="nobr">Codigo</span></th>
                                                <th>Precio</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($details as $detail)
                                                <tr class="first odd">
                                                    <td>{{$detail->getQuantity()}}</td>
                                                    <td>{{$detail->getArticle()->getName()}}</td>
                                                    <td>{{$detail->getArticle()->getBarCode()}}</td>
                                                    <td><span class="price">{{formatted_money($detail->getMoney())}}</span></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
@endsection