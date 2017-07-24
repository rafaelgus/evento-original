@extends('frontend.layouts.app')

@section('content')
    <!-- main-container -->
    <section class="content-wrapper">
        <div class="container">
            <div class="std">
                <div class="page-not-found wow bounceInRight animated">
                    <h2>404</h2>
                    <h3>{{trans('texts.errors.404.message')}}</h3>
                    <div><a href="/" type="button" class="btn-home"><span>{{trans('texts.errors.404.back_message')}}</span></a></div>
                </div>
            </div>
        </div>
    </section>
    <!--End main-container -->
@endsection
