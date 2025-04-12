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
		// Hero Section with Dynamic Content from Front Page Category
		$args = array(
			'category_name' => 'front-page',
			'posts_per_page' => 1,
			'orderby' => 'date',
			'order' => 'DESC'
		);

		$hero_query = new WP_Query($args);

		// Default hero content from theme customizer
		$default_hero_title = get_theme_mod('malawi_bishops_hero_title', 'Serving the Church in Malawi');
		$default_hero_text = get_theme_mod('malawi_bishops_hero_text', 'Proclaiming the Gospel, promoting human dignity, and building a civilization of love');
		$default_hero_button_text = get_theme_mod('malawi_bishops_hero_button_text', 'Learn More');
		$default_hero_button_url = get_theme_mod('malawi_bishops_hero_button_url', '#');
		$hero_image = get_theme_mod('malawi_bishops_hero_image', '');

		// Variables for hero content
		$hero_title = $default_hero_title;
		$hero_text = $default_hero_text;
		$hero_button_text = $default_hero_button_text;
		$hero_button_url = $default_hero_button_url;
		$hero_style = '';

		// If we have a post from the front-page category
		if ($hero_query->have_posts()) {
			while ($hero_query->have_posts()) {
				$hero_query->the_post();
				
				// Override with post content if available
				$hero_title = get_the_title();
				
				// Use excerpt if available, otherwise generate from content
				if (has_excerpt()) {
					$hero_text = get_the_excerpt();
				} else {
					$hero_text = wp_trim_words(get_the_content(), 25, '...');
				}
				
				$hero_button_text = esc_html__('Read More', 'malawi-bishops');
				$hero_button_url = get_permalink();
				
				// Use featured image if available
				if (has_post_thumbnail()) {
					$hero_image_array = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
					if ($hero_image_array) {
						$hero_image = $hero_image_array[0];
					}
				}
			}
			wp_reset_postdata();
		}

		if ($hero_image) {
			$hero_style = 'background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url(' . esc_url($hero_image) . ') center/cover no-repeat;';
		}
		?>

		<section class="hero" style="<?php echo esc_attr($hero_style); ?>">
			<div class="hero-content-wrapper">
				<div class="container">
					<?php if ($hero_title) : ?>
						<h2 class="hero-title"><?php echo esc_html($hero_title); ?></h2>
					<?php endif; ?>
					
					<?php if ($hero_text) : ?>
						<p class="hero-text"><?php echo esc_html($hero_text); ?></p>
					<?php endif; ?>
					
					<?php if ($hero_button_text && $hero_button_url) : ?>
						<a href="<?php echo esc_url($hero_button_url); ?>" class="btn hero-btn">
							<?php echo esc_html($hero_button_text); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</section>
		
		<?php
		// Features Section (Our Mission)
		$show_features = get_theme_mod( 'malawi_bishops_show_features', true );
		if ( $show_features ) :
			$features_title = get_theme_mod( 'malawi_bishops_features_title', 'Our Mission' );
		?>
		
		<section class="section">
			<div class="container">
				<?php if ( $features_title ) : ?>
					<h2 class="section-title"><?php echo esc_html( $features_title ); ?></h2>
				<?php endif; ?>
				
				<div class="features-grid">
					<?php
					// Feature 1
					$feature1_title = get_theme_mod( 'malawi_bishops_feature1_title', 'Evangelization' );
					$feature1_text = get_theme_mod( 'malawi_bishops_feature1_text', 'Proclaiming the Good News of salvation in Jesus Christ to all people in Malawi and fostering spiritual growth among the faithful.' );
					$feature1_image = get_theme_mod( 'malawi_bishops_feature1_image', '' );
					
					// Feature 2
					$feature2_title = get_theme_mod( 'malawi_bishops_feature2_title', 'Justice and Peace' );
					$feature2_text = get_theme_mod( 'malawi_bishops_feature2_text', 'Promoting human dignity, advocating for social justice, and working towards peace and reconciliation in our society.' );
					$feature2_image = get_theme_mod( 'malawi_bishops_feature2_image', '' );
					
					// Feature 3
					$feature3_title = get_theme_mod( 'malawi_bishops_feature3_title', 'Education' );
					$feature3_text = get_theme_mod( 'malawi_bishops_feature3_text', 'Supporting Catholic education and formation at all levels to nurture faith, intellect, and character in future generations.' );
					$feature3_image = get_theme_mod( 'malawi_bishops_feature3_image', '' );
					?>
					
					<div class="feature-card">
						<div class="feature-img">
							<?php if ( $feature1_image ) : ?>
								<img src="<?php echo esc_url( $feature1_image ); ?>" alt="<?php echo esc_attr( $feature1_title ); ?>">
							<?php else : ?>
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/placeholder.jpg' ); ?>" alt="<?php echo esc_attr( $feature1_title ); ?>">
							<?php endif; ?>
						</div>
						<div class="feature-content">
							<h3><?php echo esc_html( $feature1_title ); ?></h3>
							<p><?php echo esc_html( $feature1_text ); ?></p>
						</div>
					</div>
					
					<div class="feature-card">
						<div class="feature-img">
							<?php if ( $feature2_image ) : ?>
								<img src="<?php echo esc_url( $feature2_image ); ?>" alt="<?php echo esc_attr( $feature2_title ); ?>">
							<?php else : ?>
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/placeholder.jpg' ); ?>" alt="<?php echo esc_attr( $feature2_title ); ?>">
							<?php endif; ?>
						</div>
						<div class="feature-content">
							<h3><?php echo esc_html( $feature2_title ); ?></h3>
							<p><?php echo esc_html( $feature2_text ); ?></p>
						</div>
					</div>
					
					<div class="feature-card">
						<div class="feature-img">
							<?php if ( $feature3_image ) : ?>
								<img src="<?php echo esc_url( $feature3_image ); ?>" alt="<?php echo esc_attr( $feature3_title ); ?>">
							<?php else : ?>
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/placeholder.jpg' ); ?>" alt="<?php echo esc_attr( $feature3_title ); ?>">
							<?php endif; ?>
						</div>
						<div class="feature-content">
							<h3><?php echo esc_html( $feature3_title ); ?></h3>
							<p><?php echo esc_html( $feature3_text ); ?></p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php endif; ?>
		
		<?php
		// News Section
		$show_news = get_theme_mod( 'malawi_bishops_show_news', true );
		if ( $show_news ) :
			$news_title = get_theme_mod( 'malawi_bishops_news_title', 'Latest News' );
			$news_count = get_theme_mod( 'malawi_bishops_news_count', 3 );
		?>
		
		<section class="section news-section">
			<div class="container">
				<?php if ( $news_title ) : ?>
					<h2 class="section-title"><?php echo esc_html( $news_title ); ?></h2>
				<?php endif; ?>
				
				<div class="news-grid">
					<?php
					$args = array(
						'post_type'      => 'post',
						'posts_per_page' => absint( $news_count ),
                        'category__not_in' => array(get_cat_ID('front-page')), // Exclude front-page category posts
					);
					
					$news_query = new WP_Query( $args );
					
					if ( $news_query->have_posts() ) :
						while ( $news_query->have_posts() ) :
							$news_query->the_post();
							?>
							<div class="news-card">
								<?php if ( has_post_thumbnail() ) : ?>
									<div class="news-img">
										<?php the_post_thumbnail(); ?>
									</div>
								<?php endif; ?>
								
								<div class="news-content">
									<div class="news-date"><?php echo get_the_date(); ?></div>
									<h3><?php the_title(); ?></h3>
									<?php the_excerpt(); ?>
									<a href="<?php the_permalink(); ?>" class="read-more"><?php esc_html_e( 'Read More', 'malawi-bishops' ); ?></a>
								</div>
							</div>
							<?php
						endwhile;
						wp_reset_postdata();
					else :
						?>
						<p><?php esc_html_e( 'No news posts found.', 'malawi-bishops' ); ?></p>
						<?php
					endif;
					?>
				</div>
			</div>
		</section>
		<?php endif; ?>
		
		<?php
		// Bishops Section
		$show_bishops = get_theme_mod( 'malawi_bishops_show_bishops', true );
		if ( $show_bishops ) :
			$bishops_title = get_theme_mod( 'malawi_bishops_bishops_title', 'Our Bishops' );
			$bishops_count = get_theme_mod( 'malawi_bishops_bishops_count', 8 );
		?>
		
		<section class="section bishops">
			<div class="container">
				<?php if ( $bishops_title ) : ?>
					<h2 class="section-title"><?php echo esc_html( $bishops_title ); ?></h2>
				<?php endif; ?>
				
				<div class="bishops-grid">
					<?php
					$args = array(
						'post_type'      => 'bishop',
						'posts_per_page' => absint( $bishops_count ),
					);
					
					$bishops_query = new WP_Query( $args );
					
					if ( $bishops_query->have_posts() ) :
						while ( $bishops_query->have_posts() ) :
							$bishops_query->the_post();
							get_template_part( 'template-parts/content', 'bishop' );
						endwhile;
						wp_reset_postdata();
					else :
						?>
						<p><?php esc_html_e( 'No bishops found.', 'malawi-bishops' ); ?></p>
						<?php
					endif;
					?>
				</div>
			</div>
		</section>
		<?php endif; ?>
		
		<?php
		// Events Section
		$show_events = get_theme_mod( 'malawi_bishops_show_events', true );
		if ( $show_events ) :
			$events_title = get_theme_mod( 'malawi_bishops_events_title', 'Upcoming Events' );
			$events_count = get_theme_mod( 'malawi_bishops_events_count', 3 );
		?>
		
		<section class="section events">
			<div class="container">
				<?php if ( $events_title ) : ?>
					<h2 class="section-title"><?php echo esc_html( $events_title ); ?></h2>
				<?php endif; ?>
				
				<div class="events-list">
					<?php
					$today = date('Y-m-d');
					$args = array(
						'post_type'      => 'event',
						'posts_per_page' => absint( $events_count ),
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
					
					$events_query = new WP_Query( $args );
					
					if ( $events_query->have_posts() ) :
						while ( $events_query->have_posts() ) :
							$events_query->the_post();
							get_template_part( 'template-parts/content', 'event' );
						endwhile;
						wp_reset_postdata();
					else :
						?>
						<p><?php esc_html_e( 'No upcoming events found.', 'malawi-bishops' ); ?></p>
						<?php
					endif;
					?>
				</div>
			</div>
		</section>
		<?php endif; ?>
		
		<?php
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
