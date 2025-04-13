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
		<div class="footer-wave">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100" preserveAspectRatio="none">
                <path fill="currentColor" d="M0,96L48,80C96,64,192,32,288,32C384,32,480,64,576,69.3C672,75,768,53,864,48C960,43,1056,53,1152,58.7C1248,64,1344,64,1392,64L1440,64L1440,100L1392,100C1344,100,1248,100,1152,100C1056,100,960,100,864,100C768,100,672,100,576,100C480,100,384,100,288,100C192,100,96,100,48,100L0,100Z"></path>
            </svg>
        </div>

		<div class="footer-main">
			<div class="container">
				<div class="footer-columns">
					<!-- Column 1: Logo and About -->
					<div class="footer-column">
						<div class="footer-logo">
							<?php the_custom_logo(); ?>
						</div>
						<div class="footer-about">
							<h3><?php echo esc_html__('Malawi Conference of Catholic Bishops', 'malawi-bishops'); ?></h3>
							<p><?php echo get_theme_mod('malawi_bishops_footer_about', esc_html__('The Episcopal Conference of Malawi is an assembly of Catholic Bishops bringing unity, development, justice, peace, and solidarity to Malawi.', 'malawi-bishops')); ?></p>
						</div>
						<div class="footer-social">
							<?php 
							$facebook = get_theme_mod('malawi_bishops_facebook');
							$twitter = get_theme_mod('malawi_bishops_twitter');
							$youtube = get_theme_mod('malawi_bishops_youtube');
							$instagram = get_theme_mod('malawi_bishops_instagram');
							
							if ($facebook) : ?>
								<a href="<?php echo esc_url($facebook); ?>" target="_blank" aria-label="Facebook">
									<i class="footer-icon facebook-icon"></i>
								</a>
							<?php endif; ?>
							
							<?php if ($twitter) : ?>
								<a href="<?php echo esc_url($twitter); ?>" target="_blank" aria-label="Twitter">
									<i class="footer-icon twitter-icon"></i>
								</a>
							<?php endif; ?>
							
							<?php if ($youtube) : ?>
								<a href="<?php echo esc_url($youtube); ?>" target="_blank" aria-label="YouTube">
									<i class="footer-icon youtube-icon"></i>
								</a>
							<?php endif; ?>
							
							<?php if ($instagram) : ?>
								<a href="<?php echo esc_url($instagram); ?>" target="_blank" aria-label="Instagram">
									<i class="footer-icon instagram-icon"></i>
								</a>
							<?php endif; ?>
						</div>
					</div>
					
					<!-- Column 2: Quick Links -->
					<div class="footer-column">
						<h4 class="footer-title"><?php echo esc_html__('Quick Links', 'malawi-bishops'); ?></h4>
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'footer-menu',
								'menu_id'        => 'footer-menu',
								'container'      => false,
								'menu_class'     => 'footer-menu',
								'fallback_cb'    => 'malawi_bishops_footer_menu_fallback',
							)
						);
?>
					</div>
					
					<!-- Column 3: Contact Info -->
					<div class="footer-column">
						<h4 class="footer-title"><?php echo esc_html__('Contact Us', 'malawi-bishops'); ?></h4>
						<ul class="footer-contact-list">
							<li class="footer-contact-item">
								<i class="footer-icon location-icon"></i>
								<span><?php echo get_theme_mod('malawi_bishops_address', esc_html__('ECM Secretariat, Area 11, Plot #: M1170, Paul VI Road, P.O. Box 30384, Lilongwe, Malawi', 'malawi-bishops')); ?></span>
							</li>
							<li class="footer-contact-item">
								<i class="footer-icon phone-icon"></i>
								<span><?php echo get_theme_mod('malawi_bishops_phone', esc_html__('(+265) 1 772 066', 'malawi-bishops')); ?></span>
							</li>
							<li class="footer-contact-item">
								<i class="footer-icon email-icon"></i>
								<span><?php echo get_theme_mod('malawi_bishops_email', esc_html__('info@mccbmw.org', 'malawi-bishops')); ?></span>
							</li>
						</ul>
					</div>
					
					<!-- Column 4: Newsletter -->
					<div class="footer-column">
						<h4 class="footer-title"><?php echo esc_html__('Newsletter', 'malawi-bishops'); ?></h4>
						<p class="footer-newsletter-text"><?php echo esc_html__('Subscribe to our newsletter for updates on church activities and events.', 'malawi-bishops'); ?></p>
						<!-- Newsletter Form - replace with your newsletter plugin shortcode if needed -->
						<form class="footer-newsletter-form">
							<div class="form-field">
								<input type="email" name="email" placeholder="<?php echo esc_attr__('Your email address', 'malawi-bishops'); ?>" required>
							</div>
							<button type="submit" class="newsletter-button"><?php echo esc_html__('Subscribe', 'malawi-bishops'); ?></button>
						</form>
					</div>
				</div>
			</div>
		</div>
		
		<div class="footer-bottom">
			<div class="container">
				<div class="footer-bottom-content">
					<div class="copyright">
						<?php
						// Get custom copyright text from theme mod or use default
						$copyright_text = get_theme_mod('malawi_bishops_copyright_text', '&copy; ' . date('Y') . ' ' . get_bloginfo('name') . '. ' . __('All Rights Reserved.', 'malawi-bishops'));
						echo wp_kses_post($copyright_text);
						?>
					</div>
					
					<div class="footer-credits">
						<span><?php echo sprintf(esc_html__('Designed by %s', 'malawi-bishops'), '<a href="' . esc_url('https://revelation.africa/') . '" target="_blank">Revelation Nyirongo</a>'); ?></span>
					</div>
				</div>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<!-- Corner Peel Date/Time Toggle -->
<div class="corner-peel">
    <div class="corner-peel-front">
        <div class="corner-peel-icon">
            <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3ZM19 19H5V9H19V19ZM5 7V5H19V7H5ZM7 11H17V13H7V11ZM7 15H14V17H7V15Z" />
            </svg>
        </div>
    </div>
    <div class="corner-peel-back">
        <div class="date-time-display">
            <div class="current-date"></div>
            <div class="current-time"></div>
        </div>
    </div>
</div>

<?php wp_footer(); ?>

</body>
</html>
