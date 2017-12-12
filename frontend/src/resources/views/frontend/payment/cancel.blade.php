@extends('frontend.layouts.app')

@section('content')
    <section class="main-container col1-layout">
        <div class="col-sm-4"></div>
        <div class="col-sm-4 discount">
            <div style="border-bottom: 5px solid; text-align: center"><h3>La compra se realizo con exito</h3></div>
            <div class="col-sm-4"></div>
            <div class="col-sm-4" style="height: 100%; text-align: center;">
                <img src="/images/cancel.png" style="margin-top: 80px">
            </div>
            <div class="col-sm-4"></div>
            <div class="row">
                <div class="col-sm-12" style="text-align: center; margin-top: 50px">
                    <button onclick="window.location.href='/';" class="button btn-continue" title="Continue Shopping" type="button"><span>Ir a home</span></button>
                </div>
            </div>

        </div>
        <div class="col-sm-4"></div>
    </section>
@endsection