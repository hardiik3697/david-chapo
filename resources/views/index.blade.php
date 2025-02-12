@extends('layout.app')

@section('meta')
@endsection

@section('title')
Home
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/front-page-landing.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/ui-carousel.css') }}" />
<style>
    .swiper {
        height: 500px;
    }
</style>
@endsection

@section('content')
<section id="landingFAQ" class="section-py bg-body landing-faq">
    <div class="container bg-icon-right">
        <div class="row gy-5">
            <div class="col-lg-4 d-flex align-items-center">
                <div class="card-body">
                    <h1 class="mb-1 mx-6">Online Grocery Product</h1>
                    <p class="mx-6 mb-6">
                        A small, locally-owned grocery store that operates primarily through an online platform
                    </p>
                    <div class="mb-6 g-4 d-flex">
                        <Button class="btn btn-lg btn-primary waves-effect waves-light mx-6">
                            Shop Now
                            <i class="ri-send-plane-2-fill ms-3"></i>
                        </Button>
                        <Button class="btn btn-lg btn-primary waves-effect waves-light mx-6">
                            About US
                            <i class="ri-send-plane-2-fill ms-3"></i>
                        </Button>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="text-center">
                    <div class="swiper text-white" id="swiper-vertical">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide" style="background-image: url(../../assets/img/elements/11.jpg)"></div>
                            <div class="swiper-slide" style="background-image: url(../../assets/img/elements/1.jpg)"></div>
                            <div class="swiper-slide" style="background-image: url(../../assets/img/elements/5.jpg)"></div>
                            <div class="swiper-slide" style="background-image: url(../../assets/img/elements/12.jpg)"></div>
                            <div class="swiper-slide" style="background-image: url(../../assets/img/elements/7.jpg)"></div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<section id="landingTeam" class="section-py landing-team">
    <div class="container bg-icon-right position-relative">
        <img
            src="../../assets/img/front-pages/icons/bg-right-icon-light.png"
            alt="section icon"
            class="position-absolute top-0 end-0"
            data-speed="1"
            data-app-light-img="front-pages/icons/bg-right-icon-light.png"
            data-app-dark-img="front-pages/icons/bg-right-icon-dark.png" />
        <h6 class="text-center d-flex justify-content-center align-items-center mb-6">
            <img
                src="../../assets/img/front-pages/icons/section-tilte-icon.png"
                alt="section title icon"
                class="me-3" />
            <span class="text-uppercase">Our Top Category</span>
            <img
                src="../../assets/img/front-pages/icons/section-tilte-icon.png"
                alt="section title icon"
                class="ms-3" />
        </h6>
        <div class="row gx-0 gy-6 mt-6">
            @for($i=0; $i<=5; $i++) 
                <div class="col-md-2 col-sm-2 text-center">
                    <span class="badge rounded-pill bg-label-hover-primary fun-facts-icon mb-2 p-6">
                        <i class="tf-icons ri-layout-line ri-42px"></i>
                    </span>
                    <h2 class="fw-bold mb-0 fun-facts-text">137+</h2>
                    <h6 class="mb-0 text-body">Completed Sites</h6>
                </div>
            @endfor
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/front-page-landing.js') }}"></script>
<script src="{{ asset('assets/js/ui-carousel.js') }}"></script>
<script>
    const verticalSwiper = document.querySelector('#swiper-vertical');
    if (verticalSwiper) {
        new Swiper(verticalSwiper, {
            direction: 'vertical',
            loop: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false
            },
            pagination: {
                clickable: true,
                el: '.swiper-pagination'
            }
        });
    }
</script>
@endsection