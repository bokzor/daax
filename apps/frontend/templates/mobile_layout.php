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
		<?php include_partial('home/css') ?>




		<!-- JavaScript at bottom except for Modernizr -->
		<script src="/js/libs/modernizr.custom.js"></script>
		<script src="/js/libs/jquery-1.8.2.min.js"></script>


	

		<!-- For Modern Browsers 
		<link rel="shortcut icon" href="/image/favicons/favicon.png"> -->
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

			
			
	</head> 

	<body class="clearfix with-menu with-shortcuts" >

		<!-- loader -->
		<!-- affiche une page tempon le temps que le css et javascript se charge -->
		<span id="load" >
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
		<section role="main" id="main" class="container" style="opacity: 0;">
			<?php echo $sf_content ?>
		</section>
		<!-- End main content -->

		<!-- Side tabs shortcuts -->
		
		<ul style="display:none;" id="shortcuts" role="complementary" class="children-tooltip tooltip-right" >
			<?php if($sf_user->isAuthenticated() && $sf_user->hasCredential('manager')): ?>
			<li >
				<a href="<?php echo url_for('@full_live_commande') ?>" title="Commandes Live">Commandes Live</a>
			</li>
			<?php endif; ?>
			<?php if($sf_user->isAuthenticated()): ?>
			<li>
				<a href="<?php echo url_for('@homepage') ?>"  title="Passer une commande">Passer une commande</a>
			</li>
			<li>
				<a href="<?php echo url_for('@gestion_commande') ?>"  title="Gestion commande">Gestion des commandes</a>
			</li>
			<?php endif; ?>
			<?php if($sf_user->isAuthenticated() && $sf_user->hasCredential('manager')): ?>
			<li >
				<a href="<?php echo url_for('@gestion_utilisateur') ?>" title="Gestion utilisateur">Gestion des utilisateurs</a>
			</li>
			<li>
				<a href="<?php echo url_for('@gestion_stock') ?>"  title="Gestion stock">Gestion du stock</a>
			</li>
			<li>
				<a href="<?php echo url_for('@gestion_article') ?>"  title="Gestion des articles">Gestion des articles</a>
			</li>				

			<li>
				<a href="<?php echo url_for('@stat') ?>" title="Statistiques">Statistiques</a>
			</li>
			<li>
				<a href="<?php echo url_for('@gestion_tools') ?>"  title="Outils">Outils</a>
			</li>
			<?php endif; ?>
			<?php if($sf_user->isAuthenticated() && $sf_user->hasCredential('superadmin')): ?>
			<!-- <li>
				<a href="<?php echo url_for('@gestion_floor') ?>"  class="shortcut-floor" title="Gestion du plan de table">Gestion du plan de table</a>
			</li> -->	
			<?php endif; ?> 
			<li>
				<a href="<?php echo url_for('@sf_guard_signout') ?>"  title="Se déconnecter">Se déconnecter</a>
			</li>		

		</ul>
		<!-- Sidebar/drop-down menu -->
		<?php if($sf_user->isAuthenticated()): ?>
		<section id="menu" role="complementary">
			<!-- This wrapper is used by several responsive layouts -->
			<div id="menu-content">
			<button id="menu-button" class="button">Menu</button>


				<!-- By default, this section is made for 4 icons, see the doc to learn how to change this, in "basic markup explained" -->
				<div id="controlleurCommande">
					<?php include_partial('home/controlleurCommande') ?>
				</div>



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
	<div id="sidebar" style="display: none">
		<div id="profile">
			<?php echo showThumb($sf_user->getGuardUser()->getAvatar(), 'avatar', $options = array('alt' => 'Avatar', 'width' => '60', 'height' => '60', 'title' => 'Avatar', 'class' => 'user-icon'), $resize = 'fit', $default = 'default.jpg') ?> 
			<span class="name"><?php echo $sf_user->getGuardUser()->getFirstName() ?>
				<b><?php echo $sf_user->getGuardUser()->getLastName() ?></b>
			</span>
		</div>
		<ul class="no-load">
			<?php if($sf_user->isAuthenticated() && $sf_user->hasCredential('manager')): ?>
			<li >
				<a href="<?php echo url_for('@full_live_commande') ?>"   title="Commandes Live">Commandes Live</a>
			</li>
			<?php endif; ?>
			<?php if($sf_user->isAuthenticated()): ?>
			<li>
				<a href="<?php echo url_for('@homepage') ?>" title="Passer une commande">Passer une commande</a>
			</li>
			<li>
				<a href="<?php echo url_for('@gestion_commande') ?>" title="Gestion commande">Gestion des commandes</a>
			</li>
			<?php endif; ?>
			<?php if($sf_user->isAuthenticated() && $sf_user->hasCredential('manager')): ?>
			<li >
				<a href="<?php echo url_for('@gestion_utilisateur') ?>"  title="Gestion utilisateur">Gestion des utilisateurs</a>
			</li>
			<li>
				<a href="<?php echo url_for('@gestion_stock') ?>"  title="Gestion stock">Gestion du stock</a>
			</li>
			<li>
				<a href="<?php echo url_for('@gestion_article') ?>"   title="Gestion des articles">Gestion des articles</a>
			</li>				

			<li>
				<a href="<?php echo url_for('@stat') ?>" title="Statistiques">Statistiques</a>
			</li>
			<li>
				<a href="<?php echo url_for('@gestion_tools') ?>"  title="Outils">Outils</a>
			</li>
			<?php endif; ?>
			<?php if($sf_user->isAuthenticated() && $sf_user->hasCredential('superadmin')): ?>
			<!-- <li>
				<a href="<?php echo url_for('@gestion_floor') ?>"  class="shortcut-floor" title="Gestion du plan de table">Gestion du plan de table</a>
			</li> -->	
			<?php endif; ?> 
			<li>
				<a href="<?php echo url_for('@sf_guard_signout') ?>"  title="Se déconnecter">Se déconnecter</a>
			</li>	
		</ul>
	</div>

	
	</body>
	<?php include_partial('home/js') ?>
	<script src="/js/backbone/main.js"></script>
	<script src="/js/backbone/models.js"></script>
	<script src="/js/backbone/views.js"></script>
	<script src="/js/backbone/grid.js"></script>
	<script>
	$(window).load(function () {
	 $('#load').transition({opacity: 0 }, 400, function () {
	     $('#main').transition({opacity: 1}, 600, function () {});
	 });
	});
	</script>
	<script>
	$('#menu-button, #open-shortcuts').sidr({
	  name: 'sidr-main',
	  source: '#sidebar',
	  side: 'right',
	  body: '#menu',
	});
</script>
</html>