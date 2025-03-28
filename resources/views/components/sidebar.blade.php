<div class="mb-4 d-flex flex-wrap justify-content-center">
    @foreach ($categories as $category)
        <a href="{{ route('shops.index', ['category' => $category->id]) }}"
           class="category-button">
            {{ $category->name }}
        </a>
    @endforeach
</div>