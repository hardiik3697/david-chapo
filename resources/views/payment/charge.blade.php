@extends('layout.app')

@section('meta')

@endsection

@section('title')
Charge
@endsection

@section('styles')
@endsection

@section('content')
<section class="section-py bg-body first-section-pt" style="padding: 6.25rem 0;">
    <div class="container">
        <div class="card px-3">
            <form id="checkoutForm" name="checkout" method="post" action="{{ route('payment.process') }}">
                @csrf

                <div class="row">
                    <div class="col-lg-7 card-body border-end p-8">
                        <h4 class="mb-2">Checkout</h4>
                        <div class="row g-5">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline ">
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                                    <label for="name">Name</label>
                                    <div class="error-name invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline ">
                                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
                                    <label for="phone">Phone</label>
                                    <div class="error-phone invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline ">
                                    <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}">
                                    <label for="username">Username</label>
                                    <div class="error-username invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline ">
                                    <input type="text" name="confirm_username" id="confirm_username" class="form-control" value="{{ old('confirm_username') }}">
                                    <label for="confirm_username">Confirm Username</label>
                                    <div class="error-confirm_username invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline ">
                                    <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}">
                                    <label for="email">Email</label>
                                    <div class="error-email invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <select name="platform_id" id="platform_id" class="form-select" data-allow-clear="true">
                                        <option value="">Plateform</option>
                                        @if(!empty($data) && $data->isNotEmpty())
                                            @foreach ($data as $row)
                                                <option value="{{ $row->id }}" {{ old('platform_id') == $row->id ? 'selected' : '' }}>{{ ucwords($row->name) }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="platform_id">Plateform</label>
                                    <div class="error-platform_id invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row mb-3">
                                    <div class="col-md-12 mb-3 mx-3">
                                        <label id="amount">Amount</label>
                                        <div class="error-amount invalid-feedback"></div>
                                    </div>
                                    <div class="col-md mb-md-0 mb-5">
                                        <div class="form-check custom-option custom-option-basic">
                                            <label class="form-check-label custom-option-content" for="amount_5">
                                                <input type="radio" name="amount" value="5" {{ old('amount') == '5' ? 'checked' : '' }} id="amount_5" class="form-check-input">
                                                <span class="custom-option-header">
                                                    <span class="h6 mb-0">05</span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md mb-md-0 mb-5">
                                        <div class="form-check custom-option custom-option-basic">
                                            <label class="form-check-label custom-option-content" for="amount_10">
                                                <input type="radio" name="amount" value="10" {{ old('amount') == '10' ? 'checked' : '' }} id="amount_10" class="form-check-input">
                                                <span class="custom-option-header">
                                                    <span class="h6 mb-0">10</span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md mb-md-0 mb-5">
                                        <div class="form-check custom-option custom-option-basic">
                                            <label class="form-check-label custom-option-content" for="amount_15">
                                                <input type="radio" name="amount" value="15" {{ old('amount') == '15' ? 'checked' : '' }} id="amount_15" class="form-check-input">
                                                <span class="custom-option-header">
                                                    <span class="h6 mb-0">15</span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md mb-md-0 mb-5">
                                        <div class="form-check custom-option custom-option-basic">
                                            <label class="form-check-label custom-option-content" for="amount_20">
                                                <input type="radio" name="amount" value="20" {{ old('amount') == '20' ? 'checked' : '' }} id="amount_20" class="form-check-input">
                                                <span class="custom-option-header">
                                                    <span class="h6 mb-0">20</span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md mb-md-0 mb-5">
                                        <div class="form-check custom-option custom-option-basic">
                                            <label class="form-check-label custom-option-content" for="amount_30">
                                                <input type="radio" name="amount" value="30" {{ old('amount') == '30' ? 'checked' : '' }} id="amount_30" class="form-check-input">
                                                <span class="custom-option-header">
                                                    <span class="h6 mb-0">30</span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md mb-md-0 mb-5">
                                        <div class="form-check custom-option custom-option-basic">
                                            <label class="form-check-label custom-option-content" for="amount_40">
                                                <input type="radio" name="amount" value="40" {{ old('amount') == '40' ? 'checked' : '' }} id="amount_40" class="form-check-input">
                                                <span class="custom-option-header">
                                                    <span class="h6 mb-0">40</span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md mb-md-0 mb-5">
                                        <div class="form-check custom-option custom-option-basic">
                                            <label class="form-check-label custom-option-content" for="amount_50">
                                                <input type="radio" name="amount" value="50" {{ old('amount') == '50' ? 'checked' : '' }} id="amount_50" class="form-check-input">
                                                <span class="custom-option-header">
                                                    <span class="h6 mb-0">50</span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md mb-md-0 mb-5">
                                        <div class="form-check custom-option custom-option-basic">
                                            <label class="form-check-label custom-option-content" for="amount_100">
                                                <input type="radio" name="amount" value="100" {{ old('amount') == '100' ? 'checked' : '' }} id="amount_100" class="form-check-input">
                                                <span class="custom-option-header">
                                                    <span class="h6 mb-0">100</span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 card-body p-8 pt-0 pt-lg-8">
                        <h4 class="mb-2">Order Summary</h4>
                        <div class="bg-lighter p-6 rounded-4">
                            <div class="d-flex align-items-center">
                                <h1 class="text-heading total_amount">$0.00</h1>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="mb-0">Subtotal</p>
                                <h6 class="mb-0" id="subtotal">$0.00</h6>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <p class="mb-0">Tax</p>
                                <h6 class="mb-0" id="tax_amount"><del>$0.00</del></h6>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center pb-1">
                                <p class="mb-0">Total</p>
                                <h6 class="mb-0 total_amount">$0.00</h6>
                            </div>
                            <div class="d-grid mt-5">
                                <button type="submit" id="submit" class="btn btn-success waves-effect waves-light">
                                    <span class="me-1_5">Proceed with Payment</span>
                                    <i class="ri-arrow-right-line ri-16px scaleX-n1-rtl"></i>
                                </button>
                            </div>
                            <p class="mt-8 mb-0">By continuing, you accept to our Terms of Services and Privacy Policy.
                                Please note that payments are non-refundable.</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    var checkout_url = "{{ route('payment.checkout') }}";
</script>
@php $pageJs = ['resources/js/project/charges.js']; @endphp
@endsection
