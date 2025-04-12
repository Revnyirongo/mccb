/**
 * Smooth Scroll Progress Indicator
 * This script creates a smooth scroll progress indicator at the top of the page
 */

(function() {
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
// Hide corner peel on scroll for mobile
(function() {
    const cornerPeel = document.querySelector('.corner-peel');
    let scrollTimer;
    let lastScrollTop = 0;
    
    function handleScroll() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        // Only handle this on mobile screens
        if (window.innerWidth <= 768) {
            // If user has scrolled down more than 100px, hide the corner peel
            if (scrollTop > 100) {
                cornerPeel.classList.add('hidden');
            } else {
                cornerPeel.classList.remove('hidden');
            }
            
            // If the corner peel is active (flipped), close it when scrolling down
            if (cornerPeel.classList.contains('active') && scrollTop > lastScrollTop) {
                cornerPeel.classList.remove('active');
            }
        }
        
        lastScrollTop = scrollTop;
    }
    
    window.addEventListener('scroll', function() {
        clearTimeout(scrollTimer);
        handleScroll();
        
        // Set a timeout to handle scroll end
        scrollTimer = setTimeout(function() {
            // If user has scrolled back to the top, show the corner peel again
            if ((window.pageYOffset || document.documentElement.scrollTop) <= 100) {
                cornerPeel.classList.remove('hidden');
            }
        }, 150);
    });
})();
