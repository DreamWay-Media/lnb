<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="google-site-verification" content="QcGc_tOX75xn0A7oHOlF_Nm0SN89mlryd3Z5WZc2qhU" />

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
$custom_logo_id = get_theme_mod( 'custom_logo' );
$logo           = $custom_logo_id ? wp_get_attachment_image_src( $custom_logo_id, 'full' ) : false;
?>
  <header class="header">
      <div class="top_ribbon row">
		<div class="top_ribbon_left col-sm-12 col-md-12 col-lg-6 text-left"><?php dynamic_sidebar( 'top_ribbon_left' ); ?></div>
		<div class="top_ribbon_right col-sm-12 col-md-12 col-lg-6 text-end"><?php dynamic_sidebar( 'top_ribbon_right' ); ?></div>
	  </div>
	<nav>
		<div class="container">
			<div class="large-nav row nopadmar d-xs-none">
				<div class="logo col-3 nopadmar">
					<?php
					if ( has_custom_logo() && ! empty( $logo[0] ) ) {
						echo '<a href="' . esc_url( home_url( '/' ) ) . '"><img src="' . esc_url( $logo[0] ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '"></a>';
					} else {
						echo '<h1>' . esc_html( get_bloginfo( 'name' ) ) . '</h1>';
					}
					?>
				</div>
				<div class="navbar col-6 nopadmar">
					<?php wp_nav_menu( dwm_lnb_nav_main_menu_args() ); ?>
				</div>
				<div class="booking col-3 nopadmar">
					<?php wp_nav_menu( dwm_lnb_nav_booking_menu_args() ); ?>
				</div>
			</div>
			<div class="row nopadmar small-nav d-xl-none">
				  <div class="row">
					<div class="col-lg-3 col-md-3 col-sm-4 col-4">
					  <div class="header-logo">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
						  <?php
							if ( has_custom_logo() && ! empty( $logo[0] ) ) {
								echo '<img src="' . esc_url( $logo[0] ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '">';
							} else {
								echo '<h1>' . esc_html( get_bloginfo( 'name' ) ) . '</h1>';
							}
							?>
						</a>
					  </div>
					</div>
					<div class="booking col-lg-8 col-md-8 col-sm-6 col-6">
					  <?php wp_nav_menu( dwm_lnb_nav_booking_menu_args() ); ?>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-2 col-2">
					  <div class="burger">
						 <button class="burger-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop">
							<span></span>
							<span></span>
							<span></span>
						 </button>

						<div class="offcanvas offcanvas-top" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel">
						  <div class="offcanvas-body">
							<div class="row">
							  <div class="mob-menu">
								<?php wp_nav_menu( dwm_lnb_nav_main_menu_args() ); ?>
							  </div>

							  <div class="social">
								<?php if(is_active_sidebar('header_social')):?>
								  <?php dynamic_sidebar( 'header_social' ); ?>
								<?php endif;?>
							  </div>
							</div>
						  </div>
						</div>
					  </div>
					</div>
				  </div>
			</div>
		</div>
	</nav>
  </header>
	
