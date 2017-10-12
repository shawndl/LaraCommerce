<p class="lead">Lara-Commerce</p>
<div class="list-group" v-if="show.showSideBar">
    @foreach($categories as $category)
        <a class="list-group-item {{ (isset($search ) && $search === $category->name) ? 'active' : '' }}"
           href="{{ action('User\SearchController@category', ['category' => $category->name ]) }}">
            {{ $category->name }}
        </a>
    @endforeach
</div>