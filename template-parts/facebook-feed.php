<?php
/**
 * Template part for displaying the Facebook feed section
 *
 * @package Malawi_Bishops
 */

// You can customize these values in your theme customizer
$facebook_page_url = get_theme_mod('malawi_bishops_facebook_page', 'https://www.facebook.com/MalawiCatholicBishops');
$facebook_shortcode = get_theme_mod('malawi_bishops_facebook_shortcode', '[facebook_page_plugin href="https://www.facebook.com/MalawiCatholicBishops" width="500" height="500" tabs="timeline"]');
?>

<section class="facebook-feed-section">
    <div class="container">
        <div class="facebook-feed-wrapper">
            <!-- Left side - Section header -->
            <div class="facebook-feed-left">
                <div class="facebook-feed-sticky">
                    <h2 class="section-title"><?php echo esc_html__('Connect With Us', 'malawi-bishops'); ?></h2>
                    <div class="title-underline"></div>
                    <p class="section-description">
                        <?php echo esc_html__('Stay updated with the latest news, events, and announcements from the Malawi Conference of Catholic Bishops.', 'malawi-bishops'); ?>
                    </p>
                    
                    <div class="social-buttons">
                        <?php 
                        $facebook_url = get_theme_mod('malawi_bishops_facebook');
                        $twitter_url = get_theme_mod('malawi_bishops_twitter');
                        $youtube_url = get_theme_mod('malawi_bishops_youtube');
                        
                        if ($facebook_url) : ?>
                            <a href="<?php echo esc_url($facebook_url); ?>" class="social-button facebook" target="_blank" aria-label="Facebook">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M22 12C22 6.48 17.52 2 12 2C6.48 2 2 6.48 2 12C2 16.84 5.44 20.87 10 21.8V15H8V12H10V9.5C10 7.57 11.57 6 13.5 6H16V9H14C13.45 9 13 9.45 13 10V12H16V15H13V21.95C18.05 21.45 22 17.19 22 12Z" />
                                </svg>
                            </a>
                        <?php endif; ?>
                        
                        <?php if ($twitter_url) : ?>
                            <a href="<?php echo esc_url($twitter_url); ?>" class="social-button twitter" target="_blank" aria-label="Twitter">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M22.46 6C21.69 6.35 20.86 6.58 20 6.69C20.88 6.16 21.56 5.32 21.88 4.31C21.05 4.81 20.13 5.16 19.16 5.36C18.37 4.5 17.26 4 16 4C13.65 4 11.73 5.92 11.73 8.29C11.73 8.63 11.77 8.96 11.84 9.27C8.28 9.09 5.11 7.38 3 4.79C2.63 5.42 2.42 6.16 2.42 6.94C2.42 8.43 3.17 9.75 4.33 10.5C3.62 10.5 2.96 10.3 2.38 10V10.03C2.38 12.11 3.86 13.85 5.82 14.24C5.19 14.41 4.53 14.42 3.89 14.28C4.16 15.1 4.7 15.82 5.41 16.34C6.13 16.86 7 17.15 7.89 17.15C6.37 18.34 4.49 19 2.56 18.99C2.22 18.99 1.88 18.97 1.54 18.93C3.44 20.16 5.7 20.84 8 20.84C16 20.84 20.33 14.25 20.33 8.58C20.33 8.39 20.33 8.2 20.32 8.01C21.16 7.41 21.88 6.66 22.46 5.8V6Z" />
                                </svg>
                            </a>
                        <?php endif; ?>
                        
                        <?php if ($youtube_url) : ?>
                            <a href="<?php echo esc_url($youtube_url); ?>" class="social-button youtube" target="_blank" aria-label="YouTube">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M10 15L15.19 12L10 9V15ZM21.56 7.17C21.69 7.64 21.78 8.27 21.84 9.07C21.91 9.87 21.94 10.56 21.94 11.16L22 12C22 14.19 21.84 15.8 21.56 16.83C21.31 17.73 20.73 18.31 19.83 18.56C19.36 18.69 18.5 18.78 17.18 18.84C15.88 18.91 14.69 18.94 13.59 18.94L12 19C7.81 19 5.2 18.84 4.17 18.56C3.27 18.31 2.69 17.73 2.44 16.83C2.31 16.36 2.22 15.73 2.16 14.93C2.09 14.13 2.06 13.44 2.06 12.84L2 12C2 9.81 2.16 8.2 2.44 7.17C2.69 6.27 3.27 5.69 4.17 5.44C4.64 5.31 5.5 5.22 6.82 5.16C8.12 5.09 9.31 5.06 10.41 5.06L12 5C16.19 5 18.8 5.16 19.83 5.44C20.73 5.69 21.31 6.27 21.56 7.17Z" />
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>
                    
                    <div class="newsletter-signup">
                        <h3><?php echo esc_html__('Subscribe to our Newsletter', 'malawi-bishops'); ?></h3>
                        <!-- You can replace this with your newsletter plugin shortcode -->
                        <form action="#" method="post" class="newsletter-form">
                            <div class="form-field">
                                <input type="email" name="email" placeholder="<?php echo esc_attr__('Your email address', 'malawi-bishops'); ?>" required>
                            </div>
                            <button type="submit" class="subscribe-button"><?php echo esc_html__('Subscribe', 'malawi-bishops'); ?></button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Right side - Facebook feed -->
            <div class="facebook-feed-right">
                <div class="facebook-feed-container">
                    <div class="facebook-feed-header">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M22 12C22 6.48 17.52 2 12 2C6.48 2 2 6.48 2 12C2 16.84 5.44 20.87 10 21.8V15H8V12H10V9.5C10 7.57 11.57 6 13.5 6H16V9H14C13.45 9 13 9.45 13 10V12H16V15H13V21.95C18.05 21.45 22 17.19 22 12Z" />
                        </svg>
                        <h3><?php echo esc_html__('Facebook Feed', 'malawi-bishops'); ?></h3>
                    </div>
                    
                    <div class="facebook-feed-content">
                        <?php 
                        // Output the Facebook shortcode
                        echo do_shortcode($facebook_shortcode); 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
