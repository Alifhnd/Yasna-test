@extends('manage::layouts.plane')

@section('body')
	{{ Yasna::initIfNecessary() }}
	<div  class="wrapper">

		@php
			if( function_exists('doc')){
				$logo = getSetting('manage-large-logo');
				$logoUrl = doc($logo)->getUrl();

				$logoTiny = getSetting('manage-small-logo');
				$logoUrlTiny = doc($logoTiny)->getUrl();
			}
		@endphp
		@include('manage::layouts.navbar.0navbar',[
			"logoImgSrc"=> (isset($logoUrl) and $logoUrl) ? $logoUrl : '' , // "manage:images/logo.png", //logo image
			"logoImgAlt" => "App Logo",
			"collapsedLogoImgSrc" => ( isset($logoUrlTiny) and $logoUrlTiny ) ? $logoUrlTiny : '', //small logo image
			"collapsedLogoImgAlt" => "App Logo",
			"lockUrl" => "lock.html", //lock screen url
			"alertCount" => "12" //number of notifications

		])



		<!--Negar Added-->


		@include('manage::layouts.sidebar.0sidebar')
		<!--Negar Added-->
		@include('manage::layouts.off-sidebar.0offsidebar')


		<!-- Negar added -->
		<section>
			<div class="content-wrapper whirl whirl-body">
			<!-- Main Content -->

			<!-- Breadcrumb navigation -->
			@include('manage::layouts.breadcrumb',[
				"class"=> ""
			])

			<!-- Main Content -->
				@yield('content')
			</div>
		</section>
	</div>



	<!-- Modal -->
	@yield('modal')
@endsection