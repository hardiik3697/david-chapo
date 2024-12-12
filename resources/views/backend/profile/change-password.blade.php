@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
Change Password
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-profile.css') }}" />
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row fv-plugins-icon-container">
        <div class="col-md-12">
            <div class="nav-align-top">
                <ul class="nav nav-pills flex-column flex-md-row mb-6 gap-2 gap-lg-0">
                    <li class="nav-item">
                        <a class="nav-link waves-effect waves-light" href="{{ route('profile.update') }}">
                            <i class="ri-group-line me-2"></i>Account
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active waves-effect waves-light" href="{{ route('change.password') }}">
                            <i class="ri-lock-line me-2"></i>Security
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card mb-6">
                <h5 class="card-header">Change Password</h5>
                <div class="card-body pt-1">
                    <form action="{{ route('password.change') }}" method="post" name="form" id="form" class="needs-validation form" novalidate enctype="multipart/form-data">

                        @csrf
                        @method('POST')

                        <div class="row">
                            <div class="mb-5 col-md-6 form-password-toggle fv-plugins-icon-container">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="password" name="currentPassword" id="currentPassword" class="form-control" />
                                        <label for="currentPassword">Current Password</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                                </div>
                                <div class="invalid-feedback invalid-feedback-currentPassword"></div>
                            </div>
                        </div>
                        <div class="row g-5 mb-6">
                            <div class="col-md-6 form-password-toggle fv-plugins-icon-container">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="password" name="newPassword" id="newPassword" class="form-control" />
                                        <label for="newPassword">New Password</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                                </div>
                                <div class="invalid-feedback invalid-feedback-newPassword"></div>
                            </div>
                            <div class="col-md-6 form-password-toggle fv-plugins-icon-container">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" />
                                        <label for="confirmPassword">Confirm New Password</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                                </div>
                                <div class="invalid-feedback invalid-feedback-confirmPassword"></div>
                            </div>
                        </div>
                        <h6 class="text-body">Password Requirements:</h6>
                        <ul class="ps-4 mb-0">
                            <li class="mb-4">Minimum 6 characters long - the more, the better</li>
                            <li class="mb-4">At least one lowercase character</li>
                            <li class="mb-4">At least one uppercase character</li>
                            <li>At least one number</li>
                        </ul>
                        <div class="mt-6">
                            <button type="submit" class="btn btn-primary me-3 waves-effect waves-light">Save changes</button>
                            <a href="{{ URL::previous() }}" class="btn btn-outline-secondary waves-effect">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/pages-profile-user.js') }}"></script>
<script>
    $(document).ready(function () {
        var form = $('.form');
        form.submit(function(e) {
            document.getElementById("form").classList.remove("was-validated");
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
                            $('#form').addClass('was-validated');
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
