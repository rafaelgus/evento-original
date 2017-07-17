<!-- Navigation -->

<nav>
    <div class="container">
        <div class="mm-toggle-wrap">
            <div class="mm-toggle"><i class="fa fa-bars"></i><span class="mm-label">Menu</span> </div>
        </div>
        <div class="nav-inner">
            <!-- BEGIN NAV -->
            <ul id="nav" class="hidden-xs">
                <li class="level0 parent drop-menu" id="nav-home"><a href="/" class="level-top"><span>{{ trans('sections.home') }}</span></a> </li>
                <li class="level0 nav-6 level-top drop-menu"> <a class="level-top" href="/{{ str_slug(trans('sections.mugs')) }}" > <span>{{ trans('sections.mugs') }}</span> </a>
                </li>
                <li class="mega-menu"> <a class="level-top" href="/{{ str_slug(trans('sections.wedding')) }}"><span>{{ trans('sections.wedding') }}</span></a>
                </li>
                <li class="mega-menu"> <a class="level-top" href="/{{ str_slug(trans('sections.personalized_gifts')) }}"><span>{{ trans('sections.personalized_gifts') }}</span></a>
                </li>
                <li class="mega-menu"> <a href="/{{ str_slug(trans('sections.original_candy')) }}" class="level-top"> <span>{{ trans('sections.original_candy') }}</span> </a>
                </li>
                <li class="mega-menu"><a href="/{{ trans('sections.contact') }}" class="level-top"><span>{{ trans('sections.contact') }}</span></a>
                </li>
            </ul>
            <!--nav-->
        </div>
    </div>
</nav>

<!-- end nav -->