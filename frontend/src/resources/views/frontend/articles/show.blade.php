@extends('frontend.layouts.app')

@section('content')

    <!-- Breadcrumbs -->
  <div class="breadcrumbs">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <ul>
            <li class="home"> <a href="index.html" title="Go to Home Page">Tazas</a> <span>/</span> </li>
            <li class="category1601"> <strong>{{$article->getName()}}</strong> </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- Breadcrumbs End --> 
  
    <!-- Main Container -->
  <section class="main-container col1-layout">
    <div class="main">
      <div class="container">
        <div class="row">
          <div class="col-main">
            <div class="product-view">
              <div class="product-essential">
                <form action="#" method="post" id="product_addtocart_form">
                  <input name="form_key" value="6UbXroakyQlbfQzK" type="hidden">
                  <div class="product-img-box col-lg-4 col-sm-4 col-xs-12">
                    <div class="new-label new-top-left"> New </div>
                    <div class="product-image">
                      <div class="product-full"> <img id="product-zoom" src="{{(count($article->getImages()) > 0)? $article->getImages()->toArray()[0]->getPath(): 'hola' }}" data-zoom-image="{{(count($article->getImages()) > 0)? $article->getImages()->toArray()[0]->getPath(): 'hola' }}" alt="product-image"/> </div>
                      <div class="more-views">
                        <div class="slider-items-products">
                          <div id="gallery_01" class="product-flexslider hidden-buttons product-img-thumb">
                            <div class="slider-items slider-width-col4 block-content">
                              @foreach($article->getImages() as $image)
                                  <div class="more-views-items"> <a href="#" data-image="{{$image->getPath()}}" data-zoom-image="{{$image->getPath()}}"> <img id="product-zoom"  src="{{$image->getPath()}}" alt="product-image"/></a></div>
                              @endforeach
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- end: more-images --> 
                  </div>
                  <div class="product-shop col-lg-8 col-sm-8 col-xs-12">
                    <div class="product-name">
                      <h1>{{$article->getName()}}</h1>
                    </div>
                    <div class="ratings">
                      {{--<div class="rating-box">--}}
                        {{--<div style="width:60%" class="rating"></div>--}}
                      {{--</div>--}}
                      <fieldset class="rating">
                        <input type="radio" id="star5" name="rating" value="5" disabled /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                        <input type="radio" id="star4half" name="rating" value="4 and a half" disabled/><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                        <input type="radio" id="star4" name="rating" value="4" checked disabled/><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                        <input type="radio" id="star3half" name="rating" value="3 and a half" disabled/><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                        <input type="radio" id="star3" name="rating" value="3" disabled/><label class = "full" for="star3" title="Meh - 3 stars"></label>
                        <input type="radio" id="star2half" name="rating" value="2 and a half" disabled/><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                        <input type="radio" id="star2" name="rating" value="2" disabled/><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                        <input type="radio" id="star1half" name="rating" value="1 and a half" disabled/><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                        <input type="radio" id="star1" name="rating" value="1" disabled/><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                        <input type="radio" id="starhalf" name="rating" value="half" disabled/><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                      </fieldset>
                      <p class="rating-links"> <a href="#">1 Review(s)</a> <span class="separator">|</span> <a href="#">Add Your Review</a> </p>
                    </div>
                    <div class="price-block">
                      <div class="price-box">
                        <p class="special-price"> <span class="price-label">Precio:</span> <span id="product-price-48" class="price">{{ formatted_money($article->getMoneyPrice()) }}</span> </p>
                        {{--<p class="old-price"> <span class="price-label">Precio Regular:</span> <span class="price">€ {{$article->getPrice()}} </span> </p>--}}
                        <p class="availability in-stock pull-right"><span>En Stock</span></p>
                      </div>
                    </div>
                    <div class="short-description">
                      <p>{{$article->getShortDescription()}}</p>
                      <br>
                      <p>
                      <strong>Código: </strong> <label> {{$article->getBarCode()}}</label>
                      </p>

                      @if($article->getBrand())
                        <p>
                          <strong>Marca: </strong> <label> {{$article->getBrand()->getName()}}</label>
                        </p>
                      @endif

                      <p class="color-detail">
                      <strong>Color:</strong> <label><div class="circle red" title="Rojo"></div><div class="circle blue" title="Azul"></div></label>
                      </p>
                      <p>
                        @if(count($article->getFlavours()) > 0)
                            <strong>Sabor: </strong><label> @foreach($article->getFlavours() as $flavour) {{$flavour->getName()}}, @endforeach</label>
                        @endif
                      </p>
                      <p>
                      <strong>Alérgenos: </strong> <label>@foreach($article->getAllergens() as $allergen) {{$allergen->getName()}}, @endforeach</label>
                      </p>
                      <p>
                      <strong>IVA:</strong> <label>10%</label>
                      </p>
                    </div>
                    <div class="add-to-box">
                      <div class="add-to-cart">
                        @if($article->getDesign() && $article->getDesign()->getCircularDesignVariant())
                          <div >
                            <select id="detail" name="detail" class="detail-select">
                              @foreach($article->getDesign()->getCircularDesignVariant()->getDetails() as $detail)
                                <option value="{{ $detail->getId() }}">
                                  {{ $detail->getDesignMaterialType()->getName() . " (" .  formatted_money($detail->getPriceWithCommissionMoney($article->getDesign()->getCommission())). ")" }}
                                </option>
                              @endforeach
                            </select>
                          </div>
                        @endif
                        <div class="pull-left">
                          <div class="custom pull-left">
                            <button onClick="var result = document.getElementById('quantity'); var qty = result.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 0 ) result.value--;return false;" class="reduced items-count" type="button"><i class="fa fa-minus">&nbsp;</i></button>
                            <input type="text" id="quantity" class="input-text qty" title="Qty" value="1" maxlength="12" name="qty">
                            <button onClick="var result = document.getElementById('quantity'); var qty = result.value; if( !isNaN( qty )) result.value++;return false;" class="increase items-count" type="button"><i class="fa fa-plus">&nbsp;</i></button>
                          </div>
                        </div>
                        <button onClick="addToCart()" class="button btn-cart" title="Comprar" type="button">Comprar</button>
                      </div>

                    </div>
                    
                  </div>
                  
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="product-collateral col-lg-12 col-sm-12 col-xs-12">
            <div class="add_info">
              <ul id="product-detail-tab" class="nav nav-tabs product-tabs">
                <li class="active"> <a href="#product_tabs_description" data-toggle="tab"> Descripción </a> </li>
                <li> <a href="#reviews_tabs" data-toggle="tab">Reviews</a> </li>
              </ul>
              <div id="productTabContent" class="tab-content">
                <div class="tab-pane fade in active" id="product_tabs_description">
                  <div class="std">
                    {!! $article->getDescription() !!}
                  </div>
                </div>
                <div class="tab-pane fade" id="reviews_tabs">
                  <div class="box-collateral box-reviews" id="customer-reviews">
                    <div class="box-reviews1">
                      <div class="form-add">
                        <form id="review-form" method="post" action="#">
                          <h3>Escribí tu review del producto</h3>
                          <fieldset>
                            <h4>¿Que te pareció el producto? <em class="required">*</em></h4>
                            <span id="input-message-box"></span>
                            <table id="product-review-table" class="data-table">
                              <colgroup>
                              <col>
                              <col width="1">
                              <col width="1">
                              <col width="1">
                              <col width="1">
                              <col width="1">
                              </colgroup>
                              <thead>
                                <tr class="first last">
                                  <th>&nbsp;</th>
                                  <th><span class="nobr">1 *</span></th>
                                  <th><span class="nobr">2 *</span></th>
                                  <th><span class="nobr">3 *</span></th>
                                  <th><span class="nobr">4 *</span></th>
                                  <th><span class="nobr">5 *</span></th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr class="first odd">
                                  <th>Precio</th>
                                  <td class="value"><input type="radio" class="radio" value="11" id="Price_1" name="ratings[3]"></td>
                                  <td class="value"><input type="radio" class="radio" value="12" id="Price_2" name="ratings[3]"></td>
                                  <td class="value"><input type="radio" class="radio" value="13" id="Price_3" name="ratings[3]"></td>
                                  <td class="value"><input type="radio" class="radio" value="14" id="Price_4" name="ratings[3]"></td>
                                  <td class="value last"><input type="radio" class="radio" value="15" id="Price_5" name="ratings[3]"></td>
                                </tr>
                                <tr class="even">
                                  <th>Valor</th>
                                  <td class="value"><input type="radio" class="radio" value="6" id="Value_1" name="ratings[2]"></td>
                                  <td class="value"><input type="radio" class="radio" value="7" id="Value_2" name="ratings[2]"></td>
                                  <td class="value"><input type="radio" class="radio" value="8" id="Value_3" name="ratings[2]"></td>
                                  <td class="value"><input type="radio" class="radio" value="9" id="Value_4" name="ratings[2]"></td>
                                  <td class="value last"><input type="radio" class="radio" value="10" id="Value_5" name="ratings[2]"></td>
                                </tr>
                                <tr class="last odd">
                                  <th>Calidad</th>
                                  <td class="value"><input type="radio" class="radio" value="1" id="Quality_1" name="ratings[1]"></td>
                                  <td class="value"><input type="radio" class="radio" value="2" id="Quality_2" name="ratings[1]"></td>
                                  <td class="value"><input type="radio" class="radio" value="3" id="Quality_3" name="ratings[1]"></td>
                                  <td class="value"><input type="radio" class="radio" value="4" id="Quality_4" name="ratings[1]"></td>
                                  <td class="value last"><input type="radio" class="radio" value="5" id="Quality_5" name="ratings[1]"></td>
                                </tr>
                              </tbody>
                            </table>
                            <input type="hidden" value="" class="validate-rating" name="validate_rating">
                            <div class="review1">
                              <ul class="form-list">
                                <li>
                                  <label class="required" for="nickname_field">Nombre<em>*</em></label>
                                  <div class="input-box">
                                    <input type="text" class="input-text" id="nickname_field" name="nickname">
                                  </div>
                                </li>
                                <li>
                                  <label class="required" for="summary_field">Resumen<em>*</em></label>
                                  <div class="input-box">
                                    <input type="text" class="input-text" id="summary_field" name="title">
                                  </div>
                                </li>
                              </ul>
                            </div>
                            <div class="review2">
                              <ul>
                                <li>
                                  <label class="required " for="review_field">Review<em>*</em></label>
                                  <div class="input-box">
                                    <textarea rows="3" cols="5" id="review_field" name="detail"></textarea>
                                  </div>
                                </li>
                              </ul>
                              <div class="buttons-set">
                                <button class="button submit" title="Submit Review" type="submit"><span>Enviar</span></button>
                              </div>
                            </div>
                          </fieldset>
                        </form>
                      </div>
                    </div>
                    <div class="box-reviews2">
                      <h3>Reviews de clientes</h3>
                      <div class="box visible">
                        <ul>
                          <li>
                            
                            <div class="review">
                              <h6><a href="#">Good Product</a></h6>
                              <small>Review by <span>John Doe </span>on 25/8/2016 </small>
                              <div class="rating-box">
                                      <div class="rating" style="width:100%;"></div>
                                    </div>
                              <div class="review-txt"> Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book</div>
                            </div>
                          </li>
                          <li class="even">
                            
                            <div class="review">
                              <h6><a href="#/catalog/product/view/id/60/">Superb!</a></h6>
                              <small>Review by <span>John Doe</span>on 12/3/2015 </small>
                              <div class="rating-box">
                                      <div class="rating" style="width:100%;"></div>
                                    </div>
                              <div class="review-txt"> Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book </div>
                            </div>
                          </li>
                          <li>
                            
                            <div class="review">
                              <h6><a href="#/catalog/product/view/id/59/">Awesome Product</a></h6>
                              <small>Review by <span>John Doe</span>on 28/2/2015 </small>
                              <div class="rating-box">
                                      <div class="rating" style="width:100%;"></div>
                                    </div>
                              <div class="review-txt last"> Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book </div>
                            </div>
                          </li>
                        </ul>
                      </div>
                      
                    </div>
                    <div class="clear"></div>
                  </div>
                </div>
            
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Main Container End --> 

@endsection

@section('scripts_body')
  <script type="text/javascript" src="/js/jquery.flexslider.js"></script>
  <script type="text/javascript" src="/js/cloud-zoom.js"></script>
  <script type="text/javascript">
      function addToCart() {
          var quantity = document.getElementById('quantity').value;
          var detail = document.getElementById('detail').value;
          var params = encodeURI('articleId=' + '{{$article->getId()}}&quantity=' + quantity + '&variantDetail=' + detail);
          var xhr = new XMLHttpRequest();
          xhr.open('POST', '/addToCart', true);
          xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
          xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

          xhr.onreadystatechange = function () {
              if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                  cartItems();
              }
          };
          xhr.send(params);
          cartItems();
      }

  </script>


@endsection