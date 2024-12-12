@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
Add User
@endsection

@section('styles')
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row sm-12">
        <div class="col-md">
            <div class="card">
                <h5 class="card-header">Add User</h5>
                <div class="card-body">
                    <form action="{{ route('user.insert') }}" method="post" name="form" id="form" class="needs-validation form" novalidate enctype="multipart/form-data">

                        @csrf
                        @method('post')

                        <div class="row g-6">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="firstname" id="firstname" class="form-control" value="{{ @old('firstname') }}" />
                                    <label for="bs-validation-firstname">FirstName</label>
                                    <div class="invalid-feedback invalid-feedback-firstname"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="lastname" id="lastname" class="form-control" value="{{ @old('lastname') }}" />
                                    <label for="bs-validation-lastname">Lastname</label>
                                    <div class="invalid-feedback invalid-feedback-lastname"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="username" id="username" class="form-control" value="{{ @old('username') }}" />
                                    <label for="bs-validation-username">Username</label>
                                    <div class="invalid-feedback invalid-feedback-username"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="email" name="email" id="email" class="form-control" value="{{ @old('email') }}" />
                                    <label for="bs-validation-email">Email</label>
                                    <div class="invalid-feedback invalid-feedback-email"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="phone" id="phone" class="form-control" value="{{ @old('phone') }}" />
                                    <label for="bs-validation-phone">Phone Number</label>
                                    <div class="invalid-feedback invalid-feedback-phone"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-password-toggle">
                                    <div class="input-group input-group-merge">
                                        <div class="form-floating form-floating-outline">
                                            <input name="password" type="password" id="password" class="form-control password" />
                                            <label for="password">Password</label>
                                        </div>
                                        <span class="input-group-text cursor-pointer">
                                            <i class="ri-eye-off-line"></i>
                                        </span>
                                        <div class="invalid-feedback invalid-feedback-password"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <select name="role" id="role" class="form-select role" >
                                        <option value="">Select role</option>
                                        <option value="admin">Admin</option>
                                        <option value="user">User</option>
                                    </select>
                                    <label for="role">Role</label>
                                    <div class="invalid-feedback invalid-feedback-role"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <input type="file" name="photo" id="photo" class="form-control photo" />
                                <div class="invalid-feedback invalid-feedback-photo"></div>
                            </div>
                        </div>

                        <div class="row pt-6">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                                <a href="{{ URL::previous() }}" class="btn btn-outline-secondary waves-effect">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        var form = $('.form');
        form.submit(function (e) {
            $('.ajax-form').removeClass('was-validated');
            $('.invalid-feedback').css({"display": "none"});
            $('.invalid-feedback').html('');
            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: new FormData($(this)[0]),
                dataType: 'json',
                async: false,
                processData: false,
                contentType: false,
                success: function (response) {
                    return true;
                },
                error: function (response) {
                    e.preventDefault();
                    if (response.status === 422) {
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
