@extends('layouts.app')

@section('content')
<div class="container">
    <h2>有料会員登録</h2>

    <form id="subscription-form" action="{{ route('mypage.process_subscription') }}" method="POST">
        @csrf

        {{--Stripe.js を使ったクレジットカード入力--}}
        <label for="card-holder-name">カード名義</label>
        <input id="card-holder-name" type="text" class="form-control mb-4" placeholder="TARO YAMADA">

        <label>カード番号</label>
        <div id="card-number-element" class="form-control mb-4"></div>

        <label>有効期限</label>
        <div id="card-expiry-element" class="form-control mb-4"></div>

        <label>CVC</label>
        <div id="card-cvc-element" class="form-control mb-4"></div>

        <input type="hidden" id="payment-method" name="payment_method">

        <button id="card-button" class="card-btn btn-primary mt-3">登録する</button>
    </form>
</div>

{{-- Stripe.jsを読み込む --}}
<script src="https://js.stripe.com/v3/"></script>
<script>
    document.addEventListener("DOMContentLoaded", async function() {
        //環境変数から公開キーを取得
        const stripe = Stripe("{{ env('STRIPE_KEY') }}"); 
        const elements = stripe.elements();

        const cardNumber = elements.create('cardNumber');
        const cardExpiry = elements.create('cardExpiry');
        const cardCvc = elements.create('cardCvc');

        cardNumber.mount('#card-number-element');
        cardExpiry.mount('#card-expiry-element');
        cardCvc.mount('#card-cvc-element');
        
        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const form = document.getElementById('subscription-form');
        const paymentMethodInput = document.getElementById('payment-method');

        cardButton.addEventListener('click', async function(event) {
            event.preventDefault();

            // カード情報をStripeに送信してPaymentMethodを作成
            const { paymentMethod, error } = await stripe.createPaymentMethod({
                type: 'card',
                card: cardNumber, // 1個だけ渡せばOK！
                billing_details: { name: cardHolderName.value }
            });

            if (error) {
                alert(error.message);
            } else {
                paymentMethodInput.value = paymentMethod.id;
                form.submit();
            }
        });
    });
</script>
@endsection