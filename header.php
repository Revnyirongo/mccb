<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and header elements
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Malawi_Bishops
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'malawi-bishops' ); ?></a>

	<!-- Scroll Progress Tracker -->
	<div class="scroll-progress-tracker">
		<div class="progress-indicator"></div>
	</div>

	<!-- Scroll Loader Animation -->
	<div class="scroll-loader">
		<div class="loader-line"></div>
	</div>

	<header id="masthead" class="site-header">
		<div class="header-wrapper">
			<div class="top-bar">
				<div class="contact-info">
					<a href="mailto:info@mccbmw.org"><i class="header-icon email-icon"></i>info@mccbmw.org</a>
				</div>
				
				<!-- News Ticker -->
				<div class="news-ticker-container">
				    <div class="ticker-label"><?php esc_html_e('Latest:', 'malawi-bishops'); ?></div>
				    <div class="news-ticker">
					    <div class="ticker-wrapper">
						    <?php
						    // Get posts with 'announcements' category
						    $ticker_args = array(
							    'category_name' => 'announcements',
							    'posts_per_page' => 5,
							    'post_status' => 'publish',
						    );
						    $ticker_query = new WP_Query($ticker_args);
						
						    if ($ticker_query->have_posts()) :
							    while ($ticker_query->have_posts()) : $ticker_query->the_post();
								    echo '<div class="ticker-item"><a href="' . esc_url(get_permalink()) . '">' . get_the_title() . '</a></div>';
							    endwhile;
							    wp_reset_postdata();
						    else :
							    echo '<div class="ticker-item">' . esc_html__('Welcome to the Conference of Catholic Bishops in Malawi', 'malawi-bishops') . '</div>';
						    endif;
						    ?>
					    </div>
				    </div>
				</div>
				
				<div class="social-icons">
					<?php 
						$facebook = get_theme_mod( 'malawi_bishops_facebook' );
						$twitter = get_theme_mod( 'malawi_bishops_twitter' );
						$youtube = get_theme_mod( 'malawi_bishops_youtube' );
						
						if ( $facebook ) {
							echo '<a href="' . esc_url( $facebook ) . '" target="_blank" aria-label="Facebook"><i class="header-icon facebook-icon"></i></a>';
						}
						
						if ( $twitter ) {
							echo '<a href="' . esc_url( $twitter ) . '" target="_blank" aria-label="Twitter"><i class="header-icon twitter-icon"></i></a>';
						}
						
						if ( $youtube ) {
							echo '<a href="' . esc_url( $youtube ) . '" target="_blank" aria-label="YouTube"><i class="header-icon youtube-icon"></i></a>';
						}
					?>
				</div>
			</div>

			<div class="site-branding">
				<?php
				the_custom_logo();
				if ( is_front_page() && is_home() ) :
					?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php
				else :
					?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php
				endif;
				$malawi_bishops_description = get_bloginfo( 'description', 'display' );
				if ( $malawi_bishops_description || is_customize_preview() ) :
					?>
					<p class="site-description"><?php echo $malawi_bishops_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
				<?php endif; ?>
			</div><!-- .site-branding -->

			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">☰</button>

			<nav id="site-navigation" class="main-navigation">
				<div class="nav-container">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'main-menu',
							'menu_id'        => 'primary-menu',
							'container'      => false,
							'menu_class'     => 'main-menu',
						)
					);
					?>
				</div>
			</nav><!-- #site-navigation -->
			
			<!-- Menu Progress Bar -->
			<div class="menu-progress-bar">
				<div class="progress-line"></div>
			</div>
		</div><!-- .header-wrapper -->
	</header><!-- #masthead -->

	<!-- Corner Peel Date/Time Toggle -->
	<div class="corner-peel">
		<div class="corner-peel-front">
			<div class="corner-peel-icon">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M17 3h4a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h4V1h2v2h6V1h2v2zm-2 2H9v2H7V5H4v4h16V5h-3v2h-2V5zm5 6H4v8h16v-8z"/></svg>
			</div>
		</div>
		<div class="corner-peel-back">
			<div class="date-time-display">
				<div class="current-date"></div>
				<div class="current-time"></div>
			</div>
		</div>
	</div>
