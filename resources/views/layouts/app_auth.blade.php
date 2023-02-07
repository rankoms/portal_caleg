<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default"
	data-template="vertical-menu-template">

<head>
	<meta charset="utf-8" />
	<meta name="viewport"
		content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

	<title>Basic Inputs - Forms | Frest - Bootstrap Admin Template</title>

	<meta name="description" content="" />

	<!-- Favicon -->
	<link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

	<!-- Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
	<link
		href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
		rel="stylesheet" />

	<!-- Icons -->
	<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />

	<!-- Core CSS -->
	<link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
	<link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}"
		class="template-customizer-theme-css" />
	<link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

	<!-- Vendors CSS -->
	<link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />

	<!-- Page CSS -->

	@yield('page-style')

	<!-- Helpers -->
	<script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

	<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
	<!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
	<script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
	<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
	<script src="{{ asset('assets/js/config.js') }}"></script>
</head>

<body>
	<!-- Layout wrapper -->
	<div class="layout-wrapper layout-content-navbar">
		<div class="layout-container">

			<!-- Content wrapper -->
			<div class="content-wrapper">
				<!-- Content -->
				@yield('content')
				<!-- / Content -->

			</div>
		</div>

		<!-- Overlay -->
		<div class="layout-overlay layout-menu-toggle"></div>

		<!-- Drag Target Area To SlideIn Menu On Small Screens -->
		<div class="drag-target"></div>
	</div>
	<!-- / Layout wrapper -->

	<!-- Core JS -->

	<!-- Vendors JS -->

	<!-- Main JS -->
	<script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>
