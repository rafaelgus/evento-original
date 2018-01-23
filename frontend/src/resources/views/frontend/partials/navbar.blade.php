<!-- Navigation -->
@inject('menuService', 'EventoOriginal\Core\Services\MenuService')
@inject('menuItemService', 'EventoOriginal\Core\Services\MenuItemService')

<nav>
    <div class="container">
        <div class="mm-toggle-wrap">
            <div class="mm-toggle"><i class="fa fa-bars"></i><span class="mm-label">Menu</span></div>
        </div>
        <div class="nav-inner">
            <!-- BEGIN NAV -->
            <ul id="nav" class="hidden-xs">
                <li class="level0 parent drop-menu" id="nav-home"><a href="/"
                                                                     class="level-top"><span>{{ trans('sections.home') }}</span></a>
                </li>

                @foreach($navBarMenuItems as $menuItem)

                <li class="mega-menu"><a class="level-top" href="{{ menu_item_url($menuItem) }}">
                        <span>{{ $menuItem->getTitle() }}</span> </a>
                    <div class="level0-wrapper dropdown-6col" style="left: 0px; display: none;">
                        <div class="container">
                            <div class="level0-wrapper2">

                                <!-- top Menu images -->

                                <div class="nav-block nav-block-center itemgrid">

                                    <!-- left Menu images -->

                                    <div class="">
                                        <ul class="level0">
                                            @foreach($menuItem->getSubitems() as $subitem)
                                                <li class="level1 nav-6-1 parent item">
                                                    <a href="{{ menu_item_url($subitem) }}" class="nav-image"><img
                                                                src="{{ Storage::disk('s3')->url('menu-images/' . $subitem->getImage()) }}"></a>
                                                    <a href="{{ menu_item_url($subitem) }}"><span>{{ $subitem->getTitle() }}</span></a>

                                                        <ul class="level1">
                                                            @foreach($subitem->getSubitems() as $subsubitem)
                                                                <li class="level2 nav-6-1-1"><a href="{{ menu_item_url($subsubitem) }}"><span>{{ $subsubitem->getTitle() }}</span></a>
                                                            @endforeach
                                                        </ul>
                                                </li>

                                            @endforeach
                                        </ul>
                                    </div><!-- level -->

                                    <!-- bottom Menu images -->

                                <!-- Right Menu images -->

                            </div>  <!-- level0-wrapper2 -->
                        </div>
                    </div>
                    </div>
                </li>

                @endforeach
                <li class="mega-menu"><a href="/{{ trans('sections.contact') }}"
                                         class="level-top"><span>{{ trans('sections.contact') }}</span></a>
                </li>
            </ul>
            <!--nav-->
        </div>
    </div>
</nav>

<!-- end nav -->