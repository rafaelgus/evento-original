<aside class="col-right sidebar col-sm-3 wow bounceInUp animated">
    <div class="block block-company">
        <div class="block-title">{{ trans('frontend/footer.help.company') }}</div>
        <div class="block-content">
            <ol id="recently-viewed-items">
                <li id="about_us" class="item odd"><a href="/{{ trans('frontend/about_us.slug') }}">{{ trans('frontend/footer.help.about_us') }}</a></li>
                <li id="terms_and_conditions" class="item odd"><a href="/{{trans('frontend/terms_and_conditions.slug')}}">{{ trans('frontend/footer.help.terms_and_conditions_of_purchase') }}</a></li>
                <li id="contact_us" class="item last"><a href="/{{ trans('sections.contact') }}">{{ trans('frontend/contact_us.title') }}</a></li>
            </ol>
        </div>
    </div>
</aside>