<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
	<meta charset="utf-8">
    @php
        use Illuminate\Support\Str;

        $pageTitles = [
            'admin/login' => 'Admin | Login',
            'admin/register' => 'Admin | Register',
            'admin/password/reset' => 'Reset Password',
        ];

        $currentPath = Request::path();

        if (Str::is('admin/password/reset/*', $currentPath)) {
            $pageTitle = 'Reset Password';
        } else {
            $pageTitle = $pageTitles[$currentPath] ?? 'Admin | Login';
        }
    @endphp
	<title>{{ $pageTitle }}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

    <meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- ================== BEGIN core-css ================== -->
	<link href="{{ asset('backend/assets/css/vendor.min.css') }}" rel="stylesheet">
	<link href="{{ asset('backend/assets/css/app.min.css') }}" rel="stylesheet">
	<!-- ================== END core-css ================== -->

    @stack('css')
</head>
<body class='pace-top'>
	<!-- BEGIN #app -->
	<div id="app" class="app app-full-height app-without-header">

        @yield('content')

		<!-- BEGIN btn-scroll-top -->
		<a href="#" data-toggle="scroll-to-top" class="btn-scroll-top fade"><i class="fa fa-arrow-up"></i></a>
		<!-- END btn-scroll-top -->
	</div>
	<!-- END #app -->

	<!-- ================== BEGIN core-js ================== -->
	<script src="{{ asset('backend/assets/js/vendor.min.js') }}"></script>
	<script src="{{ asset('backend/assets/js/app.min.js') }}"></script>
	<!-- ================== END core-js ================== -->

    <script defer src="https://cdn.jsdelivr.net/npm/@flasher/flasher@1.2.4/dist/flasher.min.js"></script>


    <script>

        function show_error(msg) {
            flasher.error(msg);
        }
        function show_warning(msg) {
            flasher.warning(msg);
        }
        function show_success(msg) {
            flasher.success(msg);
        }
        function show_info(msg) {
            flasher.info(msg);
        }

    </script>

    @stack('js')
</body>
</html>
