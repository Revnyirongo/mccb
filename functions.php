<?php
/**
 * Malawi Bishops functions and definitions
 *
 * @package Malawi_Bishops
 */

if ( ! defined( 'MALAWI_BISHOPS_VERSION' ) ) {
	define( 'MALAWI_BISHOPS_VERSION', '1.1.0' );
}

/**
 * Force HTTPS for assets
 */
function malawi_bishops_force_https() {
    if (is_ssl()) {
        // Replace all instances of http:// in the content with https://
        add_filter('script_loader_src', 'malawi_bishops_ssl_url');
        add_filter('style_loader_src', 'malawi_bishops_ssl_url');
        add_filter('the_content', 'malawi_bishops_ssl_url');
        add_filter('widget_text', 'malawi_bishops_ssl_url');
    }
}

function malawi_bishops_ssl_url($url) {
    if (is_ssl() && strpos($url, 'http://') === 0) {
        $url = str_replace('http://', 'https://', $url);
    }
    return $url;
}
add_action('init', 'malawi_bishops_force_https');

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function malawi_bishops_setup() {
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

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

	// Register nav menus
	register_nav_menus(
		array(
			'main-menu' => esc_html__( 'Main Menu', 'malawi-bishops' ),
			'footer-menu' => esc_html__( 'Footer Menu', 'malawi-bishops' ),
		)
	);

	// Switch default core markup to output valid HTML5.
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

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'malawi_bishops_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add excerpt support for pages
	add_post_type_support( 'page', 'excerpt' );
}
add_action( 'after_setup_theme', 'malawi_bishops_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function malawi_bishops_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'malawi_bishops_content_width', 1200 );
}
add_action( 'after_setup_theme', 'malawi_bishops_content_width', 0 );

/**
 * Register widget area.
 */
