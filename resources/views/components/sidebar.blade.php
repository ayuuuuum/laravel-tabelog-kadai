<h2>カテゴリから探す</h2>

{{-- 写真付きカテゴリ：最初の5つ --}}
<div class="mb-4 d-flex flex-wrap justify-content-center">
    @foreach ($categories->take(5) as $category)
        <a href="{{ route('shops.index', ['category' => $category->id]) }}" class="category-img-wrapper">
            @if ($category->image !== "")
                <img src="{{ Storage::disk('s3')->url($category->image) }}" alt="{{ $category->name }}" class="category-img">
            @else
                <img src="{{ Storage::disk('s3')->url('dummy.png') }}" alt="{{ $category->name }}" class="category-img">
            @endif
        <div class="category-name-overlay">{{ $category->name }}</div>
        </a>
    @endforeach
</div>

{{-- 残りのカテゴリはボタンだけ --}}
<div class="mb-4 d-flex flex-wrap justify-content-center">
    @foreach ($categories->slice(5) as $category)
        <a href="{{ route('shops.index', ['category' => $category->id]) }}" class="category-button m-2 mb-4">
            {{ $category->name }}
        </a>
    @endforeach
</div>
