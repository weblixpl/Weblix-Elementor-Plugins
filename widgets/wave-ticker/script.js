( function () {
	'use strict';

	function initWaveTicker( el ) {
		if ( el.dataset.weblixInit ) return;
		el.dataset.weblixInit = '1';

		const config        = JSON.parse( el.dataset.config || '{}' );
		const scrollSpeed   = config.scrollSpeed   || 80;
		const waveAmplitude = config.waveAmplitude || 12;
		const waveFrequency = config.waveFrequency || 0.35;
		const waveSpeed     = config.waveSpeed     || 2;
		const gap           = config.gap           || 0;

		const track    = el.querySelector( '.weblix-wave-ticker__track' );
		const original = el.querySelector( '.weblix-wave-ticker__text' );

		// \p{Emoji_Presentation} = znaki domyślnie renderowane jako kolorowe emoji
		// \p{Extended_Pictographic} jest za szeroki (obejmuje też zwykłe symbole tekstowe)
		const reEmoji     = /\p{Emoji_Presentation}/u;
		// Variation selectors, ZWJ, zero-width chars — skip as standalone segments
		const reInvisible = /^[\uFE00-\uFE0F\u200B-\u200F\u2028\u2029\uFEFF\u00AD]+$/;

		function makeCharSpan( ch ) {
			const s       = document.createElement( 'span' );
			const isEmoji = reEmoji.test( ch );
			s.className   = 'weblix-wave-ticker__char' + ( isEmoji ? ' weblix-wave-ticker__emoji' : '' );
			if ( isEmoji ) {
				// Store emoji in data attribute — WP emoji MutationObserver only watches text nodes,
				// so this bypasses the <img> conversion entirely. Rendered via CSS ::before.
				s.setAttribute( 'data-emoji', ch );
			} else {
				s.textContent = ch === ' ' ? '\u00A0' : ch;
			}
			return s;
		}


		// Wrap each character in a <span>
		// Text comes from data-text attribute to bypass WordPress emoji <img> conversion
		function wrapChars( span ) {
			const text = span.dataset.text || span.textContent;

			// Remove all existing children safely
			while ( span.firstChild ) {
				span.removeChild( span.firstChild );
			}

			const segments = typeof Intl !== 'undefined' && Intl.Segmenter
				? [ ...new Intl.Segmenter( undefined, { granularity: 'grapheme' } ).segment( text ) ].map( s => s.segment )
				: [ ...text ];

			segments
				.filter( ( ch ) => ! reInvisible.test( ch ) )
				.forEach( ( ch ) => span.appendChild( makeCharSpan( ch ) ) );
		}

		wrapChars( original );
		original.style.marginRight = gap + 'px';

		// Remove any extra copies rendered by PHP (keep only first)
		track.querySelectorAll( '.weblix-wave-ticker__text:not(:first-child)' )
			.forEach( ( n ) => n.remove() );

		let scrollX      = 0;
		let lastTime     = null;
		let oneWidth     = 0;
		let ready        = false;
		let charXCache   = null; // pre-calculated X positions for spatial wave

		function buildClones() {
			const containerWidth = el.offsetWidth;
			oneWidth = original.getBoundingClientRect().width + gap;

			if ( oneWidth === 0 ) return;

			const needed = Math.ceil( ( containerWidth * 2 ) / oneWidth ) + 1;

			track.querySelectorAll( '.weblix-wave-ticker__clone' )
				.forEach( ( n ) => n.remove() );

			for ( let i = 0; i < needed; i++ ) {
				const clone = original.cloneNode( true );
				clone.classList.add( 'weblix-wave-ticker__clone' );
				clone.setAttribute( 'aria-hidden', 'true' );
				track.appendChild( clone );
			}

			// Pre-calculate each char's X position within the track (for spatial wave)
			// One RAF delay so layout is settled before measuring
			charXCache = null;
			ready = true;
		}

		function buildCharXCache() {
			const allChars = track.querySelectorAll( '.weblix-wave-ticker__char' );
			const trackLeft = track.getBoundingClientRect().left;
			charXCache = Array.from( allChars ).map( ( char ) => ( {
				el : char,
				x  : char.getBoundingClientRect().left - trackLeft,
			} ) );
		}

		function tick( now ) {
			if ( ! ready ) {
				buildClones();
				if ( ! ready ) {
					requestAnimationFrame( tick );
					return;
				}
			}

			// Build position cache on first frame after clones are ready
			if ( ! charXCache ) {
				buildCharXCache();
			}

			if ( lastTime === null ) lastTime = now;
			const dt = ( now - lastTime ) / 1000;
			lastTime = now;

			scrollX += scrollSpeed * dt;
			if ( scrollX >= oneWidth ) {
				scrollX -= oneWidth;
			}
			track.style.transform = `translateX(-${ scrollX }px)`;

			// Spatial wave: phase based on char's screen X position
			// so neighbouring letters share the same phase → whole words flow together
			const time        = now / 1000;
			const spatialFreq = waveFrequency * 0.008; // radians per pixel (tune via control)

			charXCache.forEach( ( { el, x } ) => {
				const screenX = x - scrollX;
				const phase   = screenX * spatialFreq - time * waveSpeed;
				const y       = Math.sin( phase ) * waveAmplitude;
				el.style.transform = `translateY(${ y }px)`;
			} );

			requestAnimationFrame( tick );
		}

		// Rebuild clones on resize
		window.addEventListener( 'resize', () => {
			ready = false;
		} );

		requestAnimationFrame( tick );
	}

	function initAll() {
		document.querySelectorAll( '.weblix-wave-ticker:not([data-weblix-init])' )
			.forEach( initWaveTicker );
	}

	document.addEventListener( 'DOMContentLoaded', initAll );

	window.addEventListener( 'elementor/frontend/init', function () {
		if ( window.elementorFrontend ) {
			elementorFrontend.hooks.addAction(
				'frontend/element_ready/weblix-wave-ticker.default',
				function ( $scope ) {
					const el = $scope[0].querySelector( '.weblix-wave-ticker:not([data-weblix-init])' );
					if ( el ) initWaveTicker( el );
				}
			);
		}
	} );
} )();
