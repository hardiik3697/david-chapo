@extends('backend.auth.layout.app')

@section('meta')
@endsection

@section('title')
Login
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />
@endsection

@section('content')
<div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-12 px-12 py-6">
    <div class="w-px-400 mx-auto pt-5 pt-lg-0">
        <h4 class="mb-3">Welcome to {{ env('APP_NAME') }}</h4>

        <form action="{{ route('singin') }}" method="post" name="form" id="form" class="needs-validation form" novalidate enctype="multipart/form-data">
            @csrf
            @method('post')

            <div class="form-floating form-floating-outline mb-5">
                <input type="text" id="email" name="email" class="form-control email" />
                <label for="email">Email</label>
                <div class="invalid-feedback invalid-feedback-email"></div>
            </div>
            <div class="mb-5">
                <div class="form-password-toggle">
                    <div class="input-group input-group-merge">
                        <div class="form-floating form-floating-outline">
                            <input type="password" name="password" id="password" class="form-control password" />
                            <label for="password">Password</label>
                        </div>
                        <span class="input-group-text cursor-pointer">
                            <i class="ri-eye-off-line"></i>
                        </span>
                        <div class="invalid-feedback invalid-feedback-password"></div>
                    </div>
                </div>
            </div>
            <div class="mb-5 d-flex justify-content-between mt-5">
                <div class="form-check mt-2">
                    <input type="checkbox" name="remember" id="remember" class="form-check-input" />
                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary d-grid w-100">Sign in</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        var form = $('.form');
        form.submit(function(e) {
            $('.form').removeClass('was-validated');
            $('.invalid-feedback').css({"display": "none"});
            $('.invalid-feedback').html('');
            $.ajax({
                url : form.attr('action'),
                type : form.attr('method'),
                data: new FormData($(this)[0]),
                dataType: 'json',
                async: false,
                processData: false,
                contentType: false,
                success : function(response){
                    return true;
                },
                error: function(response){
                    e.preventDefault();
                    if(response.status === 422) {
                        var errors = response.responseJSON;
                        $.each(errors.errors, function (key, value) {
                            $('.form').addClass('was-validated');
                            $('.invalid-feedback-'+key).css({"display": "block"});
                            $('.invalid-feedback-'+key).html(value[0]);
                        });
                    }
                }
            });
        });
    });
</script>
@endsection
