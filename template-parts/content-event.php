<?php
/**
 * Template part for displaying event content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Malawi_Bishops
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'event-card' ); ?>>
	<?php 
	$start_date = get_post_meta( get_the_ID(), '_event_start_date', true );
	if ( $start_date ) : 
		$date = new DateTime($start_date);
	?>
		<div class="event-date">
			<span class="event-day"><?php echo esc_html( $date->format('d') ); ?></span>
			<span class="event-month"><?php echo esc_html( $date->format('M') ); ?></span>
		</div>
	<?php endif; ?>
	
	<div class="event-content">
		<header class="entry-header">
			<?php the_title( '<h3 class="entry-title">', '</h3>' ); ?>
			
			<?php 
			$location = get_post_meta( get_the_ID(), '_event_location', true );
			if ( $location ) {
				echo '<div class="event-location">' . esc_html( $location ) . '</div>';
			}
			?>
		</header><!-- .entry-header -->

		<?php if ( is_singular() ) : ?>
			<div class="entry-content">
				<?php
				// Display event details
				$end_date = get_post_meta( get_the_ID(), '_event_end_date', true );
				if ( $start_date && $end_date ) {
					$start = new DateTime($start_date);
					$end = new DateTime($end_date);
					echo '<p class="event-dates"><strong>' . esc_html__( 'Date:', 'malawi-bishops' ) . '</strong> ';
					echo esc_html( $start->format('F j, Y') ) . ' - ' . esc_html( $end->format('F j, Y') );
					echo '</p>';
				} elseif ( $start_date ) {
					$start = new DateTime($start_date);
					echo '<p class="event-dates"><strong>' . esc_html__( 'Date:', 'malawi-bishops' ) . '</strong> ';
					echo esc_html( $start->format('F j, Y') );
					echo '</p>';
				}
				
				// Get event types
				$event_types = get_the_terms( get_the_ID(), 'event-type' );
				if ( ! empty( $event_types ) && ! is_wp_error( $event_types ) ) {
					echo '<p class="event-type"><strong>' . esc_html__( 'Event Type:', 'malawi-bishops' ) . '</strong> ';
					$types = array();
					foreach ( $event_types as $type ) {
						$types[] = esc_html( $type->name );
					}
					echo implode( ', ', $types );
					echo '</p>';
				}
				
				the_content();
				
				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'malawi-bishops' ),
						'after'  => '</div>',
					)
				);
				?>
			</div><!-- .entry-content -->
		<?php else : ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
				<a href="<?php the_permalink(); ?>" class="read-more"><?php esc_html_e( 'View Event Details', 'malawi-bishops' ); ?></a>
			</div><!-- .entry-summary -->
		<?php endif; ?>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
