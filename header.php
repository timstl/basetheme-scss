<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php 
theme_custom_scripts_css('pre-wp_head');
wp_head(); 
theme_custom_scripts_css('header'); 
?>
</head>
<body <?php body_class(); ?>>
<div id="wrapper">
	<a href="#main" class="sr-only sr-only-focusable skipnav"><?php _e('Skip to main content', 'basetheme'); ?></a>
	<header id="header" class="clearfix">
		<div class="container">
			<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="Home" id="logo"><?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></a>
			<!-- Begin Navigation -->
			<nav class="navbar navbar-default" role="navigation">
				
				    <!-- Brand and toggle get grouped for better mobile display -->
				    <div class="navbar-header">
				      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav-container">
				        <span class="sr-only">Toggle navigation</span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				      </button>
				    </div>
				
				    <!-- Collect the nav links, forms, and other content for toggling -->
				    <div class="collapse navbar-collapse" id="main-nav-container">
				     <?php
					 	//FB and Twitter are appended in functions.php
						$args = array(
							'theme_location' => 'mainnav',
							'depth'		 => 0,
							'container'	 => false,
							'menu_class'	 => 'clearfix',
							'menu_id' => 'main-nav',
							'walker'	 => new BootstrapNavMenuWalker()
						);
		
						wp_nav_menu($args);
			
					?>
				    </div><!-- /.navbar-collapse -->
				    
			</nav>
			<!-- End Navigation -->
		</div>
	</header>