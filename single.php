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
    <div class="container max-w-4xl mx-auto px-4 py-8">
        <?php
        while (have_posts()) :
            the_post();

            $post_type = get_post_type();
            
            // Check if it's a custom post type
            if ('bishop' === $post_type) {
                get_template_part('template-parts/content', 'bishop');
            } elseif ('event' === $post_type) {
                get_template_part('template-parts/content', 'event');
            } else {
                // For standard posts
                get_template_part('template-parts/content', 'single');
            }

        endwhile;
        ?>
    </div>
</main>

<?php
get_footer();
