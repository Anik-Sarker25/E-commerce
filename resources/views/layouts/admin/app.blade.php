<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
	<meta charset="utf-8">
	<title>Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

    @include('layouts.admin.css')

    @stack('css')

</head>
<body>
	<!-- BEGIN #app -->
	<div id="app" class="app">

		@include('layouts.admin.header')

        @include('layouts.admin.sidebar')

		<!-- BEGIN mobile-sidebar-backdrop -->
		<button class="app-sidebar-mobile-backdrop" data-toggle-target=".app" data-toggle-class="app-sidebar-mobile-toggled"></button>
		<!-- END mobile-sidebar-backdrop -->

        @yield('content')

        @include('layouts.admin.theme_panel')

        @include('components.view_modal')



		<!-- BEGIN btn-scroll-top -->
		<a href="#" data-toggle="scroll-to-top" class="btn-scroll-top fade"><i class="fa fa-arrow-up"></i></a>
		<!-- END btn-scroll-top -->
	</div>
	<!-- END #app -->

    @include('layouts.admin.scripts')

    @stack('js')

</body>
</html>
