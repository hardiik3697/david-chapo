@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
Dashboard
@endsection

@section('styles')
<!-- Page CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-statistics.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-analytics.css') }}" />
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row g-6">
        <!-- Gamification Card -->
        <!-- <div class="col-md-12 col-xxl-8"> -->
        <div class="col-md-12 col-xxl-12">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-md-6 order-2 order-md-1">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Welcome
                                <span class="fw-bold">{{ auth()->user()->firstname ?? 'John' }} {{ auth()->user()->lastname ?? 'Doe' }}</span> 🎉
                            </h4>
                            <p>Check your profile.</p>
                            <a href="{{ route('profile') }}" class="btn btn-primary">View Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Gamification Card -->
    </div>
</div>
@endsection

@section('scripts')
<!-- Page JS -->
<script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
@endsection
