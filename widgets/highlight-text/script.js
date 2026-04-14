( function () {
	'use strict';

	var ANIM_CLASS_RE = /^weblix-hl--anim-.+$/;

	function randomizeDelays( root ) {
		root.querySelectorAll( '.weblix-hl' ).forEach( function ( el ) {
			var isAnimated = Array.from( el.classList ).some( function ( c ) {
				return ANIM_CLASS_RE.test( c );
			} );
			if ( ! isAnimated ) return;

			var speed = parseFloat( getComputedStyle( el ).getPropertyValue( '--hl-anim-speed' ) ) || 2;
			el.style.animationDelay = '-' + ( Math.random() * speed ).toFixed( 3 ) + 's';
		} );
	}

	// Frontend: page load
	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', function () {
			randomizeDelays( document );
		} );
	} else {
		randomizeDelays( document );
	}

	// Elementor editor: widget re-render
	window.addEventListener( 'load', function () {
		if ( ! window.elementorFrontend ) return;
		window.elementorFrontend.hooks.addAction(
			'frontend/element_ready/weblix-highlight-text.default',
			function ( $scope ) {
				randomizeDelays( $scope[ 0 ] );
			}
		);
	} );
} )();
