<?php
/**
 * Malawi Bishops Theme Functions and Definitions
 *
 * @package Malawi_Bishops
 */

// Prevent direct script access
if (!defined('ABSPATH')) {
    exit;
}

// Define theme version
if (!defined('MALAWI_BISHOPS_VERSION')) {
    define('MALAWI_BISHOPS_VERSION', '1.2.0');
}

/**
 * Debugging and Logging Utility
 * 
 * @param mixed $message Message to log
 * @param string $type Log type
 */
if (!function_exists('malawi_bishops_debug_log')) {
    function malawi_bishops_debug_log($message, $type = 'notice') {
        if (defined('WP_DEBUG') && WP_DEBUG === true) {
            $log_message = '[' . strtoupper($type) . '] ';
            
            if (is_array($message) || is_object($message)) {
                $log_message .= print_r($message, true);
            } else {
                $log_message .= $message;
            }
            
            error_log('[Malawi Bishops Theme] ' . $log_message);
        }
    }
}

/**
 * Safely include theme files
 * 
 * @param string $file_path Relative path to the file
 * @return bool Whether the file was successfully included
 */
if (!function_exists('malawi_bishops_include_file')) {
    function malawi_bishops_include_file($file_path) {
        $full_path = get_template_directory() . $file_path;
        
        if (file_exists($full_path)) {
            require_once $full_path;
            return true;
        } else {
            malawi_bishops_debug_log("Missing include file: $full_path", 'error');
            return false;
        }
    }
}

/**
 * Theme Setup
 */
if (!function_exists('malawi_bishops_setup')) {
    function malawi_bishops_setup() {
        // Add default posts and comments RSS feed links to head
        add_theme_support('automatic-feed-links');

        // Let WordPress manage the document title
        add_theme_support('title-tag');

        // Enable support for Post Thumbnails on posts and pages
        add_theme_support('post-thumbnails');

        // Custom logo support
        add_theme_support(
            'custom-logo',
            array(
                'height'      => 100,
                'width'       => 100,
                'flex-width'  => true,
                'flex-height' => true,
            )
        );

        // Register navigation menus
        register_nav_menus(
            array(
                'main-menu'   => esc_html__('Main Menu', 'malawi-bishops'),
                'footer-menu' => esc_html__('Footer Menu', 'malawi-bishops'),
            )
        );

        // Switch default core markup to output valid HTML5
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
            )
        );

        // Add theme support for selective refresh for widgets
        add_theme_support('customize-selective-refresh-widgets');

        // Add excerpt support for pages
        add_post_type_support('page', 'excerpt');
    }
}
add_action('after_setup_theme', 'malawi_bishops_setup');

/**
 * Sanitization Utilities
 */
if (!function_exists('malawi_bishops_sanitize_checkbox')) {
    function malawi_bishops_sanitize_checkbox($checked) {
        return ((isset($checked) && true == $checked) ? true : false);
    }
}

if (!function_exists('malawi_bishops_sanitize_select')) {
    function malawi_bishops_sanitize_select($input, $setting) {
        $input = sanitize_key($input);
        $choices = $setting->manager->get_control($setting->id)->choices;
        return (array_key_exists($input, $choices) ? $input : $setting->default);
    }
}

/**
 * Color Manipulation Utility
 */
if (!function_exists('malawi_bishops_darken_color')) {
    function malawi_bishops_darken_color($hex, $percent) {
        $hex = str_replace('#', '', $hex);
        
        $rgb = array_map('hexdec', str_split($hex, 2));
        
        foreach ($rgb as &$c) {
            $c = max(0, min(255, $c - round($c * ($percent/100))));
        }
        
        return '#' . implode('', array_map(function($c) {
            return str_pad(dechex($c), 2, '0', STR_PAD_LEFT);
        }, $rgb));
    }
}

/**
 * Translation and Localization Support
 */
add_action('init', function() {
    do_action('load_textdomain');
});

/**
 * Early Translation Loading Prevention
 */
