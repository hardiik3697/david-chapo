<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-wide " dir="ltr" data-theme="theme-default" data-assets-path="{{ url('assets') }}/" data-template="front-pages" data-style="light">
    <head>
        @include('layout.meta')

        <title>@yield('title') - {{ __settings('SITE_TITLE') }}</title>
        
        @include('layout.styles')

        @include('layout.helper-js')
    </head>

    <body>
        @include('layout.navbar')

        <div data-bs-spy="scroll" class="scrollspy-example">
            @yield('content')
        </div>

        @include('layout.footer')
        
        @include('layout.scripts')

        @if(isset($pageJs) && is_array($pageJs))
            @foreach ($pageJs as $jsFile)
                @vite($jsFile)
            @endforeach
        @endif
    </body>
</html>