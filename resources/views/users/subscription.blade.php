@extends('layouts.app')

@section('content')
<div class="container">
    <h2>有料会員登録</h2>

    <form id="subscription-form" action="{{ route('mypage.process_subscription') }}" method="POST">
        @csrf

        {{--Stripe.js を使ったクレジットカード入力--}}
        <label for="card-holder-name">カード名義</label>
        <input id="card-holder-name" type="text" class="form-control">

        <div id="card-element"></div> {{-- Stripeがカード入力フィールドをレンダリング --}}

        <button id="card-button" class="btn btn-primary mt-3">登録する</button>

        <input type="hidden" id="payment-method" name="payment_method">
    </form>
</div>

{{-- Stripe.jsを読み込む --}}
<script src="https://js.stripe.com/v3/"></script>
<script>
    document.addEventListener("DOMContentLoaded", async function() {
        //環境変数から公開キーを取得
        const stripe = Stripe("{{ env('STRIPE_KEY') }}"); 
        const elements = stripe.elements();
        const cardElement = elements.create('card', {
            hidePostalCode: true
        });
        cardElement.mount('#card-element');

        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const form = document.getElementById('subscription-form');
        const paymentMethodInput = document.getElementById('payment-method');

        cardButton.addEventListener('click', async function(event) {
            event.preventDefault();

            // カード情報をStripeに送信してPaymentMethodを作成
            const { paymentMethod, error } = await stripe.createPaymentMethod('card', cardElement, {
                billing_details: { name: cardHolderName.value }
            });

            if (error) {
                alert(error.message);
            } else {
                paymentMethodInput.value = paymentMethod.id;
                form.submit();
            }

            {{--paymentMethodInput.value = paymentMethod.id;

        // フォームを送信
        const response = await fetch(form.action, {
            method: "POST",
            body: new FormData(form),
            headers: { "X-Requested-With": "XMLHttpRequest" }
        });

        const result = await response.json();

        if (result.requires_action) {
            // 3Dセキュア認証を開始
            const { paymentIntent, error: confirmError } = await stripe.confirmCardPayment(result.payment_intent_client_secret);

            if (confirmError) {
                alert(confirmError.message);
                return;
            }
        }

        // 認証完了後にページをリロード
        window.location.href = "{{ route('mypage') }}";--}}
        });
    });
</script>
@endsection