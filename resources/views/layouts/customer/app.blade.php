<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ isset($pageTitle) ? ucwords($pageTitle) : ucwords(siteInfo()->company_name) }}</title>

    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ siteInfo()->meta_description }}" />
    <meta name="keywords" content="{{ siteInfo()->meta_keywords }}" />
    <meta name="author" content="{{ siteInfo()->system_name || siteInfo()->company_name }}" />

    <!-- Open Graph Meta Tags for Social Media Sharing -->
    <meta property="og:title" content="{{ ucwords(siteInfo()->company_name) }} | {{ isset($pageTitle) ? ucwords($pageTitle) : '' }}">
    <meta property="og:description" content="{{ siteInfo()->meta_description ?? 'Default page description' }}">
    <meta property="og:image" content="{{ siteInfo()->meta_image ? asset(siteInfo()->meta_image) : '' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ ucwords(siteInfo()->company_name) }} | {{ isset($pageTitle) ? ucwords($pageTitle) : '' }}">
    <meta name="twitter:description" content="{{ siteInfo()->meta_description ?? '' }}">
    <meta name="twitter:image" content="{{ siteInfo()->meta_image ? asset(siteInfo()->meta_image) : '' }}">

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" href="{{ asset(siteInfo()->favicon ?? '') }}">
    @include('layouts.customer.css')

    @stack('css')


</head>
<body class="index-opt-1 {{ getBodyClass() }}">

    <div class="wrapper">

        @include('layouts.customer.header')

        @yield('content')

        @include('layouts.customer.footer')

        <!--back-to-top  -->
        <a href="#" class="back-to-top">
            <i class="fa fa-angle-up"></i>
        </a>

        <!-- Error Message  -->
        <div class="error-message">
            <div class="times-icon"><span>&#10006;</span></div>
            <div class="message-text"></div>
        </div>

    </div>

    @include('components.login_modal')


    @include('layouts.customer.scripts')

    @stack('js')

</body>
</html>
