/**
 * Custom JavaScript for the Malawi Bishops Theme
 * Contains scripts for the Corner Peel date/time display and other enhancements
 */

(function($) {
    'use strict';
    
    // DOM Ready
    $(document).ready(function() {
        setupCornerPeel();
        initScrollProgress();
    });
    
    /**
     * Corner Peel Date/Time Toggle
     */
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
    
    /**
     * Scroll Progress Tracker
     */
    function initScrollProgress() {
        const progressIndicator = $('.progress-indicator');
        
        if (!progressIndicator.length) return;
        
        // Function to update progress
        function updateProgress() {
            const scrollTop = $(window).scrollTop();
            const scrollHeight = $(document).height();
            const clientHeight = $(window).height();
            
            // Calculate scroll percentage
            const scrollPercentage = scrollTop / (scrollHeight - clientHeight) * 100;
            
            // Update progress indicator width
            progressIndicator.css('width', scrollPercentage + '%');
        }
        
        // Add scroll event listener with throttling for better performance
        $(window).on('scroll', throttle(updateProgress, 10));
        
        // Call once on page load
        updateProgress();
    }
    
    /**
     * Throttle function to limit how often a function can be called
     */
    function throttle(callback, limit) {
        let waiting = false;
        return function() {
            if (!waiting) {
                callback.apply(this, arguments);
                waiting = true;
                setTimeout(function() {
                    waiting = false;
                }, limit);
            }
        };
    }
    
    /**
     * Fix for sticky header on mobile
     */
    function setupStickyHeader() {
        const header = $('.site-header');
        
        if (!header.length) return;
        
        const headerHeight = header.outerHeight();
        
        function handleScroll() {
            const scrollTop = $(window).scrollTop();
            
            if (scrollTop > headerHeight) {
                header.addClass('scrolled');
                $('body').css('padding-top', headerHeight + 'px');
            } else {
                header.removeClass('scrolled');
                $('body').css('padding-top', '0');
            }
        }
        
        // Only enable on screens larger than 768px
        function checkResponsive() {
            if ($(window).width() > 768) {
                $(window).on('scroll', throttle(handleScroll, 10));
                handleScroll(); // Initial call
            } else {
                $(window).off('scroll', handleScroll);
                header.removeClass('scrolled');
                $('body').css('padding-top', '0');
            }
        }
        
        // Initial check
        checkResponsive();
        
        // On window resize
        $(window).on('resize', checkResponsive);
    }
    
    /**
     * Initialize on document ready
     */
    $(function() {
        setupCornerPeel();
        initScrollProgress();
        setupStickyHeader();
    });
    
})(jQuery);
