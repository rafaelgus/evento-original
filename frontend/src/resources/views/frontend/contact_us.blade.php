@extends('frontend.layouts.app')

@section('content')
    <!-- breadcrumbs -->

    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul>
                        <li class="home"><a title="Go to Home Page" href="index.html">Home</a> <span>/</span></li>
                        <li class="category1601"><strong>{{ trans('frontend/contact_us.title') }}</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <!-- main-container -->
    <div class="main-container col2-right-layout">
        <div class="main container">
            <div class="row">
                <section class="col-sm-9 wow bounceInUp animated">
                    <div class="col-main">
                        <div class="page-title">
                            <h2>{{ trans('frontend/contact_us.title') }}</h2>
                        </div>
                        <div class="static-contain">
                            <fieldset class="group-select">
                                <ul>
                                    <li>
                                        <div class="customer-name">
                                            <div class="input-box">
                                                <label for="name"> {{ trans('frontend/contact_us.name') }}<span
                                                            class="required">*</span></label>
                                                <br>
                                                <input type="text" id="billing:firstname" name="name" value=""
                                                       title="{{ trans('frontend/contact_us.name') }}"
                                                       class="input-text ">
                                            </div>
                                            <div class="input-box">
                                                <label for="email"> {{ trans('frontend/contact_us.email') }} <span
                                                            class="required">*</span> </label>
                                                <br>
                                                <input type="email" id="email" name="email" value="" title="Email"
                                                       class="input-text validate-email">
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="input-box">
                                            <label for="company">{{ trans('frontend/contact_us.company') }}</label>
                                            <br>
                                            <input type="text" id="company" name="company" value=""
                                                   title="{{ trans('frontend/contact_us.company') }}"
                                                   class="input-text">
                                        </div>
                                        <div class="input-box">
                                            <label for="telephone">{{ trans('frontend/contact_us.telephone') }} <span
                                                        class="required">*</span></label>
                                            <br>
                                            <input type="text" name="telephone" id="telephone" value=""
                                                   title="{{ trans('frontend/contact_us.telephone') }}"
                                                   class="input-text">
                                        </div>
                                    </li>
                                    <li>
                                        <label for="address">{{ trans('frontend/contact_us.address') }} <span
                                                    class="required">*</span></label>
                                        <br>
                                        <input type="text" title="{{ trans('frontend/contact_us.address') }}"
                                               name="address" id="address" value="" class="input-text required-entry">
                                    </li>
                                    <li class="">
                                        <label for="comment">{{ trans('frontend/contact_us.comment') }}<em
                                                    class="required">*</em></label>
                                        <br>
                                        <div style="float:none" class="">
                                            <textarea name="comment" id="comment"
                                                      title="{{ trans('frontend/contact_us.comment') }}"
                                                      class="required-entry input-text" cols="5" rows="3"></textarea>
                                        </div>
                                    </li>
                                </ul>

                                <input type="text" name="hideit" id="hideit" value="" style="display:none !important;">
                                <div class="buttons-set">
                                    <button type="submit" title="Submit" class="button submit">
                                        <span> {{ trans('buttons.submit') }} </span></button>
                                </div>
                            </fieldset>

                        </div>
                    </div>
                </section>

                @include('frontend.partials.company_sidebar')

            </div>
        </div>
    </div>
    <!--End main-container -->

@endsection

@section('scripts_body')
    <script>
        $(document).ready(function() {
            $('#contact_us').addClass("current");
        });
    </script>
@endsection