function malawi_bishops_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'malawi-bishops' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'malawi-bishops' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	// Register footer widget areas
	$footer_widget_areas = 4;
	for ( $i = 1; $i <= $footer_widget_areas; $i++ ) {
		register_sidebar(
			array(
				'name'          => sprintf( esc_html__( 'Footer %d', 'malawi-bishops' ), $i ),
				'id'            => 'footer-' . $i,
				'description'   => esc_html__( 'Add footer widgets here.', 'malawi-bishops' ),
				'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="footer-widget-title">',
				'after_title'   => '</h4>',
			)
		);
	}
}
add_action( 'widgets_init', 'malawi_bishops_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function malawi_bishops_scripts() {
	wp_enqueue_style( 'malawi-bishops-style', get_stylesheet_uri(), array(), MALAWI_BISHOPS_VERSION );
	wp_style_add_data( 'malawi-bishops-style', 'rtl', 'replace' );

	wp_enqueue_script( 'malawi-bishops-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), MALAWI_BISHOPS_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'malawi_bishops_scripts' );

/**
 * Enqueue additional scripts for the enhanced header
 */
function malawi_bishops_header_scripts() {
    // Add this to your existing malawi_bishops_scripts function
    
    // Only add the following if you don't already have navigation.js enqueued
    // wp_enqueue_script('malawi-bishops-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), MALAWI_BISHOPS_VERSION, true);
    
    // Alternatively, if you want to keep it separate:
    wp_enqueue_script('malawi-bishops-header', get_template_directory_uri() . '/assets/js/header.js', array('jquery'), MALAWI_BISHOPS_VERSION, true);
}
add_action('wp_enqueue_scripts', 'malawi_bishops_header_scripts');

/**
 * Enqueue additional scripts for enhanced header functionality
 */
function malawi_bishops_enhanced_header_scripts() {
    // Enqueue header.js (modified version)
    wp_enqueue_script('malawi-bishops-header', get_template_directory_uri() . '/assets/js/header.js', array('jquery'), MALAWI_BISHOPS_VERSION, true);
    
    // Enqueue scroll progress script
    wp_enqueue_script('malawi-bishops-scroll-progress', get_template_directory_uri() . '/assets/js/scroll-progress.js', array(), MALAWI_BISHOPS_VERSION, true);
}
add_action('wp_enqueue_scripts', 'malawi_bishops_enhanced_header_scripts');

/**
 * Register Custom Post Types
 */
function malawi_bishops_register_post_types() {
	// Register Bishops CPT
	$labels = array(
		'name'                  => _x( 'Bishops', 'Post type general name', 'malawi-bishops' ),
		'singular_name'         => _x( 'Bishop', 'Post type singular name', 'malawi-bishops' ),
		'menu_name'             => _x( 'Bishops', 'Admin Menu text', 'malawi-bishops' ),
		'name_admin_bar'        => _x( 'Bishop', 'Add New on Toolbar', 'malawi-bishops' ),
		'add_new'               => __( 'Add New', 'malawi-bishops' ),
		'add_new_item'          => __( 'Add New Bishop', 'malawi-bishops' ),
		'new_item'              => __( 'New Bishop', 'malawi-bishops' ),
		'edit_item'             => __( 'Edit Bishop', 'malawi-bishops' ),
		'view_item'             => __( 'View Bishop', 'malawi-bishops' ),
		'all_items'             => __( 'All Bishops', 'malawi-bishops' ),
		'search_items'          => __( 'Search Bishops', 'malawi-bishops' ),
		'parent_item_colon'     => __( 'Parent Bishops:', 'malawi-bishops' ),
		'not_found'             => __( 'No bishops found.', 'malawi-bishops' ),
		'not_found_in_trash'    => __( 'No bishops found in Trash.', 'malawi-bishops' ),
	);
	
	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'bishop' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 20,
		'menu_icon'          => 'dashicons-groups',
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
	);
	
	register_post_type( 'bishop', $args );
	
	// Register Events CPT
	$labels = array(
		'name'                  => _x( 'Events', 'Post type general name', 'malawi-bishops' ),
		'singular_name'         => _x( 'Event', 'Post type singular name', 'malawi-bishops' ),
		'menu_name'             => _x( 'Events', 'Admin Menu text', 'malawi-bishops' ),
		'name_admin_bar'        => _x( 'Event', 'Add New on Toolbar', 'malawi-bishops' ),
		'add_new'               => __( 'Add New', 'malawi-bishops' ),
		'add_new_item'          => __( 'Add New Event', 'malawi-bishops' ),
		'new_item'              => __( 'New Event', 'malawi-bishops' ),
		'edit_item'             => __( 'Edit Event', 'malawi-bishops' ),
		'view_item'             => __( 'View Event', 'malawi-bishops' ),
		'all_items'             => __( 'All Events', 'malawi-bishops' ),
		'search_items'          => __( 'Search Events', 'malawi-bishops' ),
		'parent_item_colon'     => __( 'Parent Events:', 'malawi-bishops' ),
		'not_found'             => __( 'No events found.', 'malawi-bishops' ),
		'not_found_in_trash'    => __( 'No events found in Trash.', 'malawi-bishops' ),
	);
	
	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'event' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 21,
		'menu_icon'          => 'dashicons-calendar-alt',
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
	);
	
	register_post_type( 'event', $args );
}
add_action( 'init', 'malawi_bishops_register_post_types' );

/**
 * Register Custom Taxonomies
 */
