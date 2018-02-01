@extends('frontend.layouts.app')

@section('content')
    <!-- main-container -->
    <section class="content-wrapper">
        <div class="container">
            <div class="std">
                <div class="page-not-found wow bounceInRight animated">
                    <h2>500</h2>
                    <h3>Ha ocurrido un error interno</h3>
                    <div><a href="/" type="button" class="btn-home"><span>{{trans('texts.errors.404.back_message')}}</span></a></div>
                </div>
            </div>
        </div>
    </section>
    <!--End main-container -->
@endsection
