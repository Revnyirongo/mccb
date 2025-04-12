<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Malawi_Bishops
 */

get_header();
?>

	<main id="primary" class="site-main">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<?php if ( have_posts() ) : ?>

						<header class="page-header">
							<?php
							the_archive_title( '<h1 class="page-title">', '</h1>' );
							the_archive_description( '<div class="archive-description">', '</div>' );
							?>
						</header><!-- .page-header -->

						<?php
						// Special handling for custom post types archives
						$post_type = get_post_type();
						
						if ( 'bishop' === $post_type ) {
							echo '<div class="bishops-grid">';
							while ( have_posts() ) :
								the_post();
								get_template_part( 'template-parts/content', 'bishop' );
							endwhile;
							echo '</div>';
						} elseif ( 'event' === $post_type ) {
							// For events archive, add toggle for past/upcoming
							if ( is_post_type_archive( 'event' ) ) :
								$current_url = remove_query_arg( 'show' );
								$upcoming_url = add_query_arg( array( 'show' => 'upcoming' ), $current_url );
								$past_url = add_query_arg( array( 'show' => 'past' ), $current_url );
								$current_show = isset( $_GET['show'] ) ? sanitize_text_field( $_GET['show'] ) : 'upcoming';
								?>
								<div class="event-filter">
									<a href="<?php echo esc_url( $upcoming_url ); ?>" class="<?php echo ( 'upcoming' === $current_show || '' === $current_show ) ? 'active' : ''; ?>"><?php esc_html_e( 'Upcoming Events', 'malawi-bishops' ); ?></a>
									<a href="<?php echo esc_url( $past_url ); ?>" class="<?php echo ( 'past' === $current_show ) ? 'active' : ''; ?>"><?php esc_html_e( 'Past Events', 'malawi-bishops' ); ?></a>
								</div>
							<?php endif; ?>
							
							<div class="events-list">
								<?php
								while ( have_posts() ) :
									the_post();
									get_template_part( 'template-parts/content', 'event' );
								endwhile;
								?>
							</div>
							<?php
						} else {
							// Regular post type archives
							while ( have_posts() ) :
								the_post();
								get_template_part( 'template-parts/content', get_post_type() );
							endwhile;
						}
						
						the_posts_navigation();
						?>

					<?php else : ?>

						<?php get_template_part( 'template-parts/content', 'none' ); ?>

					<?php endif; ?>
				</div>
				
				<div class="col-md-4">
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div>
	</main><!-- #main -->

<?php
get_footer();
