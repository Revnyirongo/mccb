/**
 * Mobile Menu Toggle JavaScript
 * Ensures the mobile menu works properly
 */

document.addEventListener('DOMContentLoaded', function() {
    // Get the menu toggle button and menu element
    const menuToggle = document.querySelector('.menu-toggle');
    const mainMenu = document.querySelector('.main-menu');
    
    // Only proceed if both elements exist
    if (!menuToggle || !mainMenu) return;
    
    // Add click event to toggle menu
    menuToggle.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Toggle the menu visibility
        mainMenu.classList.toggle('toggled');
        
        // Update aria-expanded attribute
        if (mainMenu.classList.contains('toggled')) {
            menuToggle.setAttribute('aria-expanded', 'true');
        } else {
            menuToggle.setAttribute('aria-expanded', 'false');
        }
    });
    
    // Setup submenu toggles for mobile
    const menuItemsWithChildren = mainMenu.querySelectorAll('.menu-item-has-children');
    
    menuItemsWithChildren.forEach(function(item) {
        // Create toggle button
        const subMenuToggle = document.createElement('button');
        subMenuToggle.className = 'sub-menu-toggle';
        subMenuToggle.setAttribute('aria-expanded', 'false');
        subMenuToggle.innerHTML = '+';
        
        item.appendChild(subMenuToggle);
        
        // Add click event to toggle submenu
        subMenuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            
            const subMenu = item.querySelector('.sub-menu');
            if (!subMenu) return;
            
            // Toggle submenu visibility
            subMenu.classList.toggle('toggled');
            
            // Update toggle button state
            if (subMenu.classList.contains('toggled')) {
                subMenuToggle.setAttribute('aria-expanded', 'true');
                subMenuToggle.innerHTML = '-';
            } else {
                subMenuToggle.setAttribute('aria-expanded', 'false');
                subMenuToggle.innerHTML = '+';
            }
        });
    });
    
    // Close menu on window resize (for desktop)
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 992) {
            mainMenu.classList.remove('toggled');
            menuToggle.setAttribute('aria-expanded', 'false');
            
            // Reset all submenus
            document.querySelectorAll('.sub-menu.toggled').forEach(function(subMenu) {
                subMenu.classList.remove('toggled');
            });
            
            document.querySelectorAll('.sub-menu-toggle[aria-expanded="true"]').forEach(function(toggle) {
                toggle.setAttribute('aria-expanded', 'false');
                toggle.innerHTML = '+';
            });
        }
    });
});
