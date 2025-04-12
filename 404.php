<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Malawi_Bishops
 */

get_header();
?>

	<main id="primary" class="site-main">
		<div class="container">
			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'malawi-bishops' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'malawi-bishops' ); ?></p>

					<?php
					get_search_form();

					// Show recent posts
					?>
					<div class="widget widget_recent_entries">
						<h2 class="widget-title"><?php esc_html_e( 'Recent Posts', 'malawi-bishops' ); ?></h2>
						<ul>
							<?php
							wp_get_archives( array(
								'type'      => 'postbypost',
								'limit'     => 5,
							) );
							?>
						</ul>
					</div>

					<?php
					// Show upcoming events
					$today = date('Y-m-d');
					$args = array(
						'post_type'      => 'event',
						'posts_per_page' => 3,
						'meta_key'       => '_event_start_date',
						'orderby'        => 'meta_value',
						'order'          => 'ASC',
						'meta_query'     => array(
							array(
								'key'     => '_event_start_date',
								'value'   => $today,
								'compare' => '>=',
								'type'    => 'DATE',
							),
						),
					);
					
					$events_query = new WP_Query( $args );
					
					if ( $events_query->have_posts() ) :
						?>
						<div class="widget">
							<h2 class="widget-title"><?php esc_html_e( 'Upcoming Events', 'malawi-bishops' ); ?></h2>
							<div class="events-list">
								<?php
								while ( $events_query->have_posts() ) :
									$events_query->the_post();
									get_template_part( 'template-parts/content', 'event' );
								endwhile;
								wp_reset_postdata();
								?>
							</div>
						</div>
					<?php endif; ?>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->
		</div>
	</main><!-- #main -->

<?php
get_footer();
