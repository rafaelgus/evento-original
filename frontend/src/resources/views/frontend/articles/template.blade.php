<!-- Declare a JsRender template, in a script block: -->
<script id="articleTemplate" type="text/x-jsrender">

    <li class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
        <div class="item-inner">
            <div class="item-img">
                <div class="item-img-info">
                <a href="#" title="<%:name%>" class="product-image">
                <img src="{{ Storage::disk('s3')->url('menu-images/')}}<%:image%>"
                                alt="<%:name%>">
</a>

                    <%if isNew%><div class="new-label new-top-left">{{ trans('frontend/articles.new') }}</div><%/if%>

                    <div class="box-hover">
                        <ul class="add-to-links">
                            <li><a class="link-quickview" href="#">{{ trans('frontend/articles.quick_view') }}</a></li>
                            <li><a class="link-wishlist"
                                   href="#">{{ trans('frontend/articles.wishlist') }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="item-info">
                <div class="info-inner">
                    <div class="item-title"><a title="<%:name%>" href="#"> <%:name%> </a></div>
                    <div class="item-content">
                        <div class="rating-item">
                            <div class="ratings">
                                <fieldset class="rating">
                                    <input type="radio" id="star5" name="rating-<%:slug%>" value="5" <%if rating == 5%>checked<%/if%>/><label class="full" for="star5"></label>
                                    <input type="radio" id="star4half" name="rating-<%:slug%>" value="4.5" <%if rating == 4.5%>checked<%/if%>/><label class="half" for="star4half"></label>
                                    <input type="radio" id="star4" name="rating-<%:slug%>" value="4" <%if rating == 4%>checked<%/if%>/><label class="full" for="star4"></label>
                                    <input type="radio" id="star3half" name="rating-<%:slug%>" value="3.5" <%if rating == 3.5%>checked<%/if%>/><label class="half" for="star3half"></label>
                                    <input type="radio" id="star3" name="rating-<%:slug%>" value="3" <%if rating == 3%>checked<%/if%>/><label class="full" for="star3"></label>
                                    <input type="radio" id="star2half" name="rating-<%:slug%>" value="2.5" <%if rating == 2.5%>checked<%/if%>/><label class="half" for="star2half"></label>
                                    <input type="radio" id="star2" name="rating-<%:slug%>" value="2" <%if rating == 2%>checked<%/if%>/><label class="full" for="star2"></label>
                                    <input type="radio" id="star1half" name="rating-<%:slug%>" value="1.5" <%if rating == 1.5%>checked<%/if%>/><label class="half" for="star1half"></label>
                                    <input type="radio" id="star1" name="rating-<%:slug%>" value="1" <%if rating == 1%>checked<%/if%>/><label class="full" for="star1"></label>
                                    <input type="radio" id="starhalf" name="rating-<%:slug%>" value="half" <%if rating == 0.5%>checked<%/if%>/><label class="half" for="starhalf"></label>
                                </fieldset>
                                <p class="rating-links"><a href="#">1 Review(s)</a>
                                    <span class="separator">|</span> <a href="#">{{ trans('frontend/articles.add_review') }}</a></p>
                            </div>
                        </div>

                        <div class="item-price">
                            <div class="price-box"><span class="regular-price"><span class="price"><%:price_currency%> <%:price%></span> </span> </div>
                          </div>
                        <div class="action">
                            <button class="button btn-cart" type="button" title=""
                                    data-original-title="{{ trans('frontend/articles.buy') }}">
                                <span>{{ trans('frontend/articles.buy') }}</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>
</script>