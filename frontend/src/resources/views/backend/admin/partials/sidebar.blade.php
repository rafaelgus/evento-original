<!-- Sidebar Menu -->
<ul class="sidebar-menu">
    <!-- My account -->
    <!-- Users -->
    <li class="header">{{ trans('texts.sections.users.title') }}</li>
    <li class="treeview">
        <a href="#"><i class="fa fa-users"></i><span>{{ trans('texts.sections.users.title') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="/management/users">{{ trans('texts.sections.users.view') }}</a></li>
        </ul>
        <ul class="treeview-menu">
            <li><a href="/management/users/create">{{ trans('texts.sections.users.new') }}</a></li>
        </ul>
    </li>

    <li class="header">{{ trans('texts.sections.articles.title') }}</li>

    <li class="treeview">
        <a href="#"><i class="fa fa-users"></i><span>{{ trans('texts.sections.articles.title') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href='/management/articles/'>{{ trans('texts.sections.article.view') }}</a></li>
        </ul>
        <ul class="treeview-menu">
            <li><a href='/management/articles/create'>{{ trans('texts.sections.article.new') }}</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fa fa-users"></i><span>{{ trans('texts.sections.license.title') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href='/management/licenses/'>{{ trans('texts.sections.license.view') }}</a></li>
        </ul>
        <ul class="treeview-menu">
            <li><a href='/management/licenses/create'>{{ trans('texts.sections.license.new') }}</a></li>
        </ul>
    <li class="treeview">
        <a href="#"><i class="fa fa-users"></i><span>{{ trans('texts.sections.ingredients.title') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href='/management/ingredients/'>{{ trans('texts.sections.ingredients.view') }}</a></li>
        </ul>
        <ul class="treeview-menu">
            <li><a href='/management/ingredients/create'>{{ trans('texts.sections.ingredients.new') }}</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fa fa-gift"></i> <span>{{ trans('texts.sections.categories.title') }}</span><i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="/management/category">{{ trans('texts.sections.categories.view') }}</a></li>
        </ul>
        <ul class="treeview-menu">
            <li><a href="/management/category/create">{{ trans('texts.sections.categories.new') }}</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fa fa-tags"></i> <span>{{ trans('texts.sections.tags.title') }}</span><i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="/management/tags">{{ trans('texts.sections.tags.view') }}</a></li>
        </ul>
        <ul class="treeview-menu">
            <li><a href="/management/tags/create">{{ trans('texts.sections.tags.new') }}</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fa fa-tint"></i> <span>{{ trans('texts.sections.colors.title') }}</span><i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="/management/color">{{ trans('texts.sections.colors.view') }}</a></li>
        </ul>
        <ul class="treeview-menu">
            <li><a href="/management/color/create">{{ trans('texts.sections.colors.new') }}</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fa fa-apple"></i> <span>{{ trans('texts.sections.flavours.title') }}</span><i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="/management/flavour">{{ trans('texts.sections.flavours.view') }}</a></li>
        </ul>
        <ul class="treeview-menu">
            <li><a href="/management/flavour/create">{{ trans('texts.sections.flavours.new') }}</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fa fa-bug"></i> <span>{{ trans('texts.sections.allergens.title') }}</span><i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="/management/allergen">{{ trans('texts.sections.allergens.view') }}</a></li>
        </ul>
        <ul class="treeview-menu">
            <li><a href="/management/allergen/create">{{ trans('texts.sections.allergens.new') }}</a></li>
        </ul>

    </li>
    <li class="treeview">
        <a href="#"><i class="fa fa-apple"></i> <span>{{ trans('texts.sections.vouchers.title') }}</span><i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="/management/vouchers">{{ trans('texts.sections.vouchers.view') }}</a></li>
        </ul>
        <ul class="treeview-menu">
            <li><a href="/management/vouchers/create">{{ trans('texts.sections.vouchers.new') }}</a></li>
        </ul>
    <li>
        <a href="#"><i class="fa fa-heart"></i> <span>{{ trans('texts.sections.healthys.title') }}</span><i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="/management/healthy">{{ trans('texts.sections.healthys.view') }}</a></li>
        </ul>
        <ul class="treeview-menu">
            <li><a href="/management/healthy/create">{{ trans('texts.sections.healthys.new') }}</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fa fa-fire"></i> <span>{{ trans('texts.sections.brands.title') }}</span><i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="/management/brand">{{ trans('texts.sections.brands.view') }}</a></li>
        </ul>
        <ul class="treeview-menu">
            <li><a href="/management/brand/create">{{ trans('texts.sections.brands.new') }}</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fa fa-smile-o"></i> <span>Ocasiones</span><i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="/management/occasions">Ver</a></li>
        </ul>
        <ul class="treeview-menu">
            <li><a href="/management/occasions/create">Nuevo</a></li>
        </ul>
    </li>

    <li class="header">{{ trans('backend/menus.title') }}</li>
    <li class="treeview">
        <a href="#"><i class="fa fa-list"></i> <span>{{ trans('backend/menus.title') }}</span><i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="/management/menus">{{ trans('backend/menus.view') }}</a></li>
        </ul>
    </li>

    <li class="header">{{ trans('texts.sections.design.title') }}</li>
    <li class="treeview">
        <a href="/management/design-material-size"><i class="fa fa-crosshairs"></i> <span>{{ trans('texts.sections.design_material_sizes.title') }}</span></a>
        <a href="/management/circular-design-variant"><i class="fa fa-circle-o"></i> <span>{{ trans('texts.sections.circular_design_variants.title') }}</span></a>
        <a href="/management/design-material-type"><i class="fa fa-eraser"></i> <span>{{ trans('texts.sections.design_material_types.title') }}</span></a>
    </li>
    </li>
</ul>
