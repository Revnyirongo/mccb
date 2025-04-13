<?php
/**
 * Fix for the template-functions-extended.php file
 * This includes the enhanced single post function implementation
 */

/**
 * Enhanced single post layout
 */
function malawi_bishops_enhanced_single_post() {
    ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class('enhanced-single-post'); ?>>
        <?php if (has_post_thumbnail()) : ?>
            <div class="single-featured-image">
                <?php the_post_thumbnail('full'); ?>
            </div>
        <?php endif; ?>
        
        <div class="single-post-header">
            <h1 class="entry-title"><?php the_title(); ?></h1>
            
            <div class="single-post-meta">
                <div class="post-date">
                    <?php 
                    echo esc_html(get_the_date()); 
                    echo ' &middot; ';
                    echo esc_html(get_the_author()); 
                    ?>
                </div>
                
                <div class="post-categories">
                    <?php
                    $categories = get_the_category();
                    if (!empty($categories)) {
                        foreach ($categories as $category) {
                            echo '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        
        <div class="single-post-content">
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
                
                <!-- Tags -->
                <?php if (has_tag()) : ?>
                    <div class="post-tags">
                        <?php the_tags('<span class="tag-title">' . esc_html__('Tags:', 'malawi-bishops') . '</span> ', ', '); ?>
                    </div>
                <?php endif; ?>
                
                <!-- Author Box -->
                <div class="author-box">
                    <div class="author-avatar">
                        <?php echo get_avatar(get_the_author_meta('ID'), 100); ?>
                    </div>
                    <div class="author-bio">
                        <h4><?php the_author(); ?></h4>
                        <?php 
                        $author_description = get_the_author_meta('description');
                        if (!empty($author_description)) {
                            echo '<p>' . esc_html($author_description) . '</p>';
                        } else {
                            echo '<p>' . esc_html__('This author has not provided a biography.', 'malawi-bishops') . '</p>';
                        }
                        ?>
                    </div>
                </div>
                
                <!-- Share Buttons -->
                <div class="share-buttons">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="share-button facebook" aria-label="Share on Facebook">
                        <span class="dashicons dashicons-facebook"></span>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share-button twitter" aria-label="Share on Twitter">
                        <span class="dashicons dashicons-twitter"></span>
                    </a>
                    <a href="mailto:?subject=<?php echo urlencode(get_the_title()); ?>&body=<?php echo urlencode(get_permalink()); ?>" class="share-button email" aria-label="Share via Email">
                        <span class="dashicons dashicons-email"></span>
                    </a>
                </div>
            </div>
            
            <div class="single-post-sidebar">
                <?php
                // Recent Posts Widget
                $recent_posts_args = array(
                    'numberposts' => 5,
                    'post_status' => 'publish',
                    'post__not_in' => array(get_the_ID())
                );
                
                $recent_posts = wp_get_recent_posts($recent_posts_args, ARRAY_A);
                
                if (!empty($recent_posts)) :
                ?>
                <div class="sidebar-widget recent-posts-widget">
                    <h3><?php esc_html_e('Recent Posts', 'malawi-bishops'); ?></h3>
                    <ul>
                        <?php foreach ($recent_posts as $recent_post) : ?>
                            <li>
                                <a href="<?php echo esc_url(get_permalink($recent_post['ID'])); ?>">
                                    <?php echo esc_html($recent_post['post_title']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php 
                endif;
                wp_reset_postdata();
                
                // Categories Widget
                $categories = get_categories(array(
                    'orderby' => 'name',
                    'order' => 'ASC',
                    'hide_empty' => true
                ));
                
                if (!empty($categories)) :
                ?>
                <div class="sidebar-widget categories-widget">
                    <h3><?php esc_html_e('Categories', 'malawi-bishops'); ?></h3>
                    <ul>
                        <?php foreach ($categories as $category) : ?>
                            <li>
                                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                                    <?php echo esc_html($category->name); ?>
                                    <span class="count">(<?php echo esc_html($category->count); ?>)</span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Related Posts -->
        <?php
        $categories = get_the_category();
        $category_ids = array();
        
        if (!empty($categories)) {
            foreach ($categories as $category) {
                $category_ids[] = $category->term_id;
            }
        }
        
        if (!empty($category_ids)) {
            $related_posts_args = array(
                'category__in' => $category_ids,
                'post__not_in' => array(get_the_ID()),
                'posts_per_page' => 3,
                'orderby' => 'rand'
            );
            
            $related_posts = new WP_Query($related_posts_args);
            
            if ($related_posts->have_posts()) :
            ?>
            <div class="related-posts">
                <h3><?php esc_html_e('Related Posts', 'malawi-bishops'); ?></h3>
                
                <div class="related-grid">
                    <?php while ($related_posts->have_posts()) : $related_posts->the_post(); ?>
                        <div class="related-post">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="related-post-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <div class="related-post-content">
                                <h4 class="related-post-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h4>
                                <div class="related-post-date"><?php echo get_the_date(); ?></div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <?php
            endif;
            wp_reset_postdata();
        }
        ?>
    </article>
    <?php
}

/**
 * Display custom scrolling text in header
 * This fixes any potential issues with the function
 */
function malawi_bishops_display_scrolling_text() {
    // Check if enabled
    if (!get_theme_mod('malawi_bishops_enable_scrolling_text', false)) {
        return;
    }
    
    // Get scrolling text and settings
    $text = get_theme_mod('malawi_bishops_scrolling_text', __('Welcome to the Conference of Catholic Bishops in Malawi', 'malawi-bishops'));
    $speed = get_theme_mod('malawi_bishops_scrolling_text_speed', 'medium');
    $color = get_theme_mod('malawi_bishops_scrolling_text_color', '#ffffff');
    $bg = get_theme_mod('malawi_bishops_scrolling_text_bg', 'rgba(255,255,255,0.2)');
    
    // Convert speed setting to animation duration
    $duration = '20s'; // medium (default)
    if ($speed === 'slow') {
        $duration = '30s';
    } elseif ($speed === 'fast') {
        $duration = '12s';
    }
    
    // Split text by pipe symbol
    $text_items = explode('|', $text);
    
    // Generate inline style
    $style = "
        background-color: " . esc_attr($bg) . ";
        color: " . esc_attr($color) . ";
    ";
    
    $wrapper_style = "
        animation-duration: " . esc_attr($duration) . ";
    ";
    ?>
    <div class="scrolling-text-container" style="<?php echo esc_attr($style); ?>">
        <div class="scrolling-text-wrapper" style="<?php echo esc_attr($wrapper_style); ?>">
            <?php foreach ($text_items as $item) : ?>
                <div class="scrolling-text-item"><?php echo esc_html(trim($item)); ?></div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}

/**
 * Get hero slider posts with error handling
 * 
 * @param int $count Number of posts to display
 * @return WP_Query The query result
 */
function malawi_bishops_get_hero_posts($count = 4) {
    $args = array(
        'category_name' => 'front-page',
        'posts_per_page' => absint($count),
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish'
    );
    
    return new WP_Query($args);
}

/**
 * Generate hero slider HTML with improved error handling
 */
function malawi_bishops_hero_slider() {
    $hero_query = malawi_bishops_get_hero_posts(4);
    
    // Default hero content from theme customizer
    $default_hero_title = get_theme_mod('malawi_bishops_hero_title', __('Serving the Church in Malawi', 'malawi-bishops'));
    $default_hero_text = get_theme_mod('malawi_bishops_hero_text', __('Proclaiming the Gospel, promoting human dignity, and building a civilization of love', 'malawi-bishops'));
    $default_hero_button_text = get_theme_mod('malawi_bishops_hero_button_text', __('Learn More', 'malawi-bishops'));
    $default_hero_button_url = get_theme_mod('malawi_bishops_hero_button_url', '#');
    $hero_image = get_theme_mod('malawi_bishops_hero_image', '');
    
    if ($hero_query->have_posts()) :
    ?>
    <div class="hero-slider">
        <?php
        $slide_counter = 0;
        while ($hero_query->have_posts()) :
            $hero_query->the_post();
            $slide_counter++;
            
            // Get featured image
            $bg_image = '';
            if (has_post_thumbnail()) {
                $bg_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
            } elseif (!empty($hero_image)) {
                $bg_image = $hero_image;
            }
            
            // Use excerpt if available, otherwise generate from content
            $slide_text = '';
            if (has_excerpt()) {
                $slide_text = get_the_excerpt();
            } else {
                $content = get_the_content();
                $slide_text = wp_trim_words($content, 25, '...');
            }
            
            // Slide style with background image
            $slide_style = '';
            if ($bg_image) {
                $slide_style = 'style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url(' . esc_url($bg_image) . ') center/cover no-repeat;"';
            }
            
            // Active class for first slide
            $active_class = $slide_counter === 1 ? ' active' : '';
        ?>
            <div class="hero-slide<?php echo esc_attr($active_class); ?>" <?php echo $slide_style; ?>>
                <div class="hero-content-wrapper">
                    <h2 class="hero-title"><?php the_title(); ?></h2>
                    <p class="hero-text"><?php echo esc_html($slide_text); ?></p>
                    <a href="<?php the_permalink(); ?>" class="btn hero-btn">
                        <?php esc_html_e('Read More', 'malawi-bishops'); ?>
                    </a>
                </div>
            </div>
        <?php
        endwhile;
        wp_reset_postdata();
        ?>
    </div>
    <?php
    else :
        // Display default hero if no posts found
    ?>
    <div class="hero-slider">
        <div class="hero-slide active" <?php echo !empty($hero_image) ? 'style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url(' . esc_url($hero_image) . ') center/cover no-repeat;"' : ''; ?>>
            <div class="hero-content-wrapper">
                <h2 class="hero-title"><?php echo esc_html($default_hero_title); ?></h2>
                <p class="hero-text"><?php echo esc_html($default_hero_text); ?></p>
                <a href="<?php echo esc_url($default_hero_button_url); ?>" class="btn hero-btn">
                    <?php echo esc_html($default_hero_button_text); ?>
                </a>
            </div>
        </div>
    </div>
    <?php
    endif;
}

/**
 * Debugging function to help identify issues
 * 
 * @param mixed $message Message to log
 */
if (!function_exists('malawi_bishops_debug_log')) {
function malawi_bishops_debug_log($message) {
    if (defined('WP_DEBUG') && WP_DEBUG === true) {
        if (is_array($message) || is_object($message)) {
            error_log(print_r($message, true));
        } else {
            error_log($message);
        }
    }
}
}

/**
 * Safe way to check if a file exists and load it
 * 
 * @param string $file File path
 * @return bool True if file was loaded, false otherwise
 */
function malawi_bishops_load_file($file) {
    if (file_exists($file)) {
        require_once $file;
        return true;
    }
    return false;
}
