@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
Profile update
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
                        <a class="nav-link active waves-effect waves-light" href="{{ route('profile.update') }}">
                            <i class="ri-group-line me-2"></i>Account
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link waves-effect waves-light" href="{{ route('change.password') }}">
                            <i class="ri-lock-line me-2"></i>Security
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card mb-6">
                <form action="{{ route('update.profile') }}" name="ajax-form" id="form" class="ajax-form" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <input type="hidden" name="id" value="{{ auth()->user()->id }}">

                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-6">
                            <img src="{{ _path('users').auth()->user()->photo }}" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded-4" id="uploadedAvatar">
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-3 mb-4 waves-effect waves-light" tabindex="0">
                                    <span class="d-none d-sm-block">Upload new photo</span>
                                    <i class="ri-upload-2-line d-block d-sm-none"></i>
                                    <input type="file" name="photo" id="upload" class="account-file-input" hidden="" accept="image/png, image/jpeg">
                                </label>
                                <div>Allowed JPG, GIF or PNG. Max size of 2MB</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row mt-1 g-5">
                            <div class="col-md-6 fv-plugins-icon-container">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="text" id="firstname" name="firstname" value="{{ auth()->user()->firstname ?? '' }}"
                                        autofocus="">
                                    <label for="firstname">First Name</label>
                                </div>
                                <div class="invalid-feedback invalid-feedback-firstname"></div>
                            </div>
                            <div class="col-md-6 fv-plugins-icon-container">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="text" name="lastname" id="lastname" value="{{ auth()->user()->lastname ?? '' }}">
                                    <label for="lastname">Last Name</label>
                                </div>
                                <div class="invalid-feedback invalid-feedback-lastname"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="text" id="email" name="email" value="{{ auth()->user()->email ?? '' }}" placeholder="john.doe@example.com">
                                    <label for="email">E-mail</label>
                                </div>
                                <div class="invalid-feedback invalid-feedback-email"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="username" name="username" value="{{ auth()->user()->username ?? '' }}">
                                    <label for="username">Username</label>
                                </div>
                                <div class="invalid-feedback invalid-feedback-username"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="phone" name="phone" class="form-control" value="{{ auth()->user()->phone ?? '' }}">
                                    <label for="phone">Phone Number</label>
                                </div>
                                <div class="invalid-feedback invalid-feedback-phone"></div>
                            </div>
                        </div>
                        <div class="mt-6">
                            <button type="submit" class="btn btn-primary me-3 waves-effect waves-light">Save changes</button>
                            <a href="{{ URL::previous() }}" class="btn btn-outline-secondary waves-effect">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/pages-profile-user.js') }}"></script>
@section('scripts')
<script>
    $(document).ready(function () {
        var form = $('.ajax-form');
        form.submit(function(e) {
            $('.ajax-form').removeClass('was-validated');
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
                            $('.ajax-form').addClass('was-validated');
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
