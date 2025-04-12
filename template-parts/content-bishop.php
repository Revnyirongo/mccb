<?php
/**
 * Template part for displaying bishop content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Malawi_Bishops
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('bishop-card'); ?>>
	<?php
	// Get the diocese for displaying on the image
	$dioceses = get_the_terms(get_the_ID(), 'diocese');
	?>
	
	<?php if (has_post_thumbnail()) : ?>
		<div class="bishop-img">
			<?php the_post_thumbnail('medium'); ?>
			
			<?php if (!empty($dioceses) && !is_wp_error($dioceses)) : ?>
				<div class="bishop-diocese"><?php echo esc_html($dioceses[0]->name); ?></div>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	
	<div class="bishop-content">
		<header class="entry-header">
			<?php 
			$bishop_title = get_post_meta(get_the_ID(), '_bishop_title', true);
			if ($bishop_title) {
				echo '<h3>' . esc_html($bishop_title) . ' ' . get_the_title() . '</h3>';
			} else {
				the_title('<h3 class="entry-title">', '</h3>');
			}
			
			// Get the diocese for text display
			if (!empty($dioceses) && !is_wp_error($dioceses)) {
				echo '<p class="bishop-title">' . esc_html($dioceses[0]->name) . '</p>';
			}
			
			// Role in conference
			$role = get_post_meta(get_the_ID(), '_bishop_role', true);
			if ($role) {
				echo '<p class="bishop-info">' . esc_html($role) . '</p>';
			}
			?>
		</header><!-- .entry-header -->

		<?php if (is_singular()) : ?>
			<div class="entry-content">
				<?php
				the_content();
				
				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__('Pages:', 'malawi-bishops'),
						'after'  => '</div>',
					)
				);
				?>
			</div><!-- .entry-content -->
		<?php else : ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
				<a href="<?php the_permalink(); ?>" class="read-more"><?php esc_html_e('Read Biography', 'malawi-bishops'); ?></a>
			</div><!-- .entry-summary -->
		<?php endif; ?>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
