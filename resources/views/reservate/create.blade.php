@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $shop->name }} の予約</h1>

    {{-- エラーメッセージを上に表示 --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('reservate.store') }}" method="POST">
        @csrf
        <input type="hidden" name="shop_id" value="{{ $shop->id }}">

        <div class="mb-3">
            <label for="reservation_time" class="form-label">予約日時</label>
            <select id="reservation_time" name="reservation_time" class="form-control" required>
                @php
                use Carbon\Carbon;

                $startTime = Carbon::now()->addHours(2)->startOfHour();
                if ($startTime->minute >= 30) {
                    $startTime->addMinutes(30);
                }
                $endTime = Carbon::now()->addDays(30)->endOfDay();
                @endphp

                @while($startTime <= $endTime)
                    <option value="{{ $startTime->format('Y-m-d H:i') }}">
                        {{ $startTime->format('Y-m-d H:i') }}
                    </option>
                    @php $startTime->addMinutes(30); @endphp
                @endwhile
            </select>
        </div>

        <div class="mb-3">
            <label for="number_of_people" class="form-label">人数</label>
            <input type="number" id="number_of_people" name="number_of_people" class="form-control" min="1" required>
        </div>

        <button type="submit" class="btn btn-success">予約を確定</button>
    </form>
</div>
@endsection