function malawi_bishops_register_taxonomies() {
	// Register Diocese taxonomy
	$labels = array(
		'name'              => _x( 'Dioceses', 'taxonomy general name', 'malawi-bishops' ),
		'singular_name'     => _x( 'Diocese', 'taxonomy singular name', 'malawi-bishops' ),
		'search_items'      => __( 'Search Dioceses', 'malawi-bishops' ),
		'all_items'         => __( 'All Dioceses', 'malawi-bishops' ),
		'parent_item'       => __( 'Parent Diocese', 'malawi-bishops' ),
		'parent_item_colon' => __( 'Parent Diocese:', 'malawi-bishops' ),
		'edit_item'         => __( 'Edit Diocese', 'malawi-bishops' ),
		'update_item'       => __( 'Update Diocese', 'malawi-bishops' ),
		'add_new_item'      => __( 'Add New Diocese', 'malawi-bishops' ),
		'new_item_name'     => __( 'New Diocese Name', 'malawi-bishops' ),
		'menu_name'         => __( 'Dioceses', 'malawi-bishops' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'diocese' ),
	);

	register_taxonomy( 'diocese', array( 'bishop' ), $args );
	
	// Register Event Type taxonomy
	$labels = array(
		'name'              => _x( 'Event Types', 'taxonomy general name', 'malawi-bishops' ),
		'singular_name'     => _x( 'Event Type', 'taxonomy singular name', 'malawi-bishops' ),
		'search_items'      => __( 'Search Event Types', 'malawi-bishops' ),
		'all_items'         => __( 'All Event Types', 'malawi-bishops' ),
		'parent_item'       => __( 'Parent Event Type', 'malawi-bishops' ),
		'parent_item_colon' => __( 'Parent Event Type:', 'malawi-bishops' ),
		'edit_item'         => __( 'Edit Event Type', 'malawi-bishops' ),
		'update_item'       => __( 'Update Event Type', 'malawi-bishops' ),
		'add_new_item'      => __( 'Add New Event Type', 'malawi-bishops' ),
		'new_item_name'     => __( 'New Event Type Name', 'malawi-bishops' ),
		'menu_name'         => __( 'Event Types', 'malawi-bishops' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'event-type' ),
	);

	register_taxonomy( 'event-type', array( 'event' ), $args );
}
add_action( 'init', 'malawi_bishops_register_taxonomies' );

/**
 * Register Front Page category if it doesn't exist
 */
function malawi_bishops_register_categories() {
    // Check if 'front-page' category exists
    if (!term_exists('front-page', 'category')) {
        wp_insert_term(
            'Front Page', // the term 
            'category', // the taxonomy
            array(
                'description' => 'Posts to display in the hero section of the front page',
                'slug' => 'front-page'
            )
        );
    }
    
    // Check if 'announcements' category exists
    if (!term_exists('announcements', 'category')) {
        wp_insert_term(
            'Announcements', // the term 
            'category', // the taxonomy
            array(
                'description' => 'Important announcements to display in the header',
                'slug' => 'announcements'
            )
        );
    }
}
add_action('init', 'malawi_bishops_register_categories');

/**
 * Add meta boxes for custom fields
 */
