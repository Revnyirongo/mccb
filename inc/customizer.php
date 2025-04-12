<?php
/**
 * Malawi Bishops Theme Customizer
 *
 * @package Malawi_Bishops
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function malawi_bishops_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'malawi_bishops_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'malawi_bishops_customize_partial_blogdescription',
			)
		);
	}

	// Contact & Social Media Section
	$wp_customize->add_section(
		'malawi_bishops_contact_social',
		array(
			'title'    => __( 'Contact & Social Media', 'malawi-bishops' ),
			'priority' => 30,
		)
	);

	// Email
	$wp_customize->add_setting(
		'malawi_bishops_email',
		array(
			'default'           => 'info@malawibishops.org',
			'sanitize_callback' => 'sanitize_email',
		)
	);

	$wp_customize->add_control(
		'malawi_bishops_email',
		array(
			'label'   => __( 'Email Address', 'malawi-bishops' ),
			'section' => 'malawi_bishops_contact_social',
			'type'    => 'email',
		)
	);

	// Social Media
	$wp_customize->add_setting(
		'malawi_bishops_facebook',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		'malawi_bishops_facebook',
		array(
			'label'   => __( 'Facebook URL', 'malawi-bishops' ),
			'section' => 'malawi_bishops_contact_social',
			'type'    => 'url',
		)
	);

	$wp_customize->add_setting(
		'malawi_bishops_twitter',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		'malawi_bishops_twitter',
		array(
			'label'   => __( 'Twitter URL', 'malawi-bishops' ),
			'section' => 'malawi_bishops_contact_social',
			'type'    => 'url',
		)
	);

	$wp_customize->add_setting(
		'malawi_bishops_youtube',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		'malawi_bishops_youtube',
		array(
			'label'   => __( 'YouTube URL', 'malawi-bishops' ),
			'section' => 'malawi_bishops_contact_social',
			'type'    => 'url',
		)
	);

	// Hero Section
	$wp_customize->add_section(
		'malawi_bishops_hero',
		array(
			'title'    => __( 'Homepage Hero', 'malawi-bishops' ),
			'priority' => 40,
		)
	);

	$wp_customize->add_setting(
		'malawi_bishops_hero_title',
		array(
			'default'           => __( 'Serving the Church in Malawi', 'malawi-bishops' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'malawi_bishops_hero_title',
		array(
			'label'   => __( 'Hero Title', 'malawi-bishops' ),
			'section' => 'malawi_bishops_hero',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'malawi_bishops_hero_text',
		array(
			'default'           => __( 'Proclaiming the Gospel, promoting human dignity, and building a civilization of love', 'malawi-bishops' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'malawi_bishops_hero_text',
		array(
			'label'   => __( 'Hero Text', 'malawi-bishops' ),
			'section' => 'malawi_bishops_hero',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'malawi_bishops_hero_button_text',
		array(
			'default'           => __( 'Learn More', 'malawi-bishops' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'malawi_bishops_hero_button_text',
		array(
			'label'   => __( 'Button Text', 'malawi-bishops' ),
			'section' => 'malawi_bishops_hero',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'malawi_bishops_hero_button_url',
		array(
			'default'           => '#',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		'malawi_bishops_hero_button_url',
		array(
			'label'   => __( 'Button URL', 'malawi-bishops' ),
			'section' => 'malawi_bishops_hero',
			'type'    => 'url',
		)
	);

	$wp_customize->add_setting(
		'malawi_bishops_hero_image',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'malawi_bishops_hero_image',
			array(
				'label'   => __( 'Hero Background Image', 'malawi-bishops' ),
				'section' => 'malawi_bishops_hero',
			)
		)
	);

	// Homepage Sections
	$wp_customize->add_section(
		'malawi_bishops_homepage',
		array(
			'title'    => __( 'Homepage Sections', 'malawi-bishops' ),
			'priority' => 50,
		)
	);

	// Features Section (Our Mission)
	$wp_customize->add_setting(
		'malawi_bishops_show_features',
		array(
			'default'           => true,
			'sanitize_callback' => 'malawi_bishops_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'malawi_bishops_show_features',
		array(
			'label'   => __( 'Show Features Section', 'malawi-bishops' ),
			'section' => 'malawi_bishops_homepage',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'malawi_bishops_features_title',
		array(
			'default'           => __( 'Our Mission', 'malawi-bishops' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'malawi_bishops_features_title',
		array(
			'label'   => __( 'Features Section Title', 'malawi-bishops' ),
			'section' => 'malawi_bishops_homepage',
			'type'    => 'text',
		)
	);

	// Feature 1
	$wp_customize->add_setting(
		'malawi_bishops_feature1_title',
		array(
			'default'           => __( 'Evangelization', 'malawi-bishops' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'malawi_bishops_feature1_title',
		array(
			'label'   => __( 'Feature 1 Title', 'malawi-bishops' ),
			'section' => 'malawi_bishops_homepage',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'malawi_bishops_feature1_text',
		array(
			'default'           => __( 'Proclaiming the Good News of salvation in Jesus Christ to all people in Malawi and fostering spiritual growth among the faithful.', 'malawi-bishops' ),
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);

	$wp_customize->add_control(
		'malawi_bishops_feature1_text',
		array(
			'label'   => __( 'Feature 1 Text', 'malawi-bishops' ),
			'section' => 'malawi_bishops_homepage',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'malawi_bishops_feature1_image',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'malawi_bishops_feature1_image',
			array(
				'label'   => __( 'Feature 1 Image', 'malawi-bishops' ),
				'section' => 'malawi_bishops_homepage',
			)
		)
	);

	// Feature 2
	$wp_customize->add_setting(
		'malawi_bishops_feature2_title',
		array(
			'default'           => __( 'Justice and Peace', 'malawi-bishops' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'malawi_bishops_feature2_title',
		array(
			'label'   => __( 'Feature 2 Title', 'malawi-bishops' ),
			'section' => 'malawi_bishops_homepage',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'malawi_bishops_feature2_text',
		array(
			'default'           => __( 'Promoting human dignity, advocating for social justice, and working towards peace and reconciliation in our society.', 'malawi-bishops' ),
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);

	$wp_customize->add_control(
		'malawi_bishops_feature2_text',
		array(
			'label'   => __( 'Feature 2 Text', 'malawi-bishops' ),
			'section' => 'malawi_bishops_homepage',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'malawi_bishops_feature2_image',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'malawi_bishops_feature2_image',
			array(
				'label'   => __( 'Feature 2 Image', 'malawi-bishops' ),
				'section' => 'malawi_bishops_homepage',
			)
		)
	);

	// Feature 3
	$wp_customize->add_setting(
		'malawi_bishops_feature3_title',
		array(
			'default'           => __( 'Education', 'malawi-bishops' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'malawi_bishops_feature3_title',
		array(
			'label'   => __( 'Feature 3 Title', 'malawi-bishops' ),
			'section' => 'malawi_bishops_homepage',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'malawi_bishops_feature3_text',
		array(
			'default'           => __( 'Supporting Catholic education and formation at all levels to nurture faith, intellect, and character in future generations.', 'malawi-bishops' ),
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);

	$wp_customize->add_control(
		'malawi_bishops_feature3_text',
		array(
			'label'   => __( 'Feature 3 Text', 'malawi-bishops' ),
			'section' => 'malawi_bishops_homepage',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'malawi_bishops_feature3_image',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'malawi_bishops_feature3_image',
			array(
				'label'   => __( 'Feature 3 Image', 'malawi-bishops' ),
				'section' => 'malawi_bishops_homepage',
			)
		)
	);

	// News Section
	$wp_customize->add_setting(
		'malawi_bishops_show_news',
		array(
			'default'           => true,
			'sanitize_callback' => 'malawi_bishops_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'malawi_bishops_show_news',
		array(
			'label'   => __( 'Show News Section', 'malawi-bishops' ),
			'section' => 'malawi_bishops_homepage',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'malawi_bishops_news_title',
		array(
			'default'           => __( 'Latest News', 'malawi-bishops' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'malawi_bishops_news_title',
		array(
			'label'   => __( 'News Section Title', 'malawi-bishops' ),
			'section' => 'malawi_bishops_homepage',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'malawi_bishops_news_count',
		array(
			'default'           => 3,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'malawi_bishops_news_count',
		array(
			'label'   => __( 'Number of News Posts to Display', 'malawi-bishops' ),
			'section' => 'malawi_bishops_homepage',
			'type'    => 'number',
		)
	);

	// Bishops Section
	$wp_customize->add_setting(
		'malawi_bishops_show_bishops',
		array(
			'default'           => true,
			'sanitize_callback' => 'malawi_bishops_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'malawi_bishops_show_bishops',
		array(
			'label'   => __( 'Show Bishops Section', 'malawi-bishops' ),
			'section' => 'malawi_bishops_homepage',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'malawi_bishops_bishops_title',
		array(
			'default'           => __( 'Our Bishops', 'malawi-bishops' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'malawi_bishops_bishops_title',
		array(
			'label'   => __( 'Bishops Section Title', 'malawi-bishops' ),
			'section' => 'malawi_bishops_homepage',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'malawi_bishops_bishops_count',
		array(
			'default'           => 8,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'malawi_bishops_bishops_count',
		array(
			'label'   => __( 'Number of Bishops to Display', 'malawi-bishops' ),
			'section' => 'malawi_bishops_homepage',
			'type'    => 'number',
		)
	);

	// Events Section
	$wp_customize->add_setting(
		'malawi_bishops_show_events',
		array(
			'default'           => true,
			'sanitize_callback' => 'malawi_bishops_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'malawi_bishops_show_events',
		array(
			'label'   => __( 'Show Events Section', 'malawi-bishops' ),
			'section' => 'malawi_bishops_homepage',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'malawi_bishops_events_title',
		array(
			'default'           => __( 'Upcoming Events', 'malawi-bishops' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'malawi_bishops_events_title',
		array(
			'label'   => __( 'Events Section Title', 'malawi-bishops' ),
			'section' => 'malawi_bishops_homepage',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'malawi_bishops_events_count',
		array(
			'default'           => 3,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'malawi_bishops_events_count',
		array(
			'label'   => __( 'Number of Events to Display', 'malawi-bishops' ),
			'section' => 'malawi_bishops_homepage',
			'type'    => 'number',
		)
	);

	// Footer Section
	$wp_customize->add_section(
		'malawi_bishops_footer',
		array(
			'title'    => __( 'Footer', 'malawi-bishops' ),
			'priority' => 60,
		)
	);

	$wp_customize->add_setting(
		'malawi_bishops_copyright_text',
		array(
			'default'           => '&copy; ' . date( 'Y' ) . ' ' . get_bloginfo( 'name' ) . '. All Rights Reserved.',
			'sanitize_callback' => 'wp_kses_post',
		)
	);

	$wp_customize->add_control(
		'malawi_bishops_copyright_text',
		array(
			'label'   => __( 'Copyright Text', 'malawi-bishops' ),
			'section' => 'malawi_bishops_footer',
			'type'    => 'textarea',
		)
	);

	// Theme Colors
	$wp_customize->add_setting(
		'malawi_bishops_primary_color',
		array(
			'default'           => '#4b0082',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'malawi_bishops_primary_color',
			array(
				'label'    => __( 'Primary Color', 'malawi-bishops' ),
				'section'  => 'colors',
				'settings' => 'malawi_bishops_primary_color',
			)
		)
	);

	$wp_customize->add_setting(
		'malawi_bishops_accent_color',
		array(
			'default'           => '#d4af37',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'malawi_bishops_accent_color',
			array(
				'label'    => __( 'Accent Color', 'malawi-bishops' ),
				'section'  => 'colors',
				'settings' => 'malawi_bishops_accent_color',
			)
		)
	);
}
add_action( 'customize_register', 'malawi_bishops_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function malawi_bishops_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function malawi_bishops_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function malawi_bishops_customize_preview_js() {
	wp_enqueue_script( 'malawi-bishops-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), MALAWI_BISHOPS_VERSION, true );
}
add_action( 'customize_preview_init', 'malawi_bishops_customize_preview_js' );

/**
 * Sanitize checkbox values
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool
 */
function malawi_bishops_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && true === $checked ) ? true : false );
}

/**
 * Output the customized CSS for the theme.
 */
function malawi_bishops_customizer_css() {
	$primary_color = get_theme_mod( 'malawi_bishops_primary_color', '#4b0082' );
	$accent_color = get_theme_mod( 'malawi_bishops_accent_color', '#d4af37' );
	?>
	<style type="text/css">
		:root {
			--primary-color: <?php echo esc_attr( $primary_color ); ?>;
			--accent-color: <?php echo esc_attr( $accent_color ); ?>;
		}
	</style>
	<?php
}
add_action( 'wp_head', 'malawi_bishops_customizer_css' );
