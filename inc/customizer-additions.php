<?php
/**
 * Additional Customizer Settings
 *
 * @package Malawi_Bishops
 */

/**
 * Add settings for configurable scrolling text
 */
function malawi_bishops_scrolling_text_customizer($wp_customize) {
    // Add section
    $wp_customize->add_section('malawi_bishops_scrolling_text', array(
        'title'    => __('Scrolling Text', 'malawi-bishops'),
        'priority' => 35,
    ));
    
    // Enable/disable scrolling text
    $wp_customize->add_setting('malawi_bishops_enable_scrolling_text', array(
        'default'           => false,
        'sanitize_callback' => 'malawi_bishops_sanitize_checkbox',
    ));
    
    $wp_customize->add_control('malawi_bishops_enable_scrolling_text', array(
        'label'       => __('Enable Scrolling Text', 'malawi-bishops'),
        'section'     => 'malawi_bishops_scrolling_text',
        'type'        => 'checkbox',
    ));
    
    // Scrolling text content
    $wp_customize->add_setting('malawi_bishops_scrolling_text', array(
        'default'           => __('Welcome to the Conference of Catholic Bishops in Malawi', 'malawi-bishops'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('malawi_bishops_scrolling_text', array(
        'label'       => __('Scrolling Text Content', 'malawi-bishops'),
        'description' => __('Enter the text to scroll in the header. Separate multiple items with a pipe symbol (|).', 'malawi-bishops'),
        'section'     => 'malawi_bishops_scrolling_text',
        'type'        => 'textarea',
    ));
    
    // Scrolling text speed
    $wp_customize->add_setting('malawi_bishops_scrolling_text_speed', array(
        'default'           => 'medium',
        'sanitize_callback' => 'malawi_bishops_sanitize_select',
    ));
    
    $wp_customize->add_control('malawi_bishops_scrolling_text_speed', array(
        'label'       => __('Scrolling Speed', 'malawi-bishops'),
        'section'     => 'malawi_bishops_scrolling_text',
        'type'        => 'select',
        'choices'     => array(
            'slow'   => __('Slow', 'malawi-bishops'),
            'medium' => __('Medium', 'malawi-bishops'),
            'fast'   => __('Fast', 'malawi-bishops'),
        ),
    ));
    
    // Scrolling text color
    $wp_customize->add_setting('malawi_bishops_scrolling_text_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'malawi_bishops_scrolling_text_color', array(
        'label'       => __('Text Color', 'malawi-bishops'),
        'section'     => 'malawi_bishops_scrolling_text',
    )));
    
    // Scrolling text background
    $wp_customize->add_setting('malawi_bishops_scrolling_text_bg', array(
        'default'           => 'rgba(255,255,255,0.2)',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('malawi_bishops_scrolling_text_bg', array(
        'label'       => __('Background Color (rgba format)', 'malawi-bishops'),
        'description' => __('e.g., rgba(255,255,255,0.2) for semi-transparent white', 'malawi-bishops'),
        'section'     => 'malawi_bishops_scrolling_text',
        'type'        => 'text',
    ));
}
add_action('customize_register', 'malawi_bishops_scrolling_text_customizer');

/**
 * Sanitize checkbox values
 */
function malawi_bishops_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

/**
 * Sanitize select values
 */
function malawi_bishops_sanitize_select($input, $setting) {
    $input = sanitize_key($input);
    $choices = $setting->manager->get_control($setting->id)->choices;
    return (array_key_exists($input, $choices) ? $input : $setting->default);
}
