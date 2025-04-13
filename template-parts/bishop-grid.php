<?php
/**
 * Template part for displaying bishops in a 5-column grid
 *
 * @package Malawi_Bishops
 */

// Get all bishops
$args = array(
    'post_type'      => 'bishop',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
);

$bishops_query = new WP_Query($args);
?>

<section class="bishops-grid-section">
    <div class="container">
        <h2 class="section-title"><?php echo esc_html__('Bishops of the Catholic Church in Malawi', 'malawi-bishops'); ?></h2>
        
        <div class="bishops-grid">
            <?php 
            if ($bishops_query->have_posts()) :
                while ($bishops_query->have_posts()) :
                    $bishops_query->the_post();
                    
                    // Get bishop meta data
                    $bishop_title = get_post_meta(get_the_ID(), '_bishop_title', true);
                    $bishop_role = get_post_meta(get_the_ID(), '_bishop_role', true);
                    
                    // Get diocese
                    $dioceses = get_the_terms(get_the_ID(), 'diocese');
                    $diocese_name = !empty($dioceses) && !is_wp_error($dioceses) ? $dioceses[0]->name : '';
                    ?>
                    
                    <div class="bishop-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="bishop-img">
                                <?php the_post_thumbnail('bishop-portrait'); ?>
                                <?php if (!empty($diocese_name)) : ?>
                                    <span class="bishop-diocese"><?php echo esc_html($diocese_name); ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="bishop-content">
                            <h3 class="bishop-name">
                                <?php 
                                if ($bishop_title) {
                                    echo esc_html($bishop_title) . ' ' . get_the_title();
                                } else {
                                    the_title();
                                }
                                ?>
                            </h3>
                            <?php if ($bishop_role) : ?>
                                <p class="bishop-role"><?php echo esc_html($bishop_role); ?></p>
                            <?php endif; ?>
                            
                            <a href="<?php the_permalink(); ?>" class="bishop-link"><span class="screen-reader-text"><?php echo esc_html__('Read more about', 'malawi-bishops'); ?> <?php the_title(); ?></span></a>
                        </div>
                    </div>
                    
                <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p>' . esc_html__('No bishops found.', 'malawi-bishops') . '</p>';
            endif;
            ?>
        </div>
    </div>
</section>
