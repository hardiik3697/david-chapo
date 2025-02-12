@extends('layout.app')

@section('meta')

@endsection

@section('title')
Success Payment
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/wizard-ex-checkout.css') }}" />
<script src="https://js.stripe.com/v3/"></script>
@endsection

@section('content')
<section class="section-py bg-body first-section-pt">
    <div class="container">
        <div class="card px-3">
            <div class="bs-stepper-content border-top rounded-0 py-6">
                <div id="checkout-confirmation" class="content fv-plugins-bootstrap5 fv-plugins-framework active dstepper-block">
                    <div class="row mb-6">
                        <div class="col-12 col-lg-8 mx-auto text-center mb-2">
                            <h4 id="greeting">Thank You! 😇</h4>
                            <p id="message">Your payment has beed placed! We will work on this shortly.</p>
                        </div>
                        <div id="mainDiv" class="d-flex justify-content-lg-around flex-wrap gap-6">
                            <div>
                                <h6>Your Details:</h6>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="pe-4">Name:</td>
                                            <td id="name">David Chapo</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-4">Phone No:</td>
                                            <td id="phone" style="word-break:break-all;">9879879879</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-4">Email ID:</td>
                                            <td id="email" style="word-break:break-all;">dummy@davidchapo.com</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-4">Platform:</td>
                                            <td id="platform">Golden Dragon</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-4">Username:</td>
                                            <td id="username">david-chapo</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <h6>Payment Details:</h6>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="pe-4">Payment Status:</td>
                                            <td id="payment_status">Success</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-4">Payment Amount:</td>
                                            <td id="amount">$0.00</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-4">Payment ID:</td>
                                            <td id="payment_id" style="word-break:break-all;">#154479113</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-4">Client ID:</td>
                                            <td id="client_secret" style="word-break:break-all;">qi123654987asd45rwre213s4as5d3a3s36d54a</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-4">Time Placed:</td>
                                            <td id="updated_at">25/05/2020 13:35pm</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-8 mx-auto text-center mb-2" style="margin-top: 5.00rem">
                        <p> Take screenshot and sent it to facebook messanger.
                            <a href="//{{ __settings('FACEBOOK') }}" target="_blank" class="h6 mb-0">{{ __settings('SITE_TITLE') }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    const csrf_token = "{{ csrf_token() }}";
    const publishable_key = "{{ $stripeData['publishable_key'] }}";
    const checkout_status_url = "{{ route('payment.status') }}";
</script>
@php $pageJs = ['resources/js/project/success.js']; @endphp
@endsection