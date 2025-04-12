/**
 * Hero Slider Functionality
 * Creates a smooth sliding effect for featured posts in the hero section
 */

(function($) {
    'use strict';
    
    const HeroSlider = {
        /**
         * Initialize the hero slider
         */
        init: function() {
            const $slider = $('.hero-slider');
            
            if ($slider.length === 0) return;
            
            // Setup variables
            this.$slider = $slider;
            this.$slides = $slider.find('.hero-slide');
            this.slideCount = this.$slides.length;
            this.currentSlide = 0;
            this.interval = null;
            
            // Don't proceed if no slides
            if (this.slideCount <= 1) return;
            
            // Create navigation dots
            this.createNavigation();
            
            // Set initial state
            this.$slides.removeClass('active').eq(0).addClass('active');
            this.$navDots.removeClass('active').eq(0).addClass('active');
            
            // Start the slider
            this.startSlider();
            
            // Add event listeners
            this.bindEvents();
            
            // Add accessibility attributes
            this.setupAccessibility();
        },
        
        /**
         * Create navigation dots for the slider
         */
        createNavigation: function() {
            const $nav = $('<div class="hero-nav"></div>');
            
            // Create dots
            for (let i = 0; i < this.slideCount; i++) {
                $nav.append(`<button class="hero-nav-dot" data-slide="${i}" aria-label="Go to slide ${i+1}"></button>`);
            }
            
            // Add navigation to slider
            this.$slider.append($nav);
            
            // Store reference to dots
            this.$navDots = $nav.find('.hero-nav-dot');
        },
        
        /**
         * Bind event listeners
         */
        bindEvents: function() {
            // Navigation dots click
            this.$navDots.on('click', (e) => {
                const slideIndex = $(e.currentTarget).data('slide');
                this.goToSlide(slideIndex);
                this.resetInterval();
            });
            
            // Pause on hover
            this.$slider.on('mouseenter', () => this.pauseSlider());
            this.$slider.on('mouseleave', () => this.startSlider());
            
            // Add swipe support for mobile
            this.setupSwipe();
            
            // Handle resize events
            $(window).on('resize', this.handleResize.bind(this));
        },
        
        /**
         * Setup swipe functionality for mobile
         */
        setupSwipe: function() {
            let startX, endX;
            const threshold = 50; // Minimum distance to be considered a swipe
            
            this.$slider.on('touchstart', (e) => {
                startX = e.originalEvent.touches[0].clientX;
            });
            
            this.$slider.on('touchend', (e) => {
                endX = e.originalEvent.changedTouches[0].clientX;
                
                // Calculate swipe distance
                const distance = endX - startX;
                
                // If the swipe is long enough
                if (Math.abs(distance) >= threshold) {
                    if (distance > 0) {
                        // Swipe right - go to previous slide
                        this.prevSlide();
                    } else {
                        // Swipe left - go to next slide
                        this.nextSlide();
                    }
                    
                    this.resetInterval();
                }
            });
        },
        
        /**
         * Handle window resize events
         */
        handleResize: function() {
            // Adjust any necessary styles for different screen sizes
            const windowWidth = $(window).width();
            
            // Adjust slide height on smaller screens
            if (windowWidth < 768) {
                // Mobile optimizations
            } else {
                // Desktop defaults
            }
        },
        
        /**
         * Add accessibility support
         */
        setupAccessibility: function() {
            // Set ARIA attributes for better accessibility
            this.$slider.attr('aria-roledescription', 'carousel');
            this.$slider.attr('aria-live', 'polite');
            
            this.$slides.each((index, slide) => {
                $(slide).attr('aria-roledescription', 'slide');
                $(slide).attr('aria-label', `Slide ${index + 1} of ${this.slideCount}`);
                $(slide).attr('role', 'group');
            });
        },
        
        /**
         * Start the automatic slider
         */
        startSlider: function() {
            // Clear any existing interval
            this.pauseSlider();
            
            // Set new interval (change slide every 5 seconds)
            this.interval = setInterval(() => {
                this.nextSlide();
            }, 5000);
        },
        
        /**
         * Pause the automatic slider
         */
        pauseSlider: function() {
            if (this.interval) {
                clearInterval(this.interval);
                this.interval = null;
            }
        },
        
        /**
         * Reset the interval timer
         */
        resetInterval: function() {
            this.pauseSlider();
            this.startSlider();
        },
        
        /**
         * Go to the next slide
         */
        nextSlide: function() {
            let nextSlide = this.currentSlide + 1;
            
            // Loop back to first slide if at the end
            if (nextSlide >= this.slideCount) {
                nextSlide = 0;
            }
            
            this.goToSlide(nextSlide);
        },
        
        /**
         * Go to the previous slide
         */
        prevSlide: function() {
            let prevSlide = this.currentSlide - 1;
            
            // Loop to last slide if at the beginning
            if (prevSlide < 0) {
                prevSlide = this.slideCount - 1;
            }
            
            this.goToSlide(prevSlide);
        },
        
        /**
         * Go to a specific slide
         */
        goToSlide: function(index) {
            // Don't proceed if already on this slide
            if (index === this.currentSlide) return;
            
            // Get current and next slides
            const $current = this.$slides.eq(this.currentSlide);
            const $next = this.$slides.eq(index);
            
            // Determine animation direction (left or right)
            const direction = index > this.currentSlide ? 'right' : 'left';
            
            // Remove current classes
            $current.removeClass('active');
            this.$navDots.eq(this.currentSlide).removeClass('active');
            
            // Add animation classes
            $next.addClass(`active from-${direction}`);
            this.$navDots.eq(index).addClass('active');
            
            // Update current slide index
            this.currentSlide = index;
            
            // Remove animation classes after transition completes
            setTimeout(() => {
                $next.removeClass(`from-${direction}`);
            }, 600);
        }
    };
    
    // Initialize on document ready
    $(document).ready(function() {
        HeroSlider.init();
    });
    
})(jQuery);
