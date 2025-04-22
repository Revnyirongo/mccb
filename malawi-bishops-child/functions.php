<?php
/**
 * Malawi Bishops Child Theme functions
 */

// Enqueue parent and child theme styles properly
function malawi_bishops_child_enqueue_styles() {
    // Enqueue parent style
    wp_enqueue_style(
        'parent-style',
        get_template_directory_uri() . '/style.css'
    );
    
    // Enqueue child style
    wp_enqueue_style(
        'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style'),
        wp_get_theme()->get('Version')
    );
    
    // Enqueue mobile-specific styles
    wp_enqueue_style(
        'mobile-core-fixes',
        get_stylesheet_directory_uri() . '/assets/css/mobile-core-fixes.css',
        array('child-style'),
        '1.0.0'
    );
    
    wp_enqueue_style(
        'mobile-header-menu',
        get_stylesheet_directory_uri() . '/assets/css/mobile-header-menu.css',
        array('mobile-core-fixes'),
        '1.0.0'
    );
    
    wp_enqueue_style(
        'mobile-hero-slider',
        get_stylesheet_directory_uri() . '/assets/css/mobile-hero-slider.css',
        array('mobile-core-fixes'),
        '1.0.0'
    );
    
    wp_enqueue_style(
        'mobile-bishops-grid',
        get_stylesheet_directory_uri() . '/assets/css/mobile-bishops-grid.css',
        array('mobile-core-fixes'),
        '1.0.0'
    );
    
    wp_enqueue_style(
        'mobile-about-section',
        get_stylesheet_directory_uri() . '/assets/css/mobile-about-section.css',
        array('mobile-core-fixes'),
        '1.0.0'
    );
    
    // Enqueue mobile menu JS
    wp_enqueue_script(
        'mobile-menu',
        get_stylesheet_directory_uri() . '/assets/js/mobile-menu.js',
        array('jquery'),
        '1.0.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'malawi_bishops_child_enqueue_styles');

// Add any additional functions below
