<!-- Newsletter and social widget -->
<div class="subscribe-area">

    <div class="container">
        <div class="col-lg-7 col-xs-12 col-sm-6 col-md-6">
            <div class="subscribe">
                <div class="subscribe-title">
                    <label>{{ trans('frontend/newsletter.subscribe_title') }}:</label>
                </div>
                <form id="subscribe-form" method="post" action="#">
                    <div class="subscribe-content">
                        <input type="text" name="subscribe-input" id="subscribe-input" value="" placeholder="{{ trans('frontend/newsletter.subscribe_input_placeholder') }}" class="form-control input-text required-entry validate-email">
                        <button class="button" type="submit"><span>{{ trans('frontend/newsletter.subscribe') }}</span></button>
                    </div>
                </form>
            </div>
        </div>



        <div class="col-lg-5 col-xs-12 col-sm-6 col-md-6 social">

            <div class="subscribe-text-link">
                <div class="subscribe-link">
                    <p class="discount-text"><strong style="text-transform: uppercase">{{ trans('frontend/newsletter.follow_us_on') }}</strong> </p>
                    <ul class="social-link">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Newsletter and social widget end-->