<?php
/**
 * Additional Customizer Settings for the Theme
 */

// Prevent direct script access
if (!defined('ABSPATH')) {
    exit;
}

// Color manipulation utilities
if (!function_exists('darken_color')) {
    /**
     * Darken a hex color by a percentage
     * 
     * @param string $color Hex color code
     * @param float $percent Percentage to darken
     * @return string Darkened hex color code
     */
    function darken_color($color, $percent) {
        $color = ltrim($color, '#');
        $rgb = array_map('hexdec', str_split($color, 2));
        
        foreach ($rgb as &$c) {
            $c = max(0, min(255, $c - round($c * ($percent/100))));
        }
        
        return '#' . implode('', array_map(function($c) {
            return str_pad(dechex($c), 2, '0', STR_PAD_LEFT);
        }, $rgb));
    }
}

// Customize additional theme options
if (!function_exists('malawi_bishops_additional_customize_register')) {
    /**
     * Register additional customizer settings
     * 
     * @param WP_Customize_Manager $wp_customize WordPress customizer object
     */
    function malawi_bishops_additional_customize_register($wp_customize) {
        // Theme Color Section
        $wp_customize->add_section('malawi_bishops_additional_theme_colors', array(
            'title' => __('Additional Theme Colors', 'malawi-bishops'),
            'priority' => 31,
        ));

        // Additional Color Settings
        $color_settings = array(
            'secondary_color' => array(
                'default' => '#6a5acd',
                'label' => __('Secondary Color', 'malawi-bishops'),
            ),
            'accent_color' => array(
                'default' => '#d4af37',
                'label' => __('Accent Color', 'malawi-bishops'),
            )
        );

        foreach ($color_settings as $setting_key => $setting_data) {
            // Add setting
            $wp_customize->add_setting(
                "malawi_bishops_{$setting_key}", 
                array(
                    'default' => $setting_data['default'],
                    'sanitize_callback' => 'sanitize_hex_color',
                )
            );

            // Add color control
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize, 
                    "malawi_bishops_{$setting_key}", 
                    array(
                        'label' => $setting_data['label'],
                        'section' => 'malawi_bishops_additional_theme_colors',
                    )
                )
            );
        }

        // Footer Section
        $wp_customize->add_section('malawi_bishops_footer_options', array(
            'title' => __('Footer Options', 'malawi-bishops'),
            'priority' => 60,
        ));

        // Footer text setting
        $wp_customize->add_setting(
            'malawi_bishops_footer_copyright', 
            array(
                'default' => '© ' . date('Y') . ' ' . get_bloginfo('name') . '. ' . __('All Rights Reserved.', 'malawi-bishops'),
                'sanitize_callback' => 'wp_kses_post',
            )
        );

        $wp_customize->add_control(
            'malawi_bishops_footer_copyright', 
            array(
                'label' => __('Footer Copyright Text', 'malawi-bishops'),
                'section' => 'malawi_bishops_footer_options',
                'type' => 'textarea',
            )
        );
    }
}
add_action('customize_register', 'malawi_bishops_additional_customize_register');

// Scrolling Text Customizer Options
if (!function_exists('malawi_bishops_scrolling_text_customizer')) {
    /**
     * Add scrolling text customizer options
     * 
     * @param WP_Customize_Manager $wp_customize WordPress customizer object
     */
    function malawi_bishops_scrolling_text_customizer($wp_customize) {
        // Scrolling Text Section
        $wp_customize->add_section(
            'malawi_bishops_scrolling_text', 
            array(
                'title'    => __('Scrolling Text', 'malawi-bishops'),
                'priority' => 35,
            )
        );
        
        // Enable/disable scrolling text
        $wp_customize->add_setting(
            'malawi_bishops_enable_scrolling_text', 
            array(
                'default'           => false,
                'sanitize_callback' => 'malawi_bishops_sanitize_checkbox',
            )
        );
        
        $wp_customize->add_control(
            'malawi_bishops_enable_scrolling_text', 
            array(
                'label'       => __('Enable Scrolling Text', 'malawi-bishops'),
                'section'     => 'malawi_bishops_scrolling_text',
                'type'        => 'checkbox',
            )
        );
        
        // Scrolling text content
        $wp_customize->add_setting(
            'malawi_bishops_scrolling_text', 
            array(
                'default'           => __('Welcome to the Conference of Catholic Bishops in Malawi', 'malawi-bishops'),
                'sanitize_callback' => 'sanitize_text_field',
            )
        );
        
        $wp_customize->add_control(
            'malawi_bishops_scrolling_text', 
            array(
                'label'       => __('Scrolling Text Content', 'malawi-bishops'),
                'description' => __('Enter the text to scroll in the header. Separate multiple items with a pipe symbol (|).', 'malawi-bishops'),
                'section'     => 'malawi_bishops_scrolling_text',
                'type'        => 'textarea',
            )
        );
        
        // Scrolling text speed
        $wp_customize->add_setting(
            'malawi_bishops_scrolling_text_speed', 
            array(
                'default'           => 'medium',
                'sanitize_callback' => 'malawi_bishops_sanitize_select',
            )
        );
        
        $wp_customize->add_control(
            'malawi_bishops_scrolling_text_speed', 
            array(
                'label'       => __('Scrolling Speed', 'malawi-bishops'),
                'section'     => 'malawi_bishops_scrolling_text',
                'type'        => 'select',
                'choices'     => array(
                    'slow'   => __('Slow', 'malawi-bishops'),
                    'medium' => __('Medium', 'malawi-bishops'),
                    'fast'   => __('Fast', 'malawi-bishops'),
                ),
            )
        );
        
        // Scrolling text color
        $wp_customize->add_setting(
            'malawi_bishops_scrolling_text_color', 
            array(
                'default'           => '#ffffff',
                'sanitize_callback' => 'sanitize_hex_color',
            )
        );
        
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'malawi_bishops_scrolling_text_color', 
                array(
                    'label'    => __('Text Color', 'malawi-bishops'),
                    'section'  => 'malawi_bishops_scrolling_text',
                )
            )
        );
        
        // Scrolling text background
        $wp_customize->add_setting(
            'malawi_bishops_scrolling_text_bg', 
            array(
                'default'           => 'rgba(255,255,255,0.2)',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );
        
        $wp_customize->add_control(
            'malawi_bishops_scrolling_text_bg', 
            array(
                'label'       => __('Background Color (rgba format)', 'malawi-bishops'),
                'description' => __('e.g., rgba(255,255,255,0.2) for semi-transparent white', 'malawi-bishops'),
                'section'     => 'malawi_bishops_scrolling_text',
                'type'        => 'text',
            )
        );
    }
}
add_action('customize_register', 'malawi_bishops_scrolling_text_customizer');

// Customize CSS output
if (!function_exists('malawi_bishops_additional_customize_css')) {
    /**
     * Output additional custom CSS based on theme settings
     */
    function malawi_bishops_additional_customize_css() {
        // Secondary and Accent Colors
        $secondary_color = get_theme_mod('malawi_bishops_secondary_color', '#6a5acd');
        $accent_color = get_theme_mod('malawi_bishops_accent_color', '#d4af37');
        
        ?>
        <style type="text/css">
            :root {
                --secondary-color: <?php echo esc_attr($secondary_color); ?>;
                --accent-color: <?php echo esc_attr($accent_color); ?>;
            }

            /* Additional color styling */
            .secondary-text {
                color: var(--secondary-color);
            }

            .accent-background {
                background-color: var(--accent-color);
            }
        </style>
        <?php
    }
}
add_action('wp_head', 'malawi_bishops_additional_customize_css');
