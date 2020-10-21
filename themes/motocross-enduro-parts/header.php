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
					<div class="header__nav">
						<nav class="nav">
							<ul>
								<li>
									<a href="#">Части</a>
								</li>

								<li>
									<a href="#">Контакти</a>
								</li>
							</ul>
						</nav><!-- /.nav -->
					</div><!-- /.header__nav -->

					<div class="header__shopping-cart">
						<a href="#">
							<i class="ico-shopping-cart"></i>

							<span>5</span>
						</a>
					</div><!-- /.header__shopping-cart -->
				</div><!-- /.header__body -->
			</div><!-- /.header__inner -->
		</div><!-- /.shell -->
	</header><!-- /.header -->