<?php
/**
 * The header for our theme with fixes
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
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'malawi-bishops'); ?></a>

	<!-- Scroll Progress Tracker -->
	<div class="scroll-progress-tracker">
		<div class="progress-indicator"></div>
	</div>

	<header id="masthead" class="site-header">
		<div class="header-wrapper">
			<div class="top-bar">
				<div class="contact-info">
					<a href="mailto:info@mccbmw.org"><i class="header-icon email-icon"></i>info@mccbmw.org</a>
				</div>
				
				<?php 
				// Check for the function first to avoid errors
				if (function_exists('malawi_bishops_display_scrolling_text') && get_theme_mod('malawi_bishops_enable_scrolling_text', false)) {
					malawi_bishops_display_scrolling_text();
				} else {
					// Fallback scrolling text if function doesn't exist
					echo '<div class="scrolling-text-container">';
					echo '<div class="scrolling-text-wrapper">';
					echo '<div class="scrolling-text-item">' . esc_html__('Welcome to the Conference of Catholic Bishops in Malawi', 'malawi-bishops') . '</div>';
					echo '</div>';
					echo '</div>';
				}
				?>
				
				<div class="social-icons">
					<?php 
						$facebook = get_theme_mod('malawi_bishops_facebook');
						$twitter = get_theme_mod('malawi_bishops_twitter');
						$youtube = get_theme_mod('malawi_bishops_youtube');
						
						if ($facebook) {
							echo '<a href="' . esc_url($facebook) . '" target="_blank" aria-label="Facebook"><i class="header-icon facebook-icon"></i></a>';
						}
						
						if ($twitter) {
							echo '<a href="' . esc_url($twitter) . '" target="_blank" aria-label="Twitter"><i class="header-icon twitter-icon"></i></a>';
						}
						
						if ($youtube) {
							echo '<a href="' . esc_url($youtube) . '" target="_blank" aria-label="YouTube"><i class="header-icon youtube-icon"></i></a>';
						}
					?>
				</div>
			</div>

			<div class="site-branding">
				<?php
				the_custom_logo();
				if (is_front_page() && is_home()) :
					?>
					<h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
					<?php
				else :
					?>
					<p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></p>
					<?php
				endif;
				$malawi_bishops_description = get_bloginfo('description', 'display');
				if ($malawi_bishops_description || is_customize_preview()) :
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
							'fallback_cb'    => 'malawi_bishops_main_menu_fallback',
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
	
<?php
/**
 * Fallback for main menu if none is set
 */
function malawi_bishops_main_menu_fallback() {
	echo '<ul class="main-menu">';
	echo '<li><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'malawi-bishops') . '</a></li>';
	echo '</ul>';
}
?>
