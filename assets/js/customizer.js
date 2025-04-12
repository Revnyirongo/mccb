/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title a, .site-description' ).css( {
					'color': to
				} );
			}
		} );
	} );
	
	// Primary color.
	wp.customize( 'malawi_bishops_primary_color', function( value ) {
		value.bind( function( to ) {
			document.documentElement.style.setProperty('--primary-color', to);
		} );
	} );
	
	// Accent color.
	wp.customize( 'malawi_bishops_accent_color', function( value ) {
		value.bind( function( to ) {
			document.documentElement.style.setProperty('--accent-color', to);
		} );
	} );
	
	// Hero section.
	wp.customize( 'malawi_bishops_hero_title', function( value ) {
		value.bind( function( to ) {
			$( '.hero h2' ).text( to );
		} );
	} );
	
	wp.customize( 'malawi_bishops_hero_text', function( value ) {
		value.bind( function( to ) {
			$( '.hero p' ).text( to );
		} );
	} );
	
	wp.customize( 'malawi_bishops_hero_button_text', function( value ) {
		value.bind( function( to ) {
			$( '.hero .btn' ).text( to );
		} );
	} );
	
	wp.customize( 'malawi_bishops_hero_button_url', function( value ) {
		value.bind( function( to ) {
			$( '.hero .btn' ).attr( 'href', to );
		} );
	} );
	
	// Features section
	wp.customize( 'malawi_bishops_features_title', function( value ) {
		value.bind( function( to ) {
			$( '.features .section-title' ).text( to );
		} );
	} );
	
	// Copyright text
	wp.customize( 'malawi_bishops_copyright_text', function( value ) {
		value.bind( function( to ) {
			$( '.site-info' ).html( to );
		} );
	} );
	
} )( jQuery );
