<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Malawi_Bishops
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function malawi_bishops_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'malawi_bishops_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function malawi_bishops_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'malawi_bishops_pingback_header' );

/**
 * Add custom image sizes
 */
function malawi_bishops_custom_image_sizes() {
	add_image_size( 'bishop-portrait', 300, 400, true );
	add_image_size( 'feature-image', 600, 400, true );
	add_image_size( 'hero-image', 1920, 800, true );
}
add_action( 'after_setup_theme', 'malawi_bishops_custom_image_sizes' );

/**
 * Make custom image sizes available in WordPress admin
 */
function malawi_bishops_custom_image_sizes_names( $sizes ) {
	return array_merge( $sizes, array(
		'bishop-portrait' => __( 'Bishop Portrait', 'malawi-bishops' ),
		'feature-image' => __( 'Feature Image', 'malawi-bishops' ),
		'hero-image' => __( 'Hero Image', 'malawi-bishops' ),
	) );
}
add_filter( 'image_size_names_choose', 'malawi_bishops_custom_image_sizes_names' );

/**
 * Format event date for display
 */
function malawi_bishops_format_event_date( $post_id ) {
	$start_date = get_post_meta( $post_id, '_event_start_date', true );
	$end_date = get_post_meta( $post_id, '_event_end_date', true );
	
	if ( empty( $start_date ) ) {
		return '';
	}
	
	$start = new DateTime( $start_date );
	
	if ( ! empty( $end_date ) ) {
		$end = new DateTime( $end_date );
		
		// Same day event
		if ( $start->format( 'Y-m-d' ) === $end->format( 'Y-m-d' ) ) {
			return $start->format( 'F j, Y' );
		}
		
		// Same month event
		if ( $start->format( 'Y-m' ) === $end->format( 'Y-m' ) ) {
			return $start->format( 'F j' ) . ' - ' . $end->format( 'j, Y' );
		}
		
		// Same year event
		if ( $start->format( 'Y' ) === $end->format( 'Y' ) ) {
			return $start->format( 'F j' ) . ' - ' . $end->format( 'F j, Y' );
		}
		
		// Different year event
		return $start->format( 'F j, Y' ) . ' - ' . $end->format( 'F j, Y' );
	}
	
	return $start->format( 'F j, Y' );
}

/**
 * Add rel=page for pagination
 */
function malawi_bishops_posts_link_attributes() {
	return 'class="page-numbers"';
}
add_filter( 'next_posts_link_attributes', 'malawi_bishops_posts_link_attributes' );
add_filter( 'previous_posts_link_attributes', 'malawi_bishops_posts_link_attributes' );

/**
 * Customize the excerpt length
 */
function malawi_bishops_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'malawi_bishops_excerpt_length' );

/**
 * Customize the excerpt more text
 */
function malawi_bishops_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'malawi_bishops_excerpt_more' );

/**
 * Custom query for events archive to sort by date
 */
function malawi_bishops_pre_get_posts( $query ) {
	if ( ! is_admin() && $query->is_main_query() && $query->is_post_type_archive( 'event' ) ) {
		$query->set( 'meta_key', '_event_start_date' );
		$query->set( 'orderby', 'meta_value' );
		$query->set( 'order', 'ASC' );
		
		// Show only upcoming events by default
		if ( ! isset( $_GET['show'] ) || $_GET['show'] !== 'past' ) {
			$today = date( 'Y-m-d' );
			$query->set( 'meta_query', array(
				array(
					'key' => '_event_start_date',
					'value' => $today,
					'compare' => '>=',
					'type' => 'DATE',
				),
			) );
		}
	}
	
	return $query;
}
add_action( 'pre_get_posts', 'malawi_bishops_pre_get_posts' );

/**
 * Add a custom query var for showing past events
 */
function malawi_bishops_query_vars( $vars ) {
	$vars[] = 'show';
	return $vars;
}
add_filter( 'query_vars', 'malawi_bishops_query_vars' );
