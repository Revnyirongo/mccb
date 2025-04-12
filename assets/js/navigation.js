/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function() {
	const menuToggle = document.querySelector( '.menu-toggle' );
	const mainMenu = document.querySelector( '.main-menu' );
	
	if ( ! menuToggle || ! mainMenu ) {
		return;
	}
	
	// Toggle mobile menu
	menuToggle.addEventListener( 'click', function() {
		mainMenu.classList.toggle( 'toggled' );
		if ( menuToggle.getAttribute( 'aria-expanded' ) === 'true' ) {
			menuToggle.setAttribute( 'aria-expanded', 'false' );
		} else {
			menuToggle.setAttribute( 'aria-expanded', 'true' );
		}
	} );
	
	// Setup sub-menu toggles for mobile view
	const subMenus = mainMenu.querySelectorAll( '.sub-menu' );
	const subMenuToggles = [];
	
	subMenus.forEach( function( subMenu ) {
		const parentItem = subMenu.parentElement;
		const parentLink = parentItem.querySelector( 'a' );
		
		// Create a button to toggle the sub-menu
		const toggle = document.createElement( 'button' );
		toggle.className = 'sub-menu-toggle';
		toggle.setAttribute( 'aria-expanded', 'false' );
		toggle.innerHTML = '<span class="screen-reader-text">Toggle Sub-menu</span>';
		
		parentItem.insertBefore( toggle, subMenu );
		subMenuToggles.push( toggle );
		
		// Toggle sub-menu when clicked
		toggle.addEventListener( 'click', function() {
			subMenu.classList.toggle( 'toggled' );
			if ( toggle.getAttribute( 'aria-expanded' ) === 'true' ) {
				toggle.setAttribute( 'aria-expanded', 'false' );
			} else {
				toggle.setAttribute( 'aria-expanded', 'true' );
			}
		} );
	} );
	
	// Add accessibility support for keyboard navigation
	const links = mainMenu.getElementsByTagName( 'a' );
	
	Array.prototype.forEach.call( links, function( link ) {
		link.addEventListener( 'focus', toggleFocus, true );
		link.addEventListener( 'blur', toggleFocus, true );
	} );
	
	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {
		let self = this;
		
		// Move up through the ancestors of the current link until we hit .main-menu.
		while ( ! self.classList.contains( 'main-menu' ) ) {
			// If we're on a link in a submenu, add focus class to parent item.
			if ( self.classList.contains( 'sub-menu' ) ) {
				self.classList.toggle( 'focus' );
			}
			
			self = self.parentElement;
			
			if ( ! self ) {
				break;
			}
		}
	}
	
	// Ensure proper display of menu on window resize
	window.addEventListener( 'resize', function() {
		if ( window.innerWidth > 768 ) {
			mainMenu.classList.remove( 'toggled' );
			menuToggle.setAttribute( 'aria-expanded', 'false' );
			
			// Reset sub-menus on resize
			subMenus.forEach( function( subMenu ) {
				subMenu.classList.remove( 'toggled' );
			} );
			
			subMenuToggles.forEach( function( toggle ) {
				toggle.setAttribute( 'aria-expanded', 'false' );
			} );
		}
	} );
} )();
/**
 * Add this code to your existing navigation.js file
 * This handles the sticky header animation and search functionality
 */

// Sticky header functionality
( function() {
    // Get header element
    const header = document.querySelector('.site-header');
    const searchToggle = document.querySelector('.search-toggle');
    const searchContainer = document.querySelector('.search-form-container');
    
    if (header) {
        // Function to handle scroll events
        function handleScroll() {
            if (window.scrollY > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        }
        
        // Add scroll event listener
        window.addEventListener('scroll', handleScroll);
        
        // Initial call to set correct state
        handleScroll();
    }
    
    // Handle search toggle
    if (searchToggle && searchContainer) {
        searchToggle.addEventListener('click', function(e) {
            e.preventDefault();
            searchContainer.classList.toggle('active');
            
            if (searchContainer.classList.contains('active')) {
                searchToggle.setAttribute('aria-expanded', 'true');
                // Focus the search input
                const searchInput = searchContainer.querySelector('input[type="search"]');
                if (searchInput) {
                    setTimeout(function() {
                        searchInput.focus();
                    }, 100);
                }
            } else {
                searchToggle.setAttribute('aria-expanded', 'false');
            }
        });
        
        // Close search when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchToggle.contains(e.target) && !searchContainer.contains(e.target)) {
                searchContainer.classList.remove('active');
                searchToggle.setAttribute('aria-expanded', 'false');
            }
        });
        
        // Close search on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && searchContainer.classList.contains('active')) {
                searchContainer.classList.remove('active');
                searchToggle.setAttribute('aria-expanded', 'false');
                searchToggle.focus();
            }
        });
    }
} )();
