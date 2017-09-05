<li><a  href="/{{ $category->getName() }}">{{ $category->getName() }}</a> <span
            class="subDropdown plusv"></span>

@if (count($category->getChildren()) > 0)
    <ul>
        @foreach($category->getChildren() as $category)
            @include('frontend.partials.categories_tree', compact($category))
        @endforeach
    </ul>
@endif

</li>