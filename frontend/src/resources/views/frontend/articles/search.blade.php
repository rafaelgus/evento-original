@extends('frontend.layouts.app')

@section('scripts_header')
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.8.1/css/bootstrap-slider.min.css">
    <link rel="stylesheet" type="text/css" href="/css/loading.css"/>
    <link rel="stylesheet" type="text/css" href="/css/spinner.css"/>
@stop

@section('content')


    <!-- Main Container -->
    <section class="main-container col2-left-layout bounceInUp animated">
        <div class="container">
            <div class="row">
                <div class="col-sm-9 col-sm-push-3">
                    <div class="category-description std">
                        <div class="slider-items-products">
                            <h2 class="page-heading"><span class="page-heading-title"></span>
                            </h2>
                            <p class="category-description">

                            </p>
                        </div>

                    </div>
                    <article class="col-main">

                        <div class="category-products">
                            <ul class="products-grid">
                                @foreach($articles as $article)
                                    <li class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                        <div class="item-inner">
                                            <div class="item-img">
                                                <div class="item-img-info">
                                                    <a href="/articulo/detalle/{{$article->getSlug()}}" title="{{$article->getName()}}" class="product-image">
                                                        <img src="/images/article_no_image.png" alt="BUBBLE MONKEY">
                                                    </a>

                                                    <div class="new-label new-top-left">Nuevo</div>

                                                    <div class="box-hover">
                                                        <ul class="add-to-links">
                                                            <li><a class="link-quickview" href="#">Vista rápida</a></li>
                                                            <li><a class="link-wishlist" href="/articulo/detalle/{{$article->getSlug()}}" title="bubble-monkey">Agregar a lista de deseados</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item-info">
                                                <div class="info-inner">
                                                    <div class="item-title"><a title="BUBBLE MONKEY" href="/articulo/detalle/{{$article->getSlug()}}"> {{$article->getName()}} </a></div>
                                                    <div class="item-content">
                                                        <div class="rating-item">
                                                            <div class="ratings">
                                                                <fieldset class="rating">
                                                                    <input type="radio" id="star5" name="rating-bubble-monkey" value="5"><label class="full" for="star5"></label>
                                                                    <input type="radio" id="star4half" name="rating-bubble-monkey" value="4.5"><label class="half" for="star4half"></label>
                                                                    <input type="radio" id="star4" name="rating-bubble-monkey" value="4" checked=""><label class="full" for="star4"></label>
                                                                    <input type="radio" id="star3half" name="rating-bubble-monkey" value="3.5"><label class="half" for="star3half"></label>
                                                                    <input type="radio" id="star3" name="rating-bubble-monkey" value="3"><label class="full" for="star3"></label>
                                                                    <input type="radio" id="star2half" name="rating-bubble-monkey" value="2.5"><label class="half" for="star2half"></label>
                                                                    <input type="radio" id="star2" name="rating-bubble-monkey" value="2"><label class="full" for="star2"></label>
                                                                    <input type="radio" id="star1half" name="rating-bubble-monkey" value="1.5"><label class="half" for="star1half"></label>
                                                                    <input type="radio" id="star1" name="rating-bubble-monkey" value="1"><label class="full" for="star1"></label>
                                                                    <input type="radio" id="starhalf" name="rating-bubble-monkey" value="half"><label class="half" for="starhalf"></label>
                                                                </fieldset>
                                                                <p class="rating-links"><a href="#">1 Review(s)</a>
                                                                    <span class="separator">|</span> <a href="#">Agregar review</a></p>
                                                            </div>
                                                        </div>

                                                        <div class="item-price">
                                                            <div class="price-box"><span class="regular-price"><span class="price">{{formatted_money($article->getMoneyPrice())}}</span> </span> </div>
                                                        </div>
                                                        <div class="action">
                                                            <button class="button btn-cart" type="button" title="" data-original-title="Comprar">
                                                                <span>Comprar</span></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>
    <!-- Main Container End -->

    <div id="result"></div>

@endsection