add_action('plugins_loaded', function() {
    // Remove any early loading actions for specific text domains
    remove_all_actions('load_textdomain');
});

/**
 * Include Theme Files
 */
$theme_includes = [
    '/inc/template-functions.php',
    '/inc/customizer.php',
    '/inc/customizer-additions.php',
    '/inc/template-functions-extended.php',
    '/inc/template-tags.php',
    '/inc/widgets.php',
    '/malawi-bishops-debug.php'
];

foreach ($theme_includes as $file) {
    malawi_bishops_include_file($file);
}

/**
 * Register Widget Areas
 */
if (!function_exists('malawi_bishops_widgets_init')) {
    function malawi_bishops_widgets_init() {
        // Main sidebar
        register_sidebar(
            array(
                'name'          => esc_html__('Sidebar', 'malawi-bishops'),
                'id'            => 'sidebar-1',
                'description'   => esc_html__('Add widgets here.', 'malawi-bishops'),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h2 class="widget-title">',
                'after_title'   => '</h2>',
            )
        );

        // Footer widget areas
        $footer_widget_areas = 4;
        for ($i = 1; $i <= $footer_widget_areas; $i++) {
            register_sidebar(
                array(
                    'name'          => sprintf(esc_html__('Footer %d', 'malawi-bishops'), $i),
                    'id'            => 'footer-' . $i,
                    'description'   => esc_html__('Add footer widgets here.', 'malawi-bishops'),
                    'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<h4 class="footer-widget-title">',
                    'after_title'   => '</h4>',
                )
            );
        }
    }
}
add_action('widgets_init', 'malawi_bishops_widgets_init');

/**
 * Enqueue Scripts and Styles
 */
if (!function_exists('malawi_bishops_scripts')) {
    function malawi_bishops_scripts() {
        // Enqueue main stylesheet
        wp_enqueue_style('malawi-bishops-style', get_stylesheet_uri(), array(), MALAWI_BISHOPS_VERSION);
        
        // Dynamically enqueue module stylesheets
        $css_modules = [
            'hero-slider',
            'scroll-progress',
            'bishops-grid',
            'single-page',
            'mobile-optimizations',
            'responsive',
            'scrolling-text'
        ];
        
        foreach ($css_modules as $module) {
            $file_path = "/assets/css/{$module}.css";
            if (file_exists(get_template_directory() . $file_path)) {
                wp_enqueue_style("malawi-bishops-{$module}", get_template_directory_uri() . $file_path, array(), MALAWI_BISHOPS_VERSION);
            }
        }
        
        // Enqueue dashicons
        wp_enqueue_style('dashicons');
        
        // Enqueue jQuery
        wp_enqueue_script('jquery');
        
        // Dynamically enqueue module scripts
        $js_modules = [
            'navigation',
            'hero-slider', 
            'scroll-progress', 
            'header'
        ];
        
        foreach ($js_modules as $module) {
            $file_path = "/assets/js/{$module}.js";
            if (file_exists(get_template_directory() . $file_path)) {
                wp_enqueue_script(
                    "malawi-bishops-{$module}", 
                    get_template_directory_uri() . $file_path, 
                    $module === 'hero-slider' ? array('jquery') : array(), 
                    MALAWI_BISHOPS_VERSION, 
                    true
                );
            }
        }
        
        // Enqueue comment reply script
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }
}
add_action('wp_enqueue_scripts', 'malawi_bishops_scripts');

/**
 * Add critical inline styles
 */
if (!function_exists('malawi_bishops_add_critical_styles')) {
    function malawi_bishops_add_critical_styles() {
        $critical_css = "
            .scroll-progress-tracker {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                width: 100% !important;
                height: 3px !important;
                background-color: rgba(0, 0, 0, 0.2) !important;
                z-index: 9999 !important;
                pointer-events: none !important;
                display: block !important;
            }
            
            .progress-indicator {
                height: 100% !important;
                width: 0 !important;
                background-color: #d4af37 !important;
                transition: width 0.1s ease !important;
                display: block !important;
            }
            
            .contact-info a {
                color: white !important;
                opacity: 1 !important;
                text-shadow: 0 1px 2px rgba(0,0,0,0.3) !important;
            }
        ";
        
        wp_add_inline_style('malawi-bishops-style', $critical_css);
    }
}
add_action('wp_enqueue_scripts', 'malawi_bishops_add_critical_styles', 999);

