<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Malawi_Bishops
 */

get_header();
?>

	<main id="primary" class="site-main">
		<div class="container">
			<?php
			while (have_posts()) :
				the_post();

				$post_type = get_post_type();
				
				if ('bishop' === $post_type) {
					get_template_part('template-parts/content', 'bishop');
				} elseif ('event' === $post_type) {
					get_template_part('template-parts/content', 'event');
				} else {
					// For standard posts, use the enhanced single post layout
					malawi_bishops_enhanced_single_post();
				}

			endwhile; // End of the loop.
			?>
		</div>
	</main><!-- #main -->

<?php
get_footer();
