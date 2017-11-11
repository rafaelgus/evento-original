<aside class="col-right sidebar col-sm-3 wow bounceInUp animated">
    <div class="block block-account">
        <div>
            <h3 class="current-balance">Saldo: {{ current_user_balance() }} €</h3>
        </div>

        <div class="block-title">{{ trans('frontend/my_account.title')}}</div>
        <div class="block-content">
            <ul>
                <li><a href="#">{{ trans('frontend/my_account.summary')}}</a></li>
                <li><a href="#">{{ trans('frontend/my_account.account_information')}}</a></li>
                <li><a href="#">{{ trans('frontend/my_account.my_orders')}}</a></li>
                <li><a href="#">{{ trans('frontend/my_account.my_reviews')}}</a></li>
                <li id="my_wishlist"><a href="#">{{ trans('frontend/my_wishlist.title')}}</a></li>
            </ul>
        </div>
    </div>

    <div class="block block-account">
        <div class="block-title">{{ trans('frontend/affiliates.title')}}</div>
        <div class="block-content">
            <ul>
                <li><a href="{{ route('affiliates.summary') }}">{{ trans('frontend/affiliates.summary')}}</a></li>
                <li><a href="{{ route('profile.payouts') }}">{{ trans('frontend/payouts.title')}}</a></li>
            </ul>
        </div>
    </div>

</aside>