/**
 * Enqueue additional CSS files for new components
 */
if (!function_exists('malawi_bishops_enqueue_additional_styles')) {
    function malawi_bishops_enqueue_additional_styles() {
        // Enqueue component-specific CSS files
        $css_modules = [
            'bishops-grid',
            'about-section',
            'facebook-feed',
            'events-cta',
            'footer'
        ];
        
        foreach ($css_modules as $module) {
            $file_path = "/assets/css/{$module}.css";
            if (file_exists(get_template_directory() . $file_path)) {
                wp_enqueue_style(
                    "malawi-bishops-{$module}-component",
                    get_template_directory_uri() . $file_path,
                    array(),
                    MALAWI_BISHOPS_VERSION
                );
            }
        }
        
        // Enqueue custom JS
        $custom_js_path = '/assets/js/custom.js';
        if (file_exists(get_template_directory() . $custom_js_path)) {
            wp_enqueue_script(
                'malawi-bishops-custom',
                get_template_directory_uri() . $custom_js_path,
                array('jquery'),
                MALAWI_BISHOPS_VERSION,
                true
            );
        }
    }
}
add_action('wp_enqueue_scripts', 'malawi_bishops_enqueue_additional_styles');

/**
 * Add customizer settings for the footer
 */
if (!function_exists('malawi_bishops_footer_customizer')) {
    function malawi_bishops_footer_customizer($wp_customize) {
        // Footer Section
        $wp_customize->add_section('malawi_bishops_footer_section', array(
            'title'    => __('Footer Options', 'malawi-bishops'),
            'priority' => 120,
        ));
        
        // Footer About Text
        $wp_customize->add_setting('malawi_bishops_footer_about', array(
            'default'           => __('The Episcopal Conference of Malawi is an assembly of Catholic Bishops bringing unity, development, justice, peace, and solidarity to Malawi.', 'malawi-bishops'),
            'sanitize_callback' => 'wp_kses_post',
        ));
        
        $wp_customize->add_control('malawi_bishops_footer_about', array(
            'label'       => __('Footer About Text', 'malawi-bishops'),
            'section'     => 'malawi_bishops_footer_section',
            'type'        => 'textarea',
        ));
        
        // Contact Information
        $wp_customize->add_setting('malawi_bishops_address', array(
            'default'           => __('ECM Secretariat, Area 11, Plot #: M1170, Paul VI Road, P.O. Box 30384, Lilongwe, Malawi', 'malawi-bishops'),
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control('malawi_bishops_address', array(
            'label'       => __('Address', 'malawi-bishops'),
            'section'     => 'malawi_bishops_footer_section',
            'type'        => 'text',
        ));
        
        $wp_customize->add_setting('malawi_bishops_phone', array(
            'default'           => __('+265 1 772 066', 'malawi-bishops'),
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control('malawi_bishops_phone', array(
            'label'       => __('Phone Number', 'malawi-bishops'),
            'section'     => 'malawi_bishops_footer_section',
            'type'        => 'text',
        ));
        
        $wp_customize->add_setting('malawi_bishops_email', array(
            'default'           => __('info@mccbmw.org', 'malawi-bishops'),
            'sanitize_callback' => 'sanitize_email',
        ));
        
        $wp_customize->add_control('malawi_bishops_email', array(
            'label'       => __('Email Address', 'malawi-bishops'),
            'section'     => 'malawi_bishops_footer_section',
            'type'        => 'email',
        ));
        
        // Social Media
        $wp_customize->add_setting('malawi_bishops_facebook', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        
        $wp_customize->add_control('malawi_bishops_facebook', array(
            'label'       => __('Facebook URL', 'malawi-bishops'),
            'section'     => 'malawi_bishops_footer_section',
            'type'        => 'url',
        ));
        
        $wp_customize->add_setting('malawi_bishops_twitter', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        
        $wp_customize->add_control('malawi_bishops_twitter', array(
            'label'       => __('Twitter URL', 'malawi-bishops'),
            'section'     => 'malawi_bishops_footer_section',
            'type'        => 'url',
        ));
        
        $wp_customize->add_setting('malawi_bishops_youtube', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        
        $wp_customize->add_control('malawi_bishops_youtube', array(
            'label'       => __('YouTube URL', 'malawi-bishops'),
            'section'     => 'malawi_bishops_footer_section',
            'type'        => 'url',
        ));
        
        $wp_customize->add_setting('malawi_bishops_instagram', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        
        $wp_customize->add_control('malawi_bishops_instagram', array(
            'label'       => __('Instagram URL', 'malawi-bishops'),
            'section'     => 'malawi_bishops_footer_section',
            'type'        => 'url',
        ));
        
        // Copyright text
        $wp_customize->add_setting('malawi_bishops_copyright_text', array(
            'default'           => '&copy; ' . date('Y') . ' ' . get_bloginfo('name') . '. ' . __('All Rights Reserved.', 'malawi-bishops'),
            'sanitize_callback' => 'wp_kses_post',
        ));
        
        $wp_customize->add_control('malawi_bishops_copyright_text', array(
            'label'       => __('Copyright Text', 'malawi-bishops'),
            'section'     => 'malawi_bishops_footer_section',
            'type'        => 'textarea',
        ));
    }
}
add_action('customize_register', 'malawi_bishops_footer_customizer');

/**
 * Add customizer settings for Facebook Feed
 */
if (!function_exists('malawi_bishops_facebook_feed_customizer')) {
    function malawi_bishops_facebook_feed_customizer($wp_customize) {
        // Facebook Feed Section
        $wp_customize->add_section('malawi_bishops_facebook_feed', array(
            'title'    => __('Facebook Feed', 'malawi-bishops'),
            'priority' => 115,
        ));
        
        // Facebook Page URL
        $wp_customize->add_setting('malawi_bishops_facebook_page', array(
            'default'           => 'https://www.facebook.com/MalawiCatholicBishops',
            'sanitize_callback' => 'esc_url_raw',
        ));
        
        $wp_customize->add_control('malawi_bishops_facebook_page', array(
            'label'       => __('Facebook Page URL', 'malawi-bishops'),
            'section'     => 'malawi_bishops_facebook_feed',
            'type'        => 'url',
        ));
        
        // Facebook Shortcode
        $wp_customize->add_setting('malawi_bishops_facebook_shortcode', array(
            'default'           => '[facebook_page_plugin href="https://www.facebook.com/MalawiCatholicBishops" width="500" height="500" tabs="timeline"]',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control('malawi_bishops_facebook_shortcode', array(
            'label'       => __('Facebook Shortcode', 'malawi-bishops'),
            'description' => __('Enter the shortcode for your Facebook page plugin. You can get this from the Facebook Developer tools or a plugin like "Custom Facebook Feed".', 'malawi-bishops'),
            'section'     => 'malawi_bishops_facebook_feed',
            'type'        => 'text',
        ));
    }
}
add_action('customize_register', 'malawi_bishops_facebook_feed_customizer');

// Final action to log theme activation
add_action('after_switch_theme', function() {
    malawi_bishops_debug_log('Theme activated: Malawi Bishops Theme version ' . MALAWI_BISHOPS_VERSION, 'activation');
});

/**
 * NOTE: The malawi_bishops_hero_slider() function has been moved to 
 * inc/template-functions-extended.php to avoid duplication. This function should 
 * NOT be defined here to prevent "Cannot redeclare" errors.
 */
