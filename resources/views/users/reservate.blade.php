@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>予約一覧</h1>

    {{-- 成功メッセージ --}}
    @if (session('success'))
        <div class="alert-message alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- エラーメッセージ --}}
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif


    <hr>

    @if ($reservations->isEmpty())
        <p class="text-center">現在、予約はありません。</p>
    @else
    {{--予約データがある場合は、予約リストをテーブルで表示--}}
        <table class="table">
            <thead>
                <tr>
                    <th>店舗名</th>
                    <th>予約日時</th>
                    <th>人数</th>
                    <th> </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->shop->name }}</td>
                    <td>{{ $reservation->reservation_time }}</td>
                    <td>{{ $reservation->number_of_people }}人</td>
                    {{--<td>
                        @if ($reservation->status === 'pending')
                            <span class="badge bg-warning">未確定</span>
                        @elseif ($reservation->status === 'confirmed')
                            <span class="badge bg-success">確定</span>
                        @else
                            <span class="badge bg-danger">キャンセル</span>
                        @endif
                    </td>--}}
                <td>
                    {{--@if ($reservation->status === 'confirmed')--}}
                        <form action="{{ route('reservate.destroy', $reservation->id) }}" method="POST" onsubmit="return confirm('本当にキャンセルしますか？');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">キャンセル</button>
                        </form>
                </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

