<?php
/**
 * Custom template tags for this theme
 *
 * @package Malawi_Bishops
 */

if ( ! function_exists( 'malawi_bishops_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function malawi_bishops_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'malawi-bishops' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'malawi_bishops_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function malawi_bishops_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'malawi-bishops' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'malawi_bishops_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function malawi_bishops_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'malawi-bishops' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'malawi-bishops' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'malawi-bishops' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'malawi-bishops' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'malawi-bishops' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'malawi-bishops' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'malawi_bishops_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function malawi_bishops_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
					the_post_thumbnail(
						'post-thumbnail',
						array(
							'alt' => the_title_attribute(
								array(
									'echo' => false,
								)
							),
						)
					);
				?>
			</a>

			<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;

/**
 * Display a list of all dioceses with links
 */
function malawi_bishops_list_dioceses() {
	$dioceses = get_terms( array(
		'taxonomy' => 'diocese',
		'hide_empty' => false,
	) );

	if ( ! empty( $dioceses ) && ! is_wp_error( $dioceses ) ) {
		echo '<ul class="dioceses-list">';
		foreach ( $dioceses as $diocese ) {
			echo '<li><a href="' . esc_url( get_term_link( $diocese ) ) . '">' . esc_html( $diocese->name ) . '</a></li>';
		}
		echo '</ul>';
	}
}

/**
 * Display bishop grid for a specific diocese
 * 
 * @param string $diocese_slug The slug of the diocese to display bishops for
 * @param int $number Number of bishops to display
 */
function malawi_bishops_display_diocese_bishops( $diocese_slug, $number = -1 ) {
	$args = array(
		'post_type' => 'bishop',
		'posts_per_page' => $number,
		'tax_query' => array(
			array(
				'taxonomy' => 'diocese',
				'field' => 'slug',
				'terms' => $diocese_slug,
			),
		),
	);

	$bishops_query = new WP_Query( $args );

	if ( $bishops_query->have_posts() ) {
		echo '<div class="bishops-grid">';
		while ( $bishops_query->have_posts() ) {
			$bishops_query->the_post();
			get_template_part( 'template-parts/content', 'bishop' );
		}
		echo '</div>';
		wp_reset_postdata();
	} else {
		echo '<p>' . esc_html__( 'No bishops found for this diocese.', 'malawi-bishops' ) . '</p>';
	}
}

/**
 * Display upcoming events
 * 
 * @param int $number Number of events to display
 */
function malawi_bishops_display_upcoming_events( $number = 3 ) {
	$today = date('Y-m-d');
	$args = array(
		'post_type' => 'event',
		'posts_per_page' => $number,
		'meta_key' => '_event_start_date',
		'orderby' => 'meta_value',
		'order' => 'ASC',
		'meta_query' => array(
			array(
				'key' => '_event_start_date',
				'value' => $today,
				'compare' => '>=',
				'type' => 'DATE',
			),
		),
	);

	$events_query = new WP_Query( $args );

	if ( $events_query->have_posts() ) {
		echo '<div class="events-list">';
		while ( $events_query->have_posts() ) {
			$events_query->the_post();
			get_template_part( 'template-parts/content', 'event' );
		}
		echo '</div>';
		wp_reset_postdata();
	} else {
		echo '<p>' . esc_html__( 'No upcoming events found.', 'malawi-bishops' ) . '</p>';
	}
}
