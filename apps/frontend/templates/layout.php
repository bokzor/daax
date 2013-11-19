<?php use_helper('Thumb'); ?>
<!DOCTYPE html>

<!--[if IEMobile 7]><html class="no-js iem7 oldie"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html class="no-js ie7 oldie" lang="en"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html class="no-js ie8 oldie" lang="en"><![endif]-->
<!--[if (IE 9)&!(IEMobile)]><html class="no-js ie9" lang="en"><![endif]-->
<!--[if (gt IE 9)|(gt IEMobile 7)]><!-->
<html id="fullScreen" class="linen no-js" lang="en">
	<!--<![endif]-->

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>LiveOrder</title>
		<meta name="description" content="">
		<meta name="author" content="">
		<!-- http://davidbcalhoun.com/2010/viewport-metatag -->
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<!-- For all browsers -->
		<link rel="stylesheet" href="/css/reset.css">
		<link rel="stylesheet" href="/css/style.css">
		<link rel="stylesheet" href="/css/colors.css">

		<link rel="stylesheet" media="print" href="/css/print.css">
		<!-- For progressively larger displays -->
		<link rel="stylesheet" media="only all and (min-width: 480px)" href="/css/480.css">
		<link rel="stylesheet" media="only all and (min-width: 768px)" href="/css/768.css">
		<link rel="stylesheet" media="only all and (min-width: 952px)" href="/css/992.css">
		<link rel="stylesheet" media="only all and (min-width: 1200px)" href="/css/1200.css">
		<!-- For Retina displays -->
		<link rel="stylesheet" media="only all and (-webkit-min-device-pixel-ratio: 1.5), only screen and (-o-min-device-pixel-ratio: 3/2), only screen and (min-device-pixel-ratio: 1.5)" href="/css/2x.css">
		<!-- Webfonts -->
		<!-- Additional styles -->
		<link rel="stylesheet" href="/css/styles/dashboard.css">
		<link rel="stylesheet" href="/css/jquery.keypad.css">
		<link rel="stylesheet" href="/js/libs/glDatePicker/developr.css">
		<link rel="stylesheet" href="/css/styles/jqpagination.css">
		<link rel="stylesheet" href="/css/styles/form.css">
		<link rel="stylesheet" href="/css/styles/progress-slider.css">
		<link rel="stylesheet" href="/css/styles/switches.css">
		<link rel="stylesheet" href="/css/styles/files.css">
		<link rel="stylesheet" href="/css/styles/agenda.css">
		<link rel="stylesheet" href="/css/styles/table.css">
		<link rel="stylesheet" href="/css/styles/modal.css">
		<link rel="stylesheet" href="/css/timepicker.css">
		<link rel="stylesheet" href="/css/mobiscroll.css">
		<link rel="stylesheet" href="/css/floor.css">
		<link rel="stylesheet" href="/js/libs/DataTables/jquery.dataTables.css">
		<link rel="stylesheet" href="/css/new_login/core.css">

	   	<!-- feuille de style pour les clients -->
		<?php if($sf_user->isAuthenticated() && !$sf_user->hasCredential('manager')): ?>
		<link rel="stylesheet" href="/css/client.css">
		<?php endif; ?>




		<!-- JavaScript at bottom except for Modernizr -->
		<script src="/js/libs/modernizr.custom.js"></script>
		<script src="/js/libs/jquery-1.8.2.min.js"></script>


	

		<!-- For Modern Browsers -->
		<link rel="shortcut icon" href="/image/favicons/favicon.png">
		<!-- For everything else -->
		<link rel="shortcut icon" href="/image/favicons/favicon.ico">
		<!-- For retina screens -->
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/image/favicons/apple-touch-icon-retina.png">
		<!-- For iPad 1-->
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/image/favicons/apple-touch-icon-ipad.png">
		<!-- For iPhone 3G, iPod Touch and Android -->
		<link rel="apple-touch-icon-precomposed" href="/image/favicons/apple-touch-icon.png">

		<!-- iOS web-app metas -->
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">

		<!-- Startup image for web apps -->
		<link rel="apple-touch-startup-image" href="/image/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
		<link rel="apple-touch-startup-image" href="/image/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
		<link rel="apple-touch-startup-image" href="/image/splash/iphone.png" media="screen and (max-device-width: 320px)">

		<!-- Microsoft clear type rendering -->
		<meta http-equiv="cleartype" content="on">
		<!-- Css pour le loader -->
		<style type = "text/css">
		    #loading-container {position: absolute; top:50%; left:50%;}
		    #loading-content {width:800px; text-align:center; margin-left: -400px; height:50px; margin-top:-25px; line-height: 50px;}
		    #loading-content {font-family: "Helvetica", "Arial", sans-serif; font-size: 18px; color: black; text-shadow: 0px 1px 0px white; }
		    #loading-graphic {margin-right: 0.2em; margin-bottom:-2px;}
		    #loading { background-color: #F7F7F7; height:100%; width:100%; overflow:hidden; position: absolute; left: 0; top: 0; z-index: 99999;}
		</style>
			
			
	</head> 

	<body class="clearfix with-menu with-shortcuts" >
		
		<!-- loader -->
		<!-- affiche une page tempon le temps que le css et javascript se charge -->
		<span id="load" style="display: none;">
			<img src="/image/new_login/img/load.png"><img src="/image/new_login/img/spinner.png" id="spinner">
		</span>

		<!-- fin loader -->
		
		<!-- Title bar -->
		<header style="z-index: 999;" role="banner" id="title-bar">
			
		<!-- Button to open/hide menu -->
		<?php if($sf_user->isAuthenticated()): ?>
			<a href="#" id="open-menu"><span>Commande</span></a>
			<!-- Button to open/hide shortcuts -->
			<a href="#" id="open-shortcuts"><span class="icon-thumbs"></span></a>
		<?php endif; ?>
		</header>


		
		<!-- Main content -->
		<section role="main" id="main" style="display: none;">
			<?php echo $sf_content ?>
		</section>
		<!-- End main content -->

		<!-- Side tabs shortcuts -->
		
		<ul id="shortcuts" role="complementary" class="children-tooltip tooltip-right" >
			<?php if($sf_user->isAuthenticated() && $sf_user->hasCredential('manager')): ?>
			<li >
				<a href="<?php echo url_for('@full_live_commande') ?>"  class="shortcut-live" title="Commandes Live">Commandes Live</a>
			</li>
			<?php endif; ?>
			<?php if($sf_user->isAuthenticated()): ?>
			<li>
				<a href="<?php echo url_for('@homepage') ?>" class="shortcut-notes" title="Passer une commande">Passer une commande</a>
			</li>
			<li>
				<a href="<?php echo url_for('@gestion_commande') ?>" class="shortcut-commande" title="Gestion commande">Gestion des commandes</a>
			</li>
			<?php endif; ?>
			<?php if($sf_user->isAuthenticated() && $sf_user->hasCredential('manager')): ?>
			<li >
				<a href="<?php echo url_for('@gestion_utilisateur') ?>" class="shortcut-contacts" title="Gestion utilisateur">Gestion des utilisateurs</a>
			</li>
			<li>
				<a href="<?php echo url_for('@gestion_stock') ?>" class="shortcut-stock" title="Gestion stock">Gestion du stock</a>
			</li>
			<li>
				<a href="<?php echo url_for('@gestion_article') ?>"  class="shortcut-article" title="Gestion des articles">Gestion des articles</a>
			</li>				

			<li>
				<a href="<?php echo url_for('@stat') ?>"  class="shortcut-stats" title="Statistiques">Statistiques</a>
			</li>
			<li>
				<a href="<?php echo url_for('@gestion_tools') ?>" class="shortcut-tools" title="Outils">Outils</a>
			</li>
			<?php endif; ?>
			<?php if($sf_user->isAuthenticated() && $sf_user->hasCredential('superadmin')): ?>
			<!-- <li>
				<a href="<?php echo url_for('@gestion_floor') ?>"  class="shortcut-floor" title="Gestion du plan de table">Gestion du plan de table</a>
			</li> -->	
			<?php endif; ?> 
			<li>
				<a href="<?php echo url_for('@sf_guard_signout') ?>" class="shortcut-delete" title="Se déconnecter">Se déconnecter</a>
			</li>		

		</ul>
		<!-- Sidebar/drop-down menu -->
		<?php if($sf_user->isAuthenticated()): ?>
		<section id="menu" role="complementary">
			<!-- This wrapper is used by several responsive layouts -->
			<div id="menu-content">
				<div id="profile">
					<?php echo showThumb($sf_user->getGuardUser()->getAvatar(), 'avatar', $options = array('alt' => 'Avatar', 'width' => '64', 'height' => '64', 'title' => 'Avatar', 'class' => 'user-icon'), $resize = 'fit', $default = 'default.jpg') ?> 
					Salut
					<span class="name"><?php echo $sf_user->getGuardUser()->getFirstName() ?>
						<b><?php echo $sf_user->getGuardUser()->getLastName() ?></b>
					</span>
				</div>

				<!-- By default, this section is made for 4 icons, see the doc to learn how to change this, in "basic markup explained" -->
				<ul  class="access children-tooltip">
					<?php if($sf_user->isAuthenticated() && $sf_user->hasCredential('serveur')): ?>
					<li>
						<a href="#" class="close-menu" onclick="encaisser(0);" title="Encaisser la commande">
							<span class="icon-green icon-tick"></span>
						</a>
					</li>
					<li>
						<a href="#" class="close-menu" onclick="chargerCommande();" title="Charger une commande">
							<span class="icon-inbox"></span>
						</a>
					</li>
					<?php endif; ?>
					<li>
						<a href="#" class="close-menu" onclick="imprimer()" id="imprimer" title="Imprimer la commande">
							<span class="icon-mobile"></span>
						</a>
					</li>
					<li>
						<a href="#" class="close-menu" onclick="clearCommande()" id="messages-clear" title="Annuler la commande">
							<span class="icon-cross icon-red"></span>
						</a>
					</li>
				</ul>



				<details open id="commandeDetails" class="details margin-bottom">
				<summary role="button" aria-expanded="false">Nouvelle commande</summary>
					<div class="linen">
						<div class="boxed white-bg " id="message-block"></div>
					</div>
					<ul class="unstyled-list">
						<li class="title-menu">
							Total :
						</li>
						<li class="white-gradient dark-text-bevel">
							<h2 class="no-margin-bottom align-center"><span class="total-euro">0</span> €</h2>
						</li>
	
					</ul>
					<?php if($sf_user->isAuthenticated() && $sf_user->hasCredential('serveur')): ?>
					<ul class="unstyled-list">
						<li class="title-menu">
							A rendre :
						</li>
						<li class="white-gradient dark-text-bevel">
							<h2 class="no-margin-bottom align-center"><span class="rendre-euro">0</span> €</h2>
						</li>
	
					</ul>
					<ul class="unstyled-list">
						<li class="title-menu">
							Cashback :
						</li>
						<li class="white-gradient dark-text-bevel">
							<h2 class="no-margin-bottom align-center"><span class="cashback-euro">0</span> €</h2>
						</li>
	
					</ul>
					<?php endif; ?>
					<div class="boxed white-bg " id="payment-block"></div>
				
					
				</details>
				<details id="commandeLiveDetails" class="scrollable details">
				<summary role="button" aria-expanded="false">Commandes Live</summary>
				<div id="commandeLiveContainer"></div>
				</details>
			
			<!-- End content wrapper -->
		<input type="hidden" id="table-id" value="" />
		<input type="hidden" id="commande-id" value="" />

		</div>
		
		</section>
		<?php endif; ?>
		
		<!-- View backbones -->
		<?php include_partial('js/backboneViews') ?>		
		
	</body>
	<script src="/js/libs/quo.js"></script>
	<script src="/js/libs/underscore-min.js"></script>
	<script src="/js/libs/backbone-min.js"></script>
	<script src="/js/setup.js"></script>

	<!-- Template functions -->
	<script src="/js/libs/jquery.jqpagination.min.js"></script>
	<script src="/js/timepicker-mobiscroll.js"></script>
	<script src="/js/timepicker.js"></script>		
	<script src="/js/developr.input.js"></script>
	<script src="/js/developr.modal.js"></script>
	<script src="/js/developr.message.js"></script>
	<script src="/js/developr.notify.js"></script>
	<script src="/js/developr.scroll.js"></script>
	<script src="/js/developr.tooltip.js"></script>
	<script src="/js/jquery.keypad.js"></script>
	<script src="/js/developr.confirm.js"></script>
	<script src="/js/developr.wizard.js"></script>


	<!-- Must be loaded last -->
	<script src="/js/developr.tabs.js"></script>
	<script src="/js/developr.table.js"></script>

	<!-- Must be loaded last -->
	<script src="/js/libs/jquery.tablesorter.min.js"></script>
	<script src="/js/libs/DataTables/jquery.dataTables.min.js"></script>
	<script src="/js.js"></script>
	<script src="/js/backbone/main.js"></script>
	<script src="/js/backbone/models.js"></script>
	<script src="/js/backbone/views.js"></script>
	<script>
	$('#load').fadeIn(400);
	$(window).load(function () {
	 $('#load').fadeOut(400, function () {
	     $('#main').fadeIn(600, function () {});
	 });
	});
	</script>

</html>