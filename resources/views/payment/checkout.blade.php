@extends('layout.app')

@section('meta')

@endsection

@section('title')
Checkout
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('stripe/checkout.css') }}" />
<script src="https://js.stripe.com/v3/"></script>
@endsection

@section('content')
<section class="section-py bg-body first-section-pt" style="padding: 6.25rem 0;">
    <div class="container">
        <div class="card px-3">
            <form id="payment-form">
                <div id="payment-element">
                </div>
                <button id="submit">
                    <div class="spinner hidden" id="spinner"></div>
                    <span id="button-text">Pay now</span>
                </button>
                <div id="payment-message" class="hidden"></div>
            </form>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    const publishable_key = "{{ $stripeData['publishable_key'] }}";
    const element_initialize_url = "{{ route('payment.element') }}";
    const stripe_return_url = "{{ route('payment.success') }}";
    const site_charge_url = "{{ route('payment.charge') }}";
</script>
@php $pageJs = ['resources/js/project/checkout.js']; @endphp
@endsection