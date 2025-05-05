<?php
/**
 * The template for displaying the front page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Malawi_Bishops
 */

get_header();
?>

<main id="primary" class="site-main">
    <?php
    // Hero Slider - displays posts from Front Page category
    malawi_bishops_hero_slider();
    
    // About MCCB Section
    get_template_part('template-parts/about-section');
    
    // Bishops Grid - 10 bishops in 2 rows of 5
    $bishops_args = array(
        'post_type'      => 'bishop',
        'posts_per_page' => 10,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    );

    $bishops_query = new WP_Query($bishops_args);

    if ($bishops_query->have_posts()) :
    ?>
        <section class="bishops-section py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center text-purple-800 mb-12">
                    Bishops of the Catholic Church in Malawi
                </h2>
                
                <div class="bishops-grid max-w-6xl mx-auto">
                    <?php while ($bishops_query->have_posts()) : $bishops_query->the_post(); ?>
                        <div class="bishop-card">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="bishop-img">
                                    <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover object-top']); ?>
                                    <?php
                                    $dioceses = get_the_terms(get_the_ID(), 'diocese');
                                    if (!empty($dioceses) && !is_wp_error($dioceses)) :
                                    ?>
                                        <span class="bishop-diocese"><?php echo esc_html($dioceses[0]->name); ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="bishop-content">
                                <h3 class="bishop-name">
                                    <?php 
                                    $bishop_title = get_post_meta(get_the_ID(), '_bishop_title', true);
                                    if ($bishop_title) {
                                        echo esc_html($bishop_title) . ' ' . get_the_title();
                                    } else {
                                        the_title();
                                    }
                                    ?>
                                </h3>
                                <?php
                                $role = get_post_meta(get_the_ID(), '_bishop_role', true);
                                if ($role) :
                                ?>
                                    <p class="bishop-role"><?php echo esc_html($role); ?></p>
                                <?php endif; ?>
                                
                                <a href="<?php the_permalink(); ?>" class="bishop-link absolute inset-0 z-10">
                                    <span class="sr-only">Read more about <?php the_title(); ?></span>
                                </a>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
    
    <?php
    // Features Section (Our Mission)
    $show_features = get_theme_mod('malawi_bishops_show_features', true);
    if ($show_features) :
        $features_title = get_theme_mod('malawi_bishops_features_title', 'Our Mission');
    ?>
    
    <section class="section">
        <div class="container">
            <?php if ($features_title) : ?>
                <h2 class="section-title"><?php echo esc_html($features_title); ?></h2>
            <?php endif; ?>
            
            <div class="features-grid">
                <?php
                // Feature 1
                $feature1_title = get_theme_mod('malawi_bishops_feature1_title', 'Evangelization');
                $feature1_text = get_theme_mod('malawi_bishops_feature1_text', 'Proclaiming the Good News of salvation in Jesus Christ to all people in Malawi and fostering spiritual growth among the faithful.');
                $feature1_image = get_theme_mod('malawi_bishops_feature1_image', '');
                
                // Feature 2
                $feature2_title = get_theme_mod('malawi_bishops_feature2_title', 'Justice and Peace');
                $feature2_text = get_theme_mod('malawi_bishops_feature2_text', 'Promoting human dignity, advocating for social justice, and working towards peace and reconciliation in our society.');
                $feature2_image = get_theme_mod('malawi_bishops_feature2_image', '');
                
                // Feature 3
                $feature3_title = get_theme_mod('malawi_bishops_feature3_title', 'Education');
                $feature3_text = get_theme_mod('malawi_bishops_feature3_text', 'Supporting Catholic education and formation at all levels to nurture faith, intellect, and character in future generations.');
                $feature3_image = get_theme_mod('malawi_bishops_feature3_image', '');
                ?>
                
                <div class="feature-card">
                    <div class="feature-img">
                        <?php if ($feature1_image) : ?>
                            <img src="<?php echo esc_url($feature1_image); ?>" alt="<?php echo esc_attr($feature1_title); ?>">
                        <?php else : ?>
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/placeholder.jpg'); ?>" alt="<?php echo esc_attr($feature1_title); ?>">
                        <?php endif; ?>
                    </div>
                    <div class="feature-content">
                        <h3><?php echo esc_html($feature1_title); ?></h3>
                        <p><?php echo esc_html($feature1_text); ?></p>
                    </div>
                </div>
                
                <div class="feature-card">
                    <div class="feature-img">
                        <?php if ($feature2_image) : ?>
                            <img src="<?php echo esc_url($feature2_image); ?>" alt="<?php echo esc_attr($feature2_title); ?>">
                        <?php else : ?>
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/placeholder.jpg'); ?>" alt="<?php echo esc_attr($feature2_title); ?>">
                        <?php endif; ?>
                    </div>
                    <div class="feature-content">
                        <h3><?php echo esc_html($feature2_title); ?></h3>
                        <p><?php echo esc_html($feature2_text); ?></p>
                    </div>
                </div>
                
                <div class="feature-card">
                    <div class="feature-img">
                        <?php if ($feature3_image) : ?>
                            <img src="<?php echo esc_url($feature3_image); ?>" alt="<?php echo esc_attr($feature3_title); ?>">
                        <?php else : ?>
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/placeholder.jpg'); ?>" alt="<?php echo esc_attr($feature3_title); ?>">
                        <?php endif; ?>
                    </div>
                    <div class="feature-content">
                        <h3><?php echo esc_html($feature3_title); ?></h3>
                        <p><?php echo esc_html($feature3_text); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <?php
    // Events and CTA Section
    get_template_part('template-parts/events-cta');
    
    // News Section
    $show_news = get_theme_mod('malawi_bishops_show_news', true);
    if ($show_news) :
        $news_title = get_theme_mod('malawi_bishops_news_title', 'Latest News');
        $news_count = get_theme_mod('malawi_bishops_news_count', 3);
    ?>
    
    <section class="section news-section">
        <div class="container">
            <?php if ($news_title) : ?>
                <h2 class="section-title"><?php echo esc_html($news_title); ?></h2>
            <?php endif; ?>
            
            <div class="news-grid">
                <?php
                $args = array(
                    'post_type'      => 'post',
                    'posts_per_page' => absint($news_count),
                    'category__not_in' => array(get_cat_ID('front-page')), // Exclude front-page category posts
                );
                
                $news_query = new WP_Query($args);
                
                if ($news_query->have_posts()) :
                    while ($news_query->have_posts()) :
                        $news_query->the_post();
                        ?>
                        <div class="news-card">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="news-img">
                                    <?php the_post_thumbnail(); ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="news-content">
                                <div class="news-date"><?php echo get_the_date(); ?></div>
                                <h3><?php the_title(); ?></h3>
                                <?php the_excerpt(); ?>
                                <a href="<?php the_permalink(); ?>" class="read-more"><?php esc_html_e('Read More', 'malawi-bishops'); ?></a>
                            </div>
                        </div>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    ?>
                    <p><?php esc_html_e('No news posts found.', 'malawi-bishops'); ?></p>
                    <?php
                endif;
                ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <?php
    // Facebook Feed Section
    get_template_part('template-parts/facebook-feed');
    
    // Content from the front page if it exists
    // We'll only show the content that's directly added to the page, not the default posts
    if (is_front_page() && !is_home()) { // Check if we're on a static front page
        while (have_posts()) :
            the_post();
            
            // Only display if there's actual content and skip if empty
            $content = get_the_content();
            if (!empty($content)) :
                ?>
                <section class="section page-content-section">
                    <div class="container">
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </section>
                <?php
            endif;
        endwhile;
    }
    ?>

</main><!-- #main -->

<?php
get_footer();
