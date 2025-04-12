/**
 * Scroll Progress Indicator
 * Creates a progress bar at the top of the page that shows scroll position
 */

(function() {
    'use strict';
    
    // Throttle function to limit how often a function can be called
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
    
    // Get progress indicator element
    const progressIndicator = document.querySelector('.progress-indicator');
    
    if (!progressIndicator) return;
    
    // Function to update progress
    function updateProgress() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const scrollHeight = document.documentElement.scrollHeight;
        const clientHeight = document.documentElement.clientHeight;
        
        // Calculate scroll percentage
        const scrollPercentage = scrollTop / (scrollHeight - clientHeight) * 100;
        
        // Update progress indicator width
        progressIndicator.style.width = scrollPercentage + '%';
    }
    
    // Add scroll event listener with throttling for better performance
    window.addEventListener('scroll', throttle(updateProgress, 10));
    
    // Call once on page load
    updateProgress();
})();
