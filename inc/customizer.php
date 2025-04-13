<?php
/**
 * Additional Customizer Settings for the Theme
 */
if (!function_exists('darken_color')) {
    function darken_color($color, $percent) {
        $color = ltrim($color, '#');
        $rgb = array_map('hexdec', str_split($color, 2));
        
        foreach ($rgb as &$c) {
            $c = max(0, min(255, $c - round($c * ($percent/100)))); // Fixed syntax error
        }
        
        return '#' . implode('', array_map(function($c) {
            return str_pad(dechex($c), 2, '0', STR_PAD_LEFT);
        }, $rgb));
    }
} 

function mytheme_additions_customize_register($wp_customize) {
    // Add a section for theme color
    $wp_customize->add_section('mytheme_additions_theme_colors', array(
        'title' => __('Theme Colors', 'mytheme'),
        'priority' => 30,
    ));

    // Add setting for primary color
    $wp_customize->add_setting('mytheme_additions_primary_color', array(
        'default' => '#0073aa',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    // Control for primary color
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mytheme_additions_primary_color', array(
        'label' => __('Primary Theme Color', 'mytheme'),
        'section' => 'mytheme_additions_theme_colors',
        'settings' => 'mytheme_additions_primary_color',
    )));

    // Add section for footer settings
    $wp_customize->add_section('mytheme_additions_footer_section', array(
        'title' => __('Footer Settings', 'mytheme'),
        'priority' => 35,
    ));

    // Add setting for footer text
    $wp_customize->add_setting('mytheme_additions_footer_text', array(
        'default' => '© ' . date('Y') . ' My Website. All rights reserved.',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    // Control for footer text
    $wp_customize->add_control('mytheme_additions_footer_text', array(
        'label' => __('Footer Text', 'mytheme'),
        'section' => 'mytheme_additions_footer_section',
        'type' => 'text',
    ));
}
add_action('customize_register', 'mytheme_additions_customize_register');

/**
 * Output the custom CSS to the head based on settings
 */
function mytheme_additions_customize_css() {
    $primary_color = get_theme_mod('mytheme_additions_primary_color', '#0073aa');
    ?>
    <style type="text/css">
        :root {
            --primary-color: <?php echo esc_attr($primary_color); ?>;
        }

        a,
        .menu a:hover,
        .button,
        .site-title a:hover {
            color: var(--primary-color);
        }

        .button,
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: <?php echo esc_attr(darken_color($primary_color, 20)); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'mytheme_additions_customize_css');

/**
 * Utility function to darken a hex color
 */
function mytheme_additions_darken_color($hex, $percent) {
    $hex = str_replace('#', '', $hex);
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    $r = max(0, min(255, $r - ($r * $percent / 100)));
    $g = max(0, min(255, $g - ($g * $percent / 100)));
    $b = max(0, min(255, $b - ($b * $percent / 100)));

    return sprintf("#%02x%02x%02x", $r, $g, $b);
}

/**
 * Scrolling Text Customizer Options
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
add_action('customize_register', 'malawi_bishops_scrolling_text_customizer');
