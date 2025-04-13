<?php
/**
 * Template part for displaying the innovative About MCCB section
 *
 * @package Malawi_Bishops
 */
?>

<section class="about-mccb-section">
    <div class="about-background"></div>
    <div class="about-decoration circle-1"></div>
    <div class="about-decoration circle-2"></div>
    
    <div class="container">
        <div class="about-wrapper">
            <!-- Left column with title and cross symbol -->
            <div class="about-left">
                <div class="cross-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C12.5523 2 13 2.44772 13 3V21C13 21.5523 12.5523 22 12 22C11.4477 22 11 21.5523 11 21V3C11 2.44772 11.4477 2 12 2Z" />
                        <path d="M3 12C3 11.4477 3.44772 11 4 11H20C20.5523 11 21 11.4477 21 12C21 12.5523 20.5523 13 20 13H4C3.44772 13 3 12.5523 3 12Z" />
                    </svg>
                </div>
                <h2 class="about-title"><?php echo esc_html__('About MCCB', 'malawi-bishops'); ?></h2>
                <div class="title-underline"></div>
                <p class="about-tagline"><?php echo esc_html__('United in faith, serving Malawi', 'malawi-bishops'); ?></p>
            </div>
            
            <!-- Right column with content -->
            <div class="about-right">
                <div class="about-content">
                    <h3><?php echo esc_html__('A Brief History of Episcopal Conference of Malawi', 'malawi-bishops'); ?></h3>
                    <p>
                        <?php echo esc_html__('Established in 1961 with approval of the Holy See, the Episcopal Conference of Malawi (ECM) has until now been an assembly of eight Catholic Dioceses of Blantyre, Chikwawa, Dedza, Karonga, Lilongwe, Mangochi, Mzuzu and Zomba.', 'malawi-bishops'); ?>
                    </p>
                    <p>
                        <?php echo esc_html__('With its mission "To bring about the kingdom of God in Malawi by teaching and promoting unity, development, justice, peace and solidarity"', 'malawi-bishops'); ?>
                    </p>
                    
                    <div class="diocese-tags">
                        <?php
                        $dioceses = array('Blantyre', 'Chikwawa', 'Dedza', 'Karonga', 'Lilongwe', 'Mangochi', 'Mzuzu', 'Zomba');
                        foreach ($dioceses as $diocese) :
                        ?>
                            <span class="diocese-tag"><?php echo esc_html($diocese); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="about-more">
                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('about-us'))); ?>" class="read-more-link">
                        <span><?php echo esc_html__('Read more about our history', 'malawi-bishops'); ?></span>
                        <svg viewBox="0 0 24 24" stroke="currentColor" fill="none">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
