<!DOCTYPE html>
<html lang="en-us" {{$html_attr}}>	
	
<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE-edge,chrome=1">
		<title> {{ ucwords($title) }} </title>
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		{{Larasset::start('header')->show('styles')}}
		{{Larasset::start('header')->show('scripts')}}

		<!-- #FAVICONS -->
		<link rel="shortcut icon" href="asset_vendors/bucketcodes/img/favicon.ico" type="image/x-icon">
		<link rel="icon" href="asset_vendors/bucketcodes/img/favicon.ico" type="image/x-icon">

				<!-- #APP SCREEN / ICONS -->
		<!-- Specifying a Webpage Icon for Web Clip 
			 Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
		<!--<link rel="apple-touch-icon" href="asset_vendors/smart/img/splash/sptouch-icon-iphone.png">
		<link rel="apple-touch-icon" sizes="76x76" href="asset_vendors/smart/img/splash/touch-icon-ipad.png">
		<link rel="apple-touch-icon" sizes="120x120" href="asset_vendors/smart/img/splash/touch-icon-iphone-retina.png">
		<link rel="apple-touch-icon" sizes="152x152" href="asset_vendors/smart/img/splash/touch-icon-ipad-retina.png">-->
		
		<!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		
		<!-- Startup image for web apps -->
		<link rel="apple-touch-startup-image" href="asset_vendors/smart/img/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
		<link rel="apple-touch-startup-image" href="asset_vendors/smart/img/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
		<link rel="apple-touch-startup-image" href="asset_vendors/smart/img/splash/iphone.png" media="screen and (max-device-width: 320px)">
</head>

	<body {{$body_attr}} id="body">

		{{--$header--}}

		{{$sidepanel}}

		<div id="main" role="main">
			<!--<div id="ribbon">
				<ol class="breadcrumb">
					
				</ol>
			</div>-->

			<div id="content">
				{{$content}}
			</div>

		</div>

		<div id="floating-footer-option">
			<a href="{{{URL::route('options.floatview')}}}" class="btn btn-info btn-xs" data-toggle="modal" data-target="#remoteModal"> 
				<i class="fa fa-list-ul fa-2x"></i> 
			</a>
		</div>

		{{Larasset::start('footer')->show('scripts')}}

		<!--[if IE 8]>
			<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>
		<![endif]-->
		
		{{Larasset::start()->get_inlinescript()}}

<!-- Dynamic Modal -->  
<div class="modal fade" id="remoteModal" tabindex="-1" role="dialog" aria-labelledby="remoteModalLabel" aria-hidden="true">  
    <div class="modal-dialog">  
        <div class="modal-content">
        	<!-- content will be filled here from "ajax/modal-content/model-content-1.html" -->
        </div>  
    </div>  
</div>  
<!-- /.modal --> 
		
	</body>

</html>