/**
 * Header functionality for the Malawi Bishops theme
 * Handles sticky header, news ticker, scroll progress tracker, and corner peel effect
 */

jQuery(document).ready(function($) {
    // Sticky header
    const header = $('.site-header');
    const scrollLoader = $('.scroll-loader');
    const loaderLine = $('.loader-line');
    const progressIndicator = $('.progress-indicator');
    
    // News Ticker Enhancement
    function setupNewsTicker() {
        const tickerWrapper = $('.ticker-wrapper');
        const tickerItems = $('.ticker-item');
        
        if (tickerItems.length === 0) return;
        
        // Clone ticker items to ensure continuous scroll
        const itemsWidth = Array.from(tickerItems).reduce((width, item) => {
            return width + $(item).outerWidth(true);
        }, 0);
        
        const tickerWidth = $('.news-ticker').width();
        
        // Only clone if we need more items to fill the viewport
        if (itemsWidth < tickerWidth * 2) {
            tickerItems.clone().appendTo(tickerWrapper);
        }
        
        // Calculate animation duration based on content length
        // Longer content = slower animation for readability
        const totalWidth = tickerWrapper.width();
        const baseDuration = 20; // seconds
        const calculatedDuration = Math.max(
            baseDuration, 
            Math.min(40, totalWidth / 100)
        );
        
        // Set animation duration dynamically
        tickerWrapper.css({
            'animation-duration': calculatedDuration + 's'
        });
        
        // Pause animation on hover for better usability
        tickerWrapper.hover(
            function() { $(this).css('animation-play-state', 'paused'); },
            function() { $(this).css('animation-play-state', 'running'); }
        );
    }
    
    // Function to handle scroll events for scroll progress
    function handleScroll() {
        const scrollTop = $(window).scrollTop();
        const docHeight = $(document).height();
        const winHeight = $(window).height();
        const scrollPercent = (scrollTop / (docHeight - winHeight)) * 100;
        
        // Update the main scroll progress indicator at the top of the page
        progressIndicator.css('width', scrollPercent + '%');
        
        // Update sticky header
        if (scrollTop > 100) {
            header.addClass('scrolled');
        } else {
            header.removeClass('scrolled');
        }
        
        // Update scroll loader
        if (scrollTop > 10) {
            scrollLoader.addClass('active');
            loaderLine.css('width', scrollPercent + '%');
            
            // Also update the menu progress bar
            $('.progress-line').css('width', scrollPercent + '%');
        } else {
            scrollLoader.removeClass('active');
            $('.progress-line').css('width', '0');
        }
    }
    
    // Corner Peel Date/Time Toggle
    function setupCornerPeel() {
        const cornerPeel = $('.corner-peel');
        const dateLine = $('.current-date');
        const timeLine = $('.current-time');
        
        // Update date and time initially
        updateDateTime();
        
        // Toggle corner peel on click
        cornerPeel.on('click', function() {
            $(this).toggleClass('active');
            
            // Update date and time when opened
            if ($(this).hasClass('active')) {
                updateDateTime();
            }
        });
        
        // Update date and time every minute
        setInterval(updateDateTime, 60000);
        
        function updateDateTime() {
            const now = new Date();
            const dateOptions = { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric' };
            const timeOptions = { hour: '2-digit', minute: '2-digit' };
            
            dateLine.text(now.toLocaleDateString(undefined, dateOptions));
            timeLine.text(now.toLocaleTimeString(undefined, timeOptions));
        }
    }
    
    // Add scroll event listener
    $(window).on('scroll', handleScroll);
    
    // Initialize all components
    function init() {
        handleScroll(); // Initial call to set correct state
        setupNewsTicker();
        setupCornerPeel();
    }
    
    // Mobile menu toggle enhancement
    const menuToggle = $('.menu-toggle');
    const mainMenu = $('.main-menu');
    
    if (menuToggle.length && mainMenu.length) {
        menuToggle.on('click', function() {
            $(this).toggleClass('active');
            mainMenu.toggleClass('toggled');
            
            if (menuToggle.hasClass('active')) {
                menuToggle.attr('aria-expanded', 'true');
            } else {
                menuToggle.attr('aria-expanded', 'false');
            }
        });
    }
    
    // Enhanced responsive behavior
    function checkResponsive() {
        if ($(window).width() > 768 && mainMenu.hasClass('toggled')) {
            mainMenu.removeClass('toggled');
            menuToggle.removeClass('active');
            menuToggle.attr('aria-expanded', 'false');
        }
        
        // Re-initialize ticker on resize
        setupNewsTicker();
    }
    
    $(window).on('resize', checkResponsive);
    
    // Initialize everything
    init();
});
