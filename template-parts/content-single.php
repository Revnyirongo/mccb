<?php
/**
 * Template part for displaying single posts
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('mb-8'); ?>>
    <header class="entry-header mb-8">
        <?php the_title('<h1 class="entry-title text-3xl font-bold text-purple-800 mb-4">', '</h1>'); ?>
        
        <div class="entry-meta text-gray-600 text-sm mb-4">
            <span class="posted-on">
                <?php echo get_the_date(); ?>
            </span>
            <?php if ('post' === get_post_type()) : ?>
                <span class="by-author ml-4">
                    by <?php the_author(); ?>
                </span>
            <?php endif; ?>
        </div>
    </header>

    <?php if (has_post_thumbnail()) : ?>
        <div class="featured-image mb-6">
            <?php the_post_thumbnail('large', ['class' => 'w-full h-auto rounded-lg shadow-md']); ?>
        </div>
    <?php endif; ?>

    <div class="entry-content prose prose-lg max-w-none mb-8">
        <?php the_content(); ?>
    </div>

    <?php if (is_singular('post') && 'post' === get_post_type()) : ?>
        <footer class="entry-footer border-t pt-4 mt-8">
            <?php
            $categories_list = get_the_category_list(', ');
            if ($categories_list) {
                printf('<div class="cat-links mb-2"><strong>Categories:</strong> %1$s</div>', $categories_list);
            }

            $tags_list = get_the_tag_list('', ', ');
            if ($tags_list) {
                printf('<div class="tags-links"><strong>Tags:</strong> %1$s</div>', $tags_list);
            }
            ?>
        </footer>
    <?php endif; ?>
</article>
