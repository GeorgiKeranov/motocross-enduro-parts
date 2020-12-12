<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="wrapper">
	<header class="header">
		<div class="shell">
			<div class="header__inner">
				<div class="header__logo">
					<a href="<?php echo home_url('/') ?>" class="logo"></a>
				</div><!-- /.header__logo -->

				<div class="header__body">
					<?php if ( has_nav_menu( 'header-menu' ) ) : ?>
						<div class="header__nav">
							<?php wp_nav_menu( array(
								'theme_location' => 'header-menu',
								'container' => 'nav',
								'container_class' => 'nav'
							) ) ?>
						</div><!-- /.header__nav -->
					<?php endif; ?>

					<div class="header__shopping-cart">
						<a class="ico-shopping-cart" href="<?php echo wc_get_cart_url() ?>">
							<span id="mini-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
						</a>
					</div><!-- /.header__shopping-cart -->

					<div class="header__menu-toggle">
						<div></div>

						<div></div>

						<div></div>
					</div><!-- /.header__menu-toggle -->
				</div><!-- /.header__body -->
			</div><!-- /.header__inner -->
		</div><!-- /.shell -->
	</header><!-- /.header -->

	<main class="main">	