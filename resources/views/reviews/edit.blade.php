@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <h1 class="mb-4">レビューを編集</h1>

    @if (session('flash_message'))
        <div class="alert alert-success">
            {{ session('flash_message') }}
        </div>
    @endif

    <form method="POST" action="{{ route('reviews.update', $review->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">評価</label>
            <select name="score" class="form-select samuraimart-form-parts">
                @for ($i = 5; $i >= 1; $i--)
                    <option value="{{ $i }}" {{ $review->score == $i ? 'selected' : '' }}>
                        {{ str_repeat('★', $i) }}
                    </option>
                @endfor
            </select>
            @error('score')
                <p class="text-danger"><strong>{{ $message }}</strong></p>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">タイトル</label>
            <input type="text" name="title" class="form-control samuraimart-form-parts" value="{{ old('title', $review->title) }}">
            @error('title')
                <p class="text-danger"><strong>{{ $message }}</strong></p>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">レビュー内容</label>
            <textarea name="content" rows="4" class="form-control samuraimart-form-parts">{{ old('content', $review->content) }}</textarea>
            @error('content')
                <p class="text-danger"><strong>{{ $message }}</strong></p>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">更新する</button>
        <a href="{{ route('shops.show', $review->shop_id) }}" class="btn btn-secondary ms-2">キャンセル</a>
    </form>
</div>
@endsection