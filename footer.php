<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Malawi_Bishops
 */

?>

	<footer id="colophon" class="site-footer">
		<div class="container">
			<div class="footer-widgets">
				<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
					<div class="footer-widget-area">
						<?php dynamic_sidebar( 'footer-1' ); ?>
					</div>
				<?php endif; ?>

				<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
					<div class="footer-widget-area">
						<?php dynamic_sidebar( 'footer-2' ); ?>
					</div>
				<?php endif; ?>

				<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
					<div class="footer-widget-area">
						<?php dynamic_sidebar( 'footer-3' ); ?>
					</div>
				<?php endif; ?>

				<?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
					<div class="footer-widget-area">
						<?php dynamic_sidebar( 'footer-4' ); ?>
					</div>
				<?php endif; ?>
			</div>

			<div class="site-info">
				<?php
				$copyright_text = get_theme_mod( 'malawi_bishops_copyright_text', '&copy; ' . date( 'Y' ) . ' ' . get_bloginfo( 'name' ) . '. All Rights Reserved.' );
				echo wp_kses_post( $copyright_text );
				?>
			</div><!-- .site-info -->
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
