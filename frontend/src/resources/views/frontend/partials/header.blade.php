<!-- Header -->
  <header>
    <div class="header-container">
      <div class="header-top">
        <div class="container">
          <div class="row"> 
            <!-- Header Language -->
            <div class="col-xs-12 col-sm-6">
              <!--div class="dropdown block-language-wrapper"> <a role="button" data-toggle="dropdown" data-target="#" class="block-language dropdown-toggle" href="#"> <img src="images/english.png" alt="language"> English <span class="caret"></span> </a>
                <ul class="dropdown-menu" role="menu">
                  <li role="presentation"> <a href="#"><img src="images/english.png" alt="language"> English </a> </li>
                  <li role="presentation"> <a href="#"><img src="images/francais.png" alt="language"> French </a> </li>
                  <li role="presentation"> <a href="#"><img src="images/german.png" alt="language"> German </a> </li>
                </ul>
              </div>-->
              <!-- End Header Language --> 
              
              <!-- Header Currency -->
              <!--
              <div class="dropdown block-currency-wrapper"> <a role="button" data-toggle="dropdown" data-target="#" class="block-currency dropdown-toggle" href="#"> USD <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li role="presentation"><a href="#"> $ - Dollar </a> </li>
                  <li role="presentation"><a href="#"> £ - Pound </a> </li>
                  <li role="presentation"><a href="#"> € - Euro </a> </li>
                </ul>
              </div>-->
              <!-- End Header Currency -->
              <!--<div class="welcome-msg"> Welcome Crocus! </div>-->
            </div>
            <div class="col-xs-6 hidden-xs"> 
              <!-- Header Top Links -->
              <div class="toplinks">
                <div class="links">
                  <a title="{{trans('frontend/header.my_cart')}}" href="login.html"><img src="/images/rombo.png" width="7px"></i> {{trans('frontend/header.my_cart')}}</a> |
                  <a title="{{trans('frontend/header.my_account')}}" href="login.html">{{ trans('frontend/header.my_account')}}</a>
                </div>
              </div>
              <!-- End Header Top Links --> 
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 logo-block"> 
            <!-- Header Logo -->
            <div class="logo"> <a title="Magento Commerce" href="index.html"><img alt="Magento Commerce" src="images/logo.png" width="83%"> </a> </div>
            <!-- End Header Logo --> 
          </div>
          <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 hidden-xs">
            <div class="search-box">
              <form action="cat" method="POST" id="search_mini_form" name="Categories">
                <input type="text" placeholder="{{ trans('frontend/header.search')}}..."  maxlength="70" name="search" id="search">
                <button type="button" class="search-btn-bg"><span class="glyphicon glyphicon-search"></span>&nbsp;</button>
              </form>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"> 
          <a href="#" title="My Wishlist" class="top-link-wishlist hidden-xs"><img src="/images/heart.png" width="26" height="26">
          <div class="wish">Lista de deseos</div>
          </a>
           <a href="#" title="Carrito" class="top-link-shopping-cart hidden-xs"><img src="/images/cart.png" width="26" height="26">
          <div class="shopping-cart">Carrito<br>(Vacío)</div>
          </a>
          </div>
        </div>
      </div>
    </div>
    
    <!-- end header --> 

@include('frontend.partials.navbar')

</header>