<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' – '; } ?> <?php bloginfo('name'); ?></title>

		<link href="//www.google-analytics.com" rel="dns-prefetch">

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>

		<div class="wrapper">
			
			<header class="header clear" role="banner">
				<div class="logo">
					<a href="<?php echo home_url(); ?>">
						<?php
						if ( get_theme_mod( 'header_logo' ) ) : ?>
							<img src="<?php echo get_theme_mod( 'header_logo' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="logo-img">
						<?php else : 
							echo get_bloginfo( 'name', 'display' );
						endif; ?>
					</a>
				</div>

				<nav class="nav" role="navigation">
					<?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
				</nav>
			</header>
