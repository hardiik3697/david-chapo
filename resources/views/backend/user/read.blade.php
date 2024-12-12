@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
View User
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-profile.css') }}" />
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card mb-6">
                <div class="user-profile-header-banner">
                    <img src="{{ asset('assets/img/pages/profile-banner.png') }}" alt="Banner image" class="rounded-top">
                </div>
                <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-5">
                    <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                        <img src="{{ $data->photo }}" alt="user image" class="d-block h-auto ms-0 ms-sm-5 rounded-4 user-profile-img">
                    </div>
                    <div class="flex-grow-1 mt-4 mt-sm-12">
                        <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-5 flex-md-row flex-column gap-6">
                            <div class="user-profile-info">
                                <h4 class="mb-2">{{ ucfirst($data->firstname ?? 'John' ) }} {{ ucfirst($data->lastname ?? 'Doe' ) }}</h4>
                            </div>
                            <a href="{{ route('user.update') }}/{{ base64_encode($data->id) }}" class="btn btn-primary waves-effect waves-light">
                                <i class="ri-user-follow-line ri-16px me-2"></i>Edit Profile
                            </a>
                        </div>
                        <div class="mt-2 d-flex align-items-md-end align-items-sm-end align-items-end justify-content-md-end justify-content-end mx-5 flex-md-row flex-column gap-6">
                            <a href="{{ URL::previous() }}" class="btn btn-primary waves-effect waves-light">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="card mb-6">
                <div class="card-body">
                    <small class="card-text text-uppercase text-muted small">About</small>
                    <ul class="list-unstyled my-3 py-1">
                        <li class="d-flex align-items-center mb-4">
                            <i class="ri-user-3-line ri-24px"></i>
                            <span class="fw-medium mx-2">Full Name:</span>
                            <span>{{ ucfirst(string: $data->firstname ?? 'John' ) }} {{ ucfirst($data->lastname ?? 'Doe' ) }}</span>
                        </li>
                        <li class="d-flex align-items-center mb-4">
                            <i class="ri-check-line ri-24px"></i>
                            <span class="fw-medium mx-2">Status:</span> <span>{{ ucfirst($data->status ?? '' ) }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="card mb-6">
                <div class="card-body">
                    <small class="card-text text-uppercase text-muted small">Contacts</small>
                    <ul class="list-unstyled my-3 py-1">
                        <li class="d-flex align-items-center mb-4">
                            <i class="ri-phone-line ri-24px"></i>
                            <span class="fw-medium mx-2">Contact:</span>
                            <span>{{ ucfirst($data->phone ?? '(000) 111 2222' ) }}</span>
                        </li>
                        <li class="d-flex align-items-center mb-2">
                            <i class="ri-mail-open-line ri-24px"></i>
                            <span class="fw-medium mx-2">Username:</span>
                            <span>{{ ucfirst($data->username ?? 'john123' ) }}</span>
                        </li>
                        <li class="d-flex align-items-center mb-2">
                            <i class="ri-mail-open-line ri-24px"></i>
                            <span class="fw-medium mx-2">Email:</span>
                            <span>{{ ucfirst($data->email ?? 'john@example.com' ) }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/pages-profile-user.js') }}"></script>
@endsection
