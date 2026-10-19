/**
 * boxesFx.js v1.0.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Copyright 2014, Codrops
 * http://www.codrops.com
 */
;( function( window, $ ) {

	'use strict';

	var body = $('body');
	// based on http://responsejs.com/labs/dimensions/

	var docElem = window.document.documentElement,
		transEndEventName = 'transitionend webkittransitionend';

	function getViewport(axis) {
		var client, inner;
		if( axis === 'x' ) {
			client = docElem.clientWidth;
			inner = window.innerWidth;
		}
		else if( axis === 'y' ) {
			client = docElem.clientHeight;
			inner = window.innerHeight;
		}

		return client < inner ? inner : client;
	}

	var win = { width : getViewport('x'), height : getViewport('y') };

	function extend( a, b ) {
		for( var key in b ) {
			if( b.hasOwnProperty( key ) ) {
				a[key] = b[key];
			}
		}
		return a;
	}

	function BoxesFx( el, arrow_ani, autoplay, options ) {
		this.el = el;
		this.arrow_ani = arrow_ani;
		this.autotimer = 0;
		this.autoplay = autoplay;
		this.options = extend( {}, this.options );
		extend( this.options, options );
		this._init();
	}

	BoxesFx.prototype.options = {};

	BoxesFx.prototype._init = function() {
		var self = this;
		// set transforms configuration
		this._setTransforms();
		// which effect
		this.effect = this.el.getAttribute( 'data-effect' ) || 'effect-1';
		// check if animating
		this.isAnimating = false;
		// the panels
		this.panels = [].slice.call( this.el.querySelectorAll( '.panel' ) );
		// total number of panels (4 for this demo)
		this.panelsCount = this.panels.length;
		// current panel´s index
		this.current = 0;
		classie.add( this.panels[0], 'current' );
		// replace image with 4 divs, each including the image

		this.panels.forEach( function( panel ) {
			var img = panel.querySelector( 'img' ), imgReplacement = '';
			for( var i = 0; i < 4; ++i ) {
				imgReplacement += '<div class="bg-tile"><div class="bg-img"><img src="' + img.src + '" /></div></div>';
			}
			panel.removeChild( img );
			panel.innerHTML = imgReplacement + panel.innerHTML;
		} );
		if (!body.hasClass('thb-full-menu-left-enabled')) {
			body.addClass($(this.panels[0]).data('color'));
		}
		this._autoplay();
		// add navigation element
//		this.nav = document.createElement( 'nav' );
//		this.nav.innerHTML = '<span class="prev"><i></i></span><span class="next"><i></i></span>';
//		this.el.appendChild( this.nav );
		// initialize events
		this._initEvents();
	};

	// set the transforms per effect
	// we have defined both the next and previous action transforms for each panel
	BoxesFx.prototype._setTransforms = function() {
		this.transforms = {
			'effect-1' : {
				'next' : [
					'translate3d(0, ' + (win.height/2+10) + 'px, 0)', // transforms for 1 panel
					'translate3d(-' + (win.width/2+10) + 'px, 0, 0)', // transforms for 2 panel
					'translate3d(' + (win.width/2+10) + 'px, 0, 0)', // transforms for 3 panel
					'translate3d(0, -' + (win.height/2+10) + 'px, 0)' // transforms for 4 panel
				],
				'prev' : [
					'translate3d(' + (win.width/2+10) + 'px, 0, 0)',
					'translate3d(0, ' + (win.height/2+10) + 'px, 0)',
					'translate3d(0, -' + (win.height/2+10) + 'px, 0)',
					'translate3d(-' + (win.width/2+10) + 'px, 0, 0)'
				]
			},
			'effect-2' : {
				'next' : [
					'translate3d(-' + (win.width/2+10) + 'px, 0, 0)',
					'translate3d(' + (win.width/2+10) + 'px, 0, 0)',
					'translate3d(-' + (win.width/2+10) + 'px, 0, 0)',
					'translate3d(' + (win.width/2+10) + 'px, 0, 0)'
				],
				'prev' : [
					'translate3d(0,-' + (win.height/2+10) + 'px, 0)',
					'translate3d(0,-' + (win.height/2+10) + 'px, 0)',
					'translate3d(0,' + (win.height/2+10) + 'px, 0)',
					'translate3d(0,' + (win.height/2+10) + 'px, 0)'
				]
			},
			'effect-3' : {
				'next' : [
					'translate3d(0,' + (win.height/2+10) + 'px, 0)',
					'translate3d(0,' + (win.height/2+10) + 'px, 0)',
					'translate3d(0,' + (win.height/2+10) + 'px, 0)',
					'translate3d(0,' + (win.height/2+10) + 'px, 0)'
				],
				'prev' : [
					'translate3d(0,-' + (win.height/2+10) + 'px, 0)',
					'translate3d(0,-' + (win.height/2+10) + 'px, 0)',
					'translate3d(0,-' + (win.height/2+10) + 'px, 0)',
					'translate3d(0,-' + (win.height/2+10) + 'px, 0)'
				]
			}
		};
	};

	BoxesFx.prototype._initEvents = function() {
		var self = this;
		// previous action
		$('.swiper-button-prev').on( 'click', function() { self._navigate('prev'); } );
		// next action
		$('.swiper-button-next').on( 'click', function() { self._navigate('next'); } );
		// window resize
		window.addEventListener( 'resize', function() { self._resizeHandler(); } );
	};
	BoxesFx.prototype._autoplay = function( dir ){
		var self = this;

		if (self.autoplay) {
			self.arrow_ani.play();
			self.autotimer = setInterval(function(){
				self._navigate('next');
			}, self.autoplay);
		}
	};
	BoxesFx.prototype._stopAutoplay = function( ){
		if (this.autoplay) {
			this.arrow_ani.reverse();
			clearInterval(this.autotimer);
		}
	};
	// goto next or previous slide
	BoxesFx.prototype._navigate = function( dir ) {
		this._stopAutoplay();
		if( this.isAnimating ) { return false; }
		this.isAnimating = true;

		var self = this, currentPanel = this.panels[ this.current ];

		if( dir === 'next' ) {
			this.current = this.current < this.panelsCount - 1 ? this.current + 1 : 0;
		}
		else {
			this.current = this.current > 0 ? this.current - 1 : this.panelsCount - 1;
		}

		// next panel to be shown
		var nextPanel = this.panels[ this.current ];
		// add class active to the next panel to trigger its animation
		classie.add( nextPanel, 'active' );

		// apply the transforms to the current panel
		this._applyTransforms( currentPanel, dir );
		self._autoplay();

		if (!body.hasClass('thb-full-menu-left-enabled')) {
			body.removeClass('logo-light logo-dark').addClass($(nextPanel).data('color'));
		}
		// let´s track the number of transitions ended per panel
		var cntTransTotal = 0,

		// transition end event function
		onEndTransitionFn = function( ev ) {

			// return if not all panel transitions ended
			++cntTransTotal;
			if( cntTransTotal < 4 ) { return false; }
			console.log('a');
			$(this).off( transEndEventName, onEndTransitionFn );

			// remove current class from current panel and add it to the next one
			classie.remove( currentPanel, 'current' );
			classie.add( nextPanel, 'current' );
			// reset transforms for the currentPanel
			self._resetTransforms( currentPanel );
			// remove class active
			classie.remove( nextPanel, 'active' );
			self.isAnimating = false;
		};

		self.arrow_ani.restart();
		$(currentPanel).on( transEndEventName, onEndTransitionFn );
	};

	BoxesFx.prototype._applyTransforms = function( panel, dir ) {
		var self = this;
		[].slice.call( panel.querySelectorAll( 'div.bg-img' ) ).forEach( function( tile, pos ) {
			tile.style.WebkitTransform = self.transforms[self.effect][dir][pos];
			tile.style.transform = self.transforms[self.effect][dir][pos];
		} );
	};

	BoxesFx.prototype._resetTransforms = function( panel ) {
		[].slice.call( panel.querySelectorAll( 'div.bg-img' ) ).forEach( function( tile ) {
			tile.style.WebkitTransform = 'none';
			tile.style.transform = 'none';
		} );
	};

	BoxesFx.prototype._resizeHandler = function() {
		var self = this;
		function delayed() {
			self._resize();
			self._resizeTimeout = null;
		}
		if ( this._resizeTimeout ) {
			clearTimeout( this._resizeTimeout );
		}
		this._resizeTimeout = setTimeout( delayed, 50 );
	};

	BoxesFx.prototype._resize = function() {
		win.width = getViewport('x');
		win.height = getViewport('y');
		this._setTransforms();
	};

	// add to global namespace
	window.BoxesFx = BoxesFx;

} )( window, jQuery );
