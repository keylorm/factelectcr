<!DOCTYPE html>
<html ng-app="myApp">
	<head>
		<meta charset="UTF-8">
		<meta name="author" content="Keylor Mora">
		<meta http-equiv="x-ua-compatible" content="ie=edge, chrome=1">
		<meta name="MobileOptimized" content="width">
		<meta name="HandheldFriendly" content="true">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0, shrink-to-fit=no">
		<meta http-equiv="cleartype" content="on">

		

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
		


		<!-- Custom fonts for this template-->
    	<link href="/fe_pub/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    	<link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css	" rel="stylesheet" type="text/css">    	
		<link rel="stylesheet" type="text/css" href="/fe_pub/css/bootstrap-datepicker3.standalone.min.css" />
		<link rel="stylesheet" type="text/css" href="/fe_pub/css/bootstrap-datepicker3.min.css" />
		<link rel="stylesheet" type="text/css" href="/fe_pub/css/chosen.min.css" />
		<link rel="stylesheet" type="text/css" href="/fe_pub/css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="/fe_pub/css/layout.css" />
		<link rel="stylesheet" type="text/css" href="/fe_pub/css/colores.css" />
		<link rel="stylesheet" type="text/css" href="/fe_pub/css/ip_style.css" />
		<link rel="stylesheet" type="text/css" href="/fe_pub/css/general.css" />
		<link rel="stylesheet" type="text/css" href="/fe_pub/css/mobile.css" />
		<link rel="stylesheet" type="text/css" href="/fe_pub/css/tablet.css" />
		<link rel="stylesheet" type="text/css" href="/fe_pub/css/desktop.css" />
		

		<script src="//code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>	
		<script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
		<script src="//cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
		<script src="//code.angularjs.org/1.6.7/angular.min.js"></script>
		<script src="/fe_pub/js/bootstrap-datepicker.min.js"></script>
		<script src="/fe_pub/js/chosen.jquery.min.js"></script>
		<script src="/fe_pub/js/jquery.maskMoney.min.js"></script>
		<script src="/fe_pub/js/Chart.js"></script>
		<script src="/fe_pub/js/angular-chart.min.js"></script>
		<script src="/fe_pub/js/general.js"></script>

		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<title><?=@$title?></title>
		
	</head>
	<body  class="fixed-nav sticky-footer" id="page-top">
		<?php require_once 'menu.php'; ?>
		
		<?php if($loggedin){ ?>
			<div class="content-wrapper">
		<?php }else{ ?>
			<div class="content-wrapper-full">	
		<?php } ?>
					