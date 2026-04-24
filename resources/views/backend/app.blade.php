<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Codescandy">

    <title>@yield('title')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- ===============================================-->
    <!--Favicons-->
    <!-- ===============================================-->
    @include('backend.partials.favicon')

    <!-- ===============================================-->
    <!--Stylesheets-->
    <!-- ===============================================-->
    @include('backend.partials.styles')
</head>

<body>

    <main id="main-wrapper" class="main-wrapper">
        @include('backend.partials.navbar')
        
        <div id="db-wrapper">
            @include('backend.partials.header')
            
            <div id="app-content">
                <div class="app-content-area">
                    @yield('content')
                </div>
            </div>
        </div>
    </main>

    <!-- ===============================================-->
    <!--JavaScripts-->
    <!-- ===============================================-->
    @include('backend.partials.scripts')
</body>

</html>
