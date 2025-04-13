<?php
/**
 * Template part for displaying upcoming events with a call to action
 *
 * @package Malawi_Bishops
 */

// Get upcoming events
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

$events_query = new WP_Query($args);
?>

<section class="events-cta-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><?php echo esc_html__('Upcoming Events', 'malawi-bishops'); ?></h2>
            <div class="title-underline"></div>
        </div>
        
        <div class="events-cta-wrapper">
            <!-- Events column -->
            <div class="events-column">
                <?php if ($events_query->have_posts()) : ?>
                    <div class="events-list">
                        <?php while ($events_query->have_posts()) : $events_query->the_post(); 
                            // Get event meta
                            $start_date = get_post_meta(get_the_ID(), '_event_start_date', true);
                            $location = get_post_meta(get_the_ID(), '_event_location', true);
                            
                            // Format date
                            $date_obj = new DateTime($start_date);
                            $month = $date_obj->format('M');
                            $day = $date_obj->format('d');
                        ?>
                            <div class="event-card">
                                <div class="event-date-column">
                                    <div class="event-day"><?php echo esc_html($day); ?></div>
                                    <div class="event-month"><?php echo esc_html($month); ?></div>
                                </div>
                                
                                <div class="event-content-column">
                                    <h3 class="event-title"><?php the_title(); ?></h3>
                                    <?php if ($location) : ?>
                                        <div class="event-location">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 2C15.87 2 19 5.13 19 9C19 14.25 12 22 12 22C12 22 5 14.25 5 9C5 5.13 8.13 2 12 2ZM12 4C9.24 4 7 6.24 7 9C7 10 7 12 12 18.71C17 12 17 10 17 9C17 6.24 14.76 4 12 4ZM12 6C13.66 6 15 7.34 15 9C15 10.66 13.66 12 12 12C10.34 12 9 10.66 9 9C9 7.34 10.34 6 12 6Z" />
                                            </svg>
                                            <span><?php echo esc_html($location); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="event-excerpt"><?php the_excerpt(); ?></div>
                                    <a href="<?php the_permalink(); ?>" class="event-details-link">
                                        <span><?php echo esc_html__('View Details', 'malawi-bishops'); ?></span>
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                    
                    <div class="view-all-events">
                        <a href="<?php echo get_post_type_archive_link('event'); ?>" class="view-all-link">
                            <span><?php echo esc_html__('View All Events', 'malawi-bishops'); ?></span>
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                <?php else : ?>
                    <p><?php echo esc_html__('No upcoming events found.', 'malawi-bishops'); ?></p>
                <?php endif; ?>
            </div>
            
            <!-- Call to Action column -->
            <div class="cta-column">
                <div class="cta-box">
                    <div class="cta-icon">
                        <svg fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 4H4C2.9 4 2 4.9 2 6V18C2 19.1 2.9 20 4 20H20C21.1 20 22 19.1 22 18V6C22 4.9 21.1 4 20 4ZM20 18H4V8L12 13L20 8V18ZM12 11L4 6H20L12 11Z" />
                        </svg>
                    </div>
                    <h3 class="cta-title"><?php echo esc_html__('Stay Informed', 'malawi-bishops'); ?></h3>
                    <p class="cta-text"><?php echo esc_html__('Subscribe to our newsletter for the latest news, events, and announcements from the Malawi Conference of Catholic Bishops.', 'malawi-bishops'); ?></p>
                    
                    <!-- Newsletter signup form - replace with your form shortcode if needed -->
                    <form class="cta-form">
                        <div class="form-field">
                            <input type="text" name="name" placeholder="<?php echo esc_attr__('Your Full Name', 'malawi-bishops'); ?>" required>
                        </div>
                        <div class="form-field">
                            <input type="email" name="email" placeholder="<?php echo esc_attr__('Your Email Address', 'malawi-bishops'); ?>" required>
                        </div>
                        <div class="form-field">
                            <select name="diocese">
                                <option value=""><?php echo esc_html__('Select Your Diocese', 'malawi-bishops'); ?></option>
                                <option value="blantyre"><?php echo esc_html__('Blantyre', 'malawi-bishops'); ?></option>
                                <option value="chikwawa"><?php echo esc_html__('Chikwawa', 'malawi-bishops'); ?></option>
                                <option value="dedza"><?php echo esc_html__('Dedza', 'malawi-bishops'); ?></option>
                                <option value="karonga"><?php echo esc_html__('Karonga', 'malawi-bishops'); ?></option>
                                <option value="lilongwe"><?php echo esc_html__('Lilongwe', 'malawi-bishops'); ?></option>
                                <option value="mangochi"><?php echo esc_html__('Mangochi', 'malawi-bishops'); ?></option>
                                <option value="mzuzu"><?php echo esc_html__('Mzuzu', 'malawi-bishops'); ?></option>
                                <option value="zomba"><?php echo esc_html__('Zomba', 'malawi-bishops'); ?></option>
                            </select>
                        </div>
                        <button type="submit" class="cta-button"><?php echo esc_html__('Subscribe Now', 'malawi-bishops'); ?></button>
                    </form>
                    
                    <div class="cta-footer">
                        <p><?php echo esc_html__('Join our community of believers across Malawi', 'malawi-bishops'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