function malawi_bishops_add_meta_boxes() {
	// Bishop meta box
	add_meta_box(
		'bishop_details',
		__( 'Bishop Details', 'malawi-bishops' ),
		'malawi_bishops_bishop_details_callback',
		'bishop',
		'normal',
		'high'
	);
	
	// Event meta box
	add_meta_box(
		'event_details',
		__( 'Event Details', 'malawi-bishops' ),
		'malawi_bishops_event_details_callback',
		'event',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'malawi_bishops_add_meta_boxes' );

/**
 * Meta box callback functions
 */
function malawi_bishops_bishop_details_callback( $post ) {
	wp_nonce_field( 'malawi_bishops_save_bishop_details', 'malawi_bishops_bishop_details_nonce' );
	
	$title = get_post_meta( $post->ID, '_bishop_title', true );
	$role = get_post_meta( $post->ID, '_bishop_role', true );
	?>
	<p>
		<label for="bishop_title"><?php esc_html_e( 'Title', 'malawi-bishops' ); ?></label><br />
		<input type="text" id="bishop_title" name="bishop_title" value="<?php echo esc_attr( $title ); ?>" class="widefat">
		<span class="description"><?php esc_html_e( 'e.g., Most Rev., Archbishop, Bishop', 'malawi-bishops' ); ?></span>
	</p>
	<p>
		<label for="bishop_role"><?php esc_html_e( 'Role in Conference', 'malawi-bishops' ); ?></label><br />
		<input type="text" id="bishop_role" name="bishop_role" value="<?php echo esc_attr( $role ); ?>" class="widefat">
		<span class="description"><?php esc_html_e( 'e.g., President, Vice President, Secretary', 'malawi-bishops' ); ?></span>
	</p>
	<?php
}

function malawi_bishops_event_details_callback( $post ) {
	wp_nonce_field( 'malawi_bishops_save_event_details', 'malawi_bishops_event_details_nonce' );
	
	$start_date = get_post_meta( $post->ID, '_event_start_date', true );
	$end_date = get_post_meta( $post->ID, '_event_end_date', true );
	$location = get_post_meta( $post->ID, '_event_location', true );
	?>
	<p>
		<label for="event_start_date"><?php esc_html_e( 'Start Date', 'malawi-bishops' ); ?></label><br />
		<input type="date" id="event_start_date" name="event_start_date" value="<?php echo esc_attr( $start_date ); ?>" class="widefat">
	</p>
	<p>
		<label for="event_end_date"><?php esc_html_e( 'End Date (optional)', 'malawi-bishops' ); ?></label><br />
		<input type="date" id="event_end_date" name="event_end_date" value="<?php echo esc_attr( $end_date ); ?>" class="widefat">
	</p>
	<p>
		<label for="event_location"><?php esc_html_e( 'Location', 'malawi-bishops' ); ?></label><br />
		<input type="text" id="event_location" name="event_location" value="<?php echo esc_attr( $location ); ?>" class="widefat">
	</p>
	<?php
}

/**
 * Save meta box data
 */
function malawi_bishops_save_meta_boxes( $post_id ) {
	// Bishop details
	if ( isset( $_POST['malawi_bishops_bishop_details_nonce'] ) && 
		 wp_verify_nonce( $_POST['malawi_bishops_bishop_details_nonce'], 'malawi_bishops_save_bishop_details' ) ) {
		
		if ( isset( $_POST['bishop_title'] ) ) {
			update_post_meta( $post_id, '_bishop_title', sanitize_text_field( $_POST['bishop_title'] ) );
		}
		
		if ( isset( $_POST['bishop_role'] ) ) {
			update_post_meta( $post_id, '_bishop_role', sanitize_text_field( $_POST['bishop_role'] ) );
		}
	}
	
	// Event details
	if ( isset( $_POST['malawi_bishops_event_details_nonce'] ) && 
		 wp_verify_nonce( $_POST['malawi_bishops_event_details_nonce'], 'malawi_bishops_save_event_details' ) ) {
		
		if ( isset( $_POST['event_start_date'] ) ) {
			update_post_meta( $post_id, '_event_start_date', sanitize_text_field( $_POST['event_start_date'] ) );
		}
		
		if ( isset( $_POST['event_end_date'] ) ) {
			update_post_meta( $post_id, '_event_end_date', sanitize_text_field( $_POST['event_end_date'] ) );
		}
		
		if ( isset( $_POST['event_location'] ) ) {
			update_post_meta( $post_id, '_event_location', sanitize_text_field( $_POST['event_location'] ) );
		}
	}
}
add_action( 'save_post', 'malawi_bishops_save_meta_boxes' );

/**
 * Add custom admin notice to inform about Front Page category
 */
function malawi_bishops_admin_notice() {
    global $pagenow;
    if ($pagenow == 'edit.php' && !isset($_GET['post_type']) || 
        (isset($_GET['post_type']) && $_GET['post_type'] == 'post')) {
        ?>
        <div class="notice notice-info is-dismissible">
            <p><?php _e('To display posts in the homepage hero section, assign them to the "Front Page" category.', 'malawi-bishops'); ?></p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'malawi_bishops_admin_notice');

/**
 * Include template functions
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Include template tags
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Include customizer options
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Include Custom Widgets
 */
require get_template_directory() . '/inc/widgets.php';
