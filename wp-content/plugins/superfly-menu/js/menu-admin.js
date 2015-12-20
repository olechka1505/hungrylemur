/* Modernizr 2.8.1 (Custom Build) | MIT & BSD
 * Build: http://modernizr.com/download/#-csstransitions-shiv-cssclasses-prefixed-testprop-testallprops-domprefixes-load
 */
;window.Modernizr=function(a,b,c){function x(a){j.cssText=a}function y(a,b){return x(prefixes.join(a+";")+(b||""))}function z(a,b){return typeof a===b}function A(a,b){return!!~(""+a).indexOf(b)}function B(a,b){for(var d in a){var e=a[d];if(!A(e,"-")&&j[e]!==c)return b=="pfx"?e:!0}return!1}function C(a,b,d){for(var e in a){var f=b[a[e]];if(f!==c)return d===!1?a[e]:z(f,"function")?f.bind(d||b):f}return!1}function D(a,b,c){var d=a.charAt(0).toUpperCase()+a.slice(1),e=(a+" "+n.join(d+" ")+d).split(" ");return z(b,"string")||z(b,"undefined")?B(e,b):(e=(a+" "+o.join(d+" ")+d).split(" "),C(e,b,c))}var d="2.8.0",e={},f=!0,g=b.documentElement,h="modernizr",i=b.createElement(h),j=i.style,k,l={}.toString,m="Webkit Moz O ms",n=m.split(" "),o=m.toLowerCase().split(" "),p={},q={},r={},s=[],t=s.slice,u,v={}.hasOwnProperty,w;!z(v,"undefined")&&!z(v.call,"undefined")?w=function(a,b){return v.call(a,b)}:w=function(a,b){return b in a&&z(a.constructor.prototype[b],"undefined")},Function.prototype.bind||(Function.prototype.bind=function(b){var c=this;if(typeof c!="function")throw new TypeError;var d=t.call(arguments,1),e=function(){if(this instanceof e){var a=function(){};a.prototype=c.prototype;var f=new a,g=c.apply(f,d.concat(t.call(arguments)));return Object(g)===g?g:f}return c.apply(b,d.concat(t.call(arguments)))};return e}),p.csstransitions=function(){return D("transition")};for(var E in p)w(p,E)&&(u=E.toLowerCase(),e[u]=p[E](),s.push((e[u]?"":"no-")+u));return e.addTest=function(a,b){if(typeof a=="object")for(var d in a)w(a,d)&&e.addTest(d,a[d]);else{a=a.toLowerCase();if(e[a]!==c)return e;b=typeof b=="function"?b():b,typeof f!="undefined"&&f&&(g.className+=" "+(b?"":"no-")+a),e[a]=b}return e},x(""),i=k=null,function(a,b){function l(a,b){var c=a.createElement("p"),d=a.getElementsByTagName("head")[0]||a.documentElement;return c.innerHTML="x<style>"+b+"</style>",d.insertBefore(c.lastChild,d.firstChild)}function m(){var a=s.elements;return typeof a=="string"?a.split(" "):a}function n(a){var b=j[a[h]];return b||(b={},i++,a[h]=i,j[i]=b),b}function o(a,c,d){c||(c=b);if(k)return c.createElement(a);d||(d=n(c));var g;return d.cache[a]?g=d.cache[a].cloneNode():f.test(a)?g=(d.cache[a]=d.createElem(a)).cloneNode():g=d.createElem(a),g.canHaveChildren&&!e.test(a)&&!g.tagUrn?d.frag.appendChild(g):g}function p(a,c){a||(a=b);if(k)return a.createDocumentFragment();c=c||n(a);var d=c.frag.cloneNode(),e=0,f=m(),g=f.length;for(;e<g;e++)d.createElement(f[e]);return d}function q(a,b){b.cache||(b.cache={},b.createElem=a.createElement,b.createFrag=a.createDocumentFragment,b.frag=b.createFrag()),a.createElement=function(c){return s.shivMethods?o(c,a,b):b.createElem(c)},a.createDocumentFragment=Function("h,f","return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&("+m().join().replace(/[\w\-]+/g,function(a){return b.createElem(a),b.frag.createElement(a),'c("'+a+'")'})+");return n}")(s,b.frag)}function r(a){a||(a=b);var c=n(a);return s.shivCSS&&!g&&!c.hasCSS&&(c.hasCSS=!!l(a,"article,aside,dialog,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}mark{background:#FF0;color:#000}template{display:none}")),k||q(a,c),a}var c="3.7.0",d=a.html5||{},e=/^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i,f=/^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i,g,h="_html5shiv",i=0,j={},k;(function(){try{var a=b.createElement("a");a.innerHTML="<xyz></xyz>",g="hidden"in a,k=a.childNodes.length==1||function(){b.createElement("a");var a=b.createDocumentFragment();return typeof a.cloneNode=="undefined"||typeof a.createDocumentFragment=="undefined"||typeof a.createElement=="undefined"}()}catch(c){g=!0,k=!0}})();var s={elements:d.elements||"abbr article aside audio bdi canvas data datalist details dialog figcaption figure footer header hgroup main mark meter nav output progress section summary template time video",version:c,shivCSS:d.shivCSS!==!1,supportsUnknownElements:k,shivMethods:d.shivMethods!==!1,type:"default",shivDocument:r,createElement:o,createDocumentFragment:p};a.html5=s,r(b)}(this,b),e._version=d,e._domPrefixes=o,e._cssomPrefixes=n,e.testProp=function(a){return B([a])},e.testAllProps=D,e.prefixed=function(a,b,c){return b?D(a,b,c):D(a,"pfx")},g.className=g.className.replace(/(^|\s)no-js(\s|$)/,"$1$2")+(f?" js "+s.join(" "):""),e}(this,this.document),function(a,b,c){function d(a){return"[object Function]"==o.call(a)}function e(a){return"string"==typeof a}function f(){}function g(a){return!a||"loaded"==a||"complete"==a||"uninitialized"==a}function h(){var a=p.shift();q=1,a?a.t?m(function(){("c"==a.t?B.injectCss:B.injectJs)(a.s,0,a.a,a.x,a.e,1)},0):(a(),h()):q=0}function i(a,c,d,e,f,i,j){function k(b){if(!o&&g(l.readyState)&&(u.r=o=1,!q&&h(),l.onload=l.onreadystatechange=null,b)){"img"!=a&&m(function(){t.removeChild(l)},50);for(var d in y[c])y[c].hasOwnProperty(d)&&y[c][d].onload()}}var j=j||B.errorTimeout,l=b.createElement(a),o=0,r=0,u={t:d,s:c,e:f,a:i,x:j};1===y[c]&&(r=1,y[c]=[]),"object"==a?l.data=c:(l.src=c,l.type=a),l.width=l.height="0",l.onerror=l.onload=l.onreadystatechange=function(){k.call(this,r)},p.splice(e,0,u),"img"!=a&&(r||2===y[c]?(t.insertBefore(l,s?null:n),m(k,j)):y[c].push(l))}function j(a,b,c,d,f){return q=0,b=b||"j",e(a)?i("c"==b?v:u,a,b,this.i++,c,d,f):(p.splice(this.i++,0,a),1==p.length&&h()),this}function k(){var a=B;return a.loader={load:j,i:0},a}var l=b.documentElement,m=a.setTimeout,n=b.getElementsByTagName("script")[0],o={}.toString,p=[],q=0,r="MozAppearance"in l.style,s=r&&!!b.createRange().compareNode,t=s?l:n.parentNode,l=a.opera&&"[object Opera]"==o.call(a.opera),l=!!b.attachEvent&&!l,u=r?"object":l?"script":"img",v=l?"script":u,w=Array.isArray||function(a){return"[object Array]"==o.call(a)},x=[],y={},z={timeout:function(a,b){return b.length&&(a.timeout=b[0]),a}},A,B;B=function(a){function b(a){var a=a.split("!"),b=x.length,c=a.pop(),d=a.length,c={url:c,origUrl:c,prefixes:a},e,f,g;for(f=0;f<d;f++)g=a[f].split("="),(e=z[g.shift()])&&(c=e(c,g));for(f=0;f<b;f++)c=x[f](c);return c}function g(a,e,f,g,h){var i=b(a),j=i.autoCallback;i.url.split(".").pop().split("?").shift(),i.bypass||(e&&(e=d(e)?e:e[a]||e[g]||e[a.split("/").pop().split("?")[0]]),i.instead?i.instead(a,e,f,g,h):(y[i.url]?i.noexec=!0:y[i.url]=1,f.load(i.url,i.forceCSS||!i.forceJS&&"css"==i.url.split(".").pop().split("?").shift()?"c":c,i.noexec,i.attrs,i.timeout),(d(e)||d(j))&&f.load(function(){k(),e&&e(i.origUrl,h,g),j&&j(i.origUrl,h,g),y[i.url]=2})))}function h(a,b){function c(a,c){if(a){if(e(a))c||(j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}),g(a,j,b,0,h);else if(Object(a)===a)for(n in m=function(){var b=0,c;for(c in a)a.hasOwnProperty(c)&&b++;return b}(),a)a.hasOwnProperty(n)&&(!c&&!--m&&(d(j)?j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}:j[n]=function(a){return function(){var b=[].slice.call(arguments);a&&a.apply(this,b),l()}}(k[n])),g(a[n],j,b,n,h))}else!c&&l()}var h=!!a.test,i=a.load||a.both,j=a.callback||f,k=j,l=a.complete||f,m,n;c(h?a.yep:a.nope,!!i),i&&c(i)}var i,j,l=this.yepnope.loader;if(e(a))g(a,0,l,0);else if(w(a))for(i=0;i<a.length;i++)j=a[i],e(j)?g(j,0,l,0):w(j)?B(j):Object(j)===j&&h(j,l);else Object(a)===a&&h(a,l)},B.addPrefix=function(a,b){z[a]=b},B.addFilter=function(a){x.push(a)},B.errorTimeout=1e4,null==b.readyState&&b.addEventListener&&(b.readyState="loading",b.addEventListener("DOMContentLoaded",A=function(){b.removeEventListener("DOMContentLoaded",A,0),b.readyState="complete"},0)),a.yepnope=k(),a.yepnope.executeStack=h,a.yepnope.injectJs=function(a,c,d,e,i,j){var k=b.createElement("script"),l,o,e=e||B.errorTimeout;k.src=a;for(o in d)k.setAttribute(o,d[o]);c=j?h:c||f,k.onreadystatechange=k.onload=function(){!l&&g(k.readyState)&&(l=1,c(),k.onload=k.onreadystatechange=null)},m(function(){l||(l=1,c(1))},e),i?k.onload():n.parentNode.insertBefore(k,n)},a.yepnope.injectCss=function(a,c,d,e,g,i){var e=b.createElement("link"),j,c=i?h:c||f;e.href=a,e.rel="stylesheet",e.type="text/css";for(j in d)e.setAttribute(j,d[j]);g||(n.parentNode.insertBefore(e,n),m(c,0))}}(this,document),Modernizr.load=function(){yepnope.apply(window,[].slice.call(arguments,0))};

/*!
 * classie - class helper functions
 * from bonzo https://github.com/ded/bonzo
 *
 * classie.has( elem, 'my-class' ) -> true/false
 * classie.add( elem, 'my-new-class' )
 * classie.remove( elem, 'my-unwanted-class' )
 * classie.toggle( elem, 'my-class' )
 */

/*jshint browser: true, strict: true, undef: true */
/*global define: false */

( function( window ) {

	'use strict';

// class helper functions from bonzo https://github.com/ded/bonzo

	function classReg( className ) {
		return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
	}

// classList support for class management
// altho to be fair, the api sucks because it won't accept multiple classes at once
	var hasClass, addClass, removeClass;

	if ( 'classList' in document.documentElement ) {
		hasClass = function( elem, c ) {
			return elem.classList.contains( c );
		};
		addClass = function( elem, c ) {
			elem.classList.add( c );
		};
		removeClass = function( elem, c ) {
			elem.classList.remove( c );
		};
	}
	else {
		hasClass = function( elem, c ) {
			return classReg( c ).test( elem.className );
		};
		addClass = function( elem, c ) {
			if ( !hasClass( elem, c ) ) {
				elem.className = elem.className + ' ' + c;
			}
		};
		removeClass = function( elem, c ) {
			elem.className = elem.className.replace( classReg( c ), ' ' );
		};
	}

	function toggleClass( elem, c ) {
		var fn = hasClass( elem, c ) ? removeClass : addClass;
		fn( elem, c );
	}

	var classie = {
		// full names
		hasClass: hasClass,
		addClass: addClass,
		removeClass: removeClass,
		toggleClass: toggleClass,
		// short names
		has: hasClass,
		add: addClass,
		remove: removeClass,
		toggle: toggleClass
	};

// transport
	if ( typeof define === 'function' && define.amd ) {
		// AMD
		define( classie );
	} else {
		// browser global
		window.classie = classie;
	}

})( window );

/**
 * uiMorphingButton_fixed.js v1.0.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Copyright 2014, Codrops
 * http://www.codrops.com
 */
;( function( window ) {

	'use strict';

	var transEndEventNames = {
			'WebkitTransition': 'webkitTransitionEnd',
			'MozTransition': 'transitionend',
			'OTransition': 'oTransitionEnd',
			'msTransition': 'MSTransitionEnd',
			'transition': 'transitionend'
		},
		transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
		support = { transitions : Modernizr.csstransitions };

	function extend( a, b ) {
		for( var key in b ) {
			if( b.hasOwnProperty( key ) ) {
				a[key] = b[key];
			}
		}
		return a;
	}

	function UIMorphingButton( el, options ) {
		this.el = el;
		this.options = extend( {}, this.options );
		extend( this.options, options );
		this._init();
	}

	UIMorphingButton.prototype.options = {
		closeEl : '',
		onBeforeOpen : function() { return false; },
		onAfterOpen : function() { return false; },
		onBeforeClose : function() { return false; },
		onAfterClose : function() { return false; }
	}

	UIMorphingButton.prototype._init = function() {
		// the button
		this.button = this.el.querySelector( '.sf-settings' );
		// state
		this.expanded = false;
		// content el
		this.contentEl = this.el.querySelector( '.morph-content' );
		// init events
		this._initEvents();
	}

	UIMorphingButton.prototype._initEvents = function() {
		var self = this;
		// open
		this.button.addEventListener( 'click', function() { self.toggle(); } );
		// close
		if( this.options.closeEl !== '' ) {
			var closeEl = this.el.querySelector( this.options.closeEl );
			if( closeEl ) {
				closeEl.addEventListener( 'click', function() { self.toggle(); } );
			}
		}

		jQuery(this.el).on( 'click', function(e) {
			var $t = jQuery(e.target);

			if (!$t.closest('.morph-content').length) {
				self.toggle();
			}
		});

	}

	UIMorphingButton.prototype.toggle = function() {
		if( this.isAnimating ) return false;

		// callback
		if( this.expanded ) {
			this.options.onBeforeClose();
		}
		else {
			// add class active (solves z-index problem when more than one button is in the page)
			classie.addClass( this.el, 'active' );
			this.options.onBeforeOpen();
		}

		this.isAnimating = true;

		var self = this,
			onEndTransitionFn = function( ev ) {
				if( ev.target !== this ) return false;

				if( support.transitions ) {
					// open: first opacity then width/height/left/top
					// close: first width/height/left/top then opacity
					if( self.expanded && ev.propertyName !== 'opacity' || !self.expanded && ev.propertyName !== 'width' && ev.propertyName !== 'height' && ev.propertyName !== 'left' && ev.propertyName !== 'top' ) {
						return false;
					}
					this.removeEventListener( transEndEventName, onEndTransitionFn );
				}
				self.isAnimating = false;

				// callback
				if( self.expanded ) {
					// remove class active (after closing)
					classie.removeClass( self.el, 'active' );
					self.options.onAfterClose();
				}
				else {
					self.options.onAfterOpen();
					classie.addClass( self.el, 'opened' );
					classie.addClass( document.body, 'sf-modal-opened' );
				}

				self.expanded = !self.expanded;
			};

		if( support.transitions ) {
			this.contentEl.addEventListener( transEndEventName, onEndTransitionFn );
		}
		else {
			onEndTransitionFn();
		}

		// set the left and top values of the contentEl (same like the button)
		var buttonPos = this.button.getBoundingClientRect();
		// need to reset
		classie.addClass( this.contentEl, 'no-transition' );
		this.contentEl.style.left = 'auto';
		this.contentEl.style.top = 'auto';

		// add/remove class "open" to the button wraper
		setTimeout( function() {
			self.contentEl.style.left = buttonPos.left + 'px';
			self.contentEl.style.top = buttonPos.top + 'px';

			if( self.expanded ) {
				classie.removeClass( self.contentEl, 'no-transition' );
				classie.removeClass( self.el, 'open' );
				classie.removeClass( self.el, 'opened' );
				classie.removeClass( document.body, 'sf-modal-opened' );

			}
			else {
				setTimeout( function() {
					classie.removeClass( self.contentEl, 'no-transition' );
					classie.addClass( self.el, 'open' );
				}, 25 );
			}
		}, 25 );
	}

	// add to global namespace
	window.UIMorphingButton = UIMorphingButton;

})( window );

jQuery(function($){

	var docElem = window.document.documentElement, didScroll, scrollPosition;

	var morph =
		'<div class="sf-settings-wrapper morph-button morph-button-fixed morph-button-modal morph-button-modal-2">' +
			'<span title="Superfly Item Settings" class="sf-settings sf-anim"><i class="fa fa-gear"></i> SF</span>' +
			'<div class="morph-content" title="Test">' +
			'<i class="fa fa-times"></i>' +
			'<form class="sf-menu-item-form" action="" method="post" enctype="multipart/form-data">' +
			'<div>' +
			'<h3>Attached image</h3>' +
			'<div class="sf-info sf-anim">Please choose image to show on the left side of item. Use square pics. Will be scaled to 40px height.</div>' +
			'<div class="sf-media"><span class="sf-image-cont"></span><span class="sf-choose-image">Select Image</span></div>' +
			'<input class="sf-media-input" type="hidden" name="img"/>' +
			'</div>' +
			'<div><h3>Font Awesome class</h3>' +
			'<div class="sf-info sf-anim">You can add icon before item. See <a href="http://fortawesome.github.io/Font-Awesome/cheatsheet/" target="_blank">cheatsheet</a>. Won\'t work with attached image</div>' +
			'<input class="sf-short" type="text" name="icon"/>' +
			'</div>' +
			'<div><h3>Second line</h3>' +
			'<div class="sf-info sf-anim">Brief description under menu item</div>' +
			'<input type="text" name="sline"/>' +
			'</div>' +
			/*'<div><h3>Chapter</h3>' +
			 '<div class="sf-info sf-anim">Chapter title that goes above menu item</div>' +
			 '<input class="" type="text" name="chapter"/>' +
			 '</div>' +*/
			'<div><h3>Custom HTML OR shortcode</h3>' +
			'<div class="sf-info sf-anim">That will be shown in panel when user clicks/mouseover according menu item</div>' +
			'<textarea class="" type="text" name="content"></textarea>' +
			'</div>' +
			'<div><h3>Custom panel color</h3>' +
			'<div class="sf-info sf-anim">Background color for panel with custom content</div>' +
			'<input class="sf-short" type="text" name="bg"/>' +
			'</div>' +
			'<div><h3>Custom panel width</h3>' +
			'<div class="sf-info sf-anim">If empty default level width will be applied</div>' +
			'<input class="sf-short" type="text" name="width"/>' +
			'</div>' +
			'<div><h3>Hide item and its custom content on mobiles</h3>' +
			'<label for="mob_%ID%"><input id="mob_%ID%" name="hidemob" class="switcher" type="checkbox" value="yes" /></label>' +
			'</div>' +
			'<p><button>Save & Close</button></p>' +
			'</form>' +
			'</div>'
	'</div>';

	var file_frame;


	$('#menu-management .menu-item').each(function(){
		var $t = $(this);
		var id = this.id;
		var $morph = $(morph.replace(/%ID%/g, id));
		$morph.find('.morph-content').attr('title', $t.find('.menu-item-title').text())

		$t.find( '.item-title' ).append( $morph.attr('data-sf-item-id', id) );

	});

	$('.switcher').each(function(){
		$(this).after('<div><div></div></div>')
	})

	// trick to prevent scrolling when opening/closing button
	function noScrollFn() {
		window.scrollTo( scrollPosition ? scrollPosition.x : 0, scrollPosition ? scrollPosition.y : 0 );
	}

	function noScroll() {
		window.removeEventListener( 'scroll', scrollHandler );
		window.addEventListener( 'scroll', noScrollFn );
	}

	function scrollFn() {
		window.addEventListener( 'scroll', scrollHandler );
	}

	function canScroll() {
		window.removeEventListener( 'scroll', noScrollFn );
		scrollFn();
	}

	function scrollHandler() {
		if( !didScroll ) {
			didScroll = true;
			setTimeout( function() { scrollPage(); }, 60 );
		}
	};

	function scrollPage() {
		scrollPosition = { x : window.pageXOffset || docElem.scrollLeft, y : window.pageYOffset || docElem.scrollTop };
		didScroll = false;
	};

	function deparam(query) {
		var pairs, i, keyValuePair, key, value, map = {};
		// remove leading question mark if its there
		if (query.slice(0, 1) === '?') {
			query = query.slice(1);
		}
		if (query !== '') {
			pairs = query.split('&');
			for (i = 0; i < pairs.length; i += 1) {
				keyValuePair = pairs[i].split('=');
				key = decodeURIComponent(keyValuePair[0]);
				value = (keyValuePair.length > 1) ? decodeURIComponent(keyValuePair[1]) : undefined;
				map[key] = value.replace(/\+/g, ' ');
			}
		}
		return map;
	}

	scrollFn();

	[].slice.call( document.querySelectorAll( '.morph-button' ) ).forEach( function( bttn ) {
		new UIMorphingButton( bttn, {
			closeEl : '.fa-times',
			onBeforeOpen : function() {
				// don't allow to scroll
				noScroll();
			},
			onAfterOpen : function() {
				// can scroll again
				canScroll();
			},
			onBeforeClose : function() {
				// don't allow to scroll
				noScroll();
			},
			onAfterClose : function() {
				// can scroll again
				canScroll();
			}
		} );
	} );


	$('#menu-management .sf-settings-wrapper form').each(function(){
		var $t = $( this );
		var id = $t.closest('.sf-settings-wrapper').attr('data-sf-item-id').replace('menu-item-', '');
		var $inp;
		var data = sf_menus_data[id];

		if (!data) {
			$t.find('[name="bg"]').wpColorPicker();
			return;
		}

		data = deparam(data);
		console.log(data)

		for (var name in data) {
			$inp = $t.find('[name='+ name +']');
			if ($inp.is(':checkbox')) {
				if (data[name] === 'yes') $inp.attr('checked', true);
			} else {
				$t.find('[name='+ name +']').val(data[name]);
			}
			if (name === 'img' && data[name] !== '') {
				$t.find('.sf-image-cont').html('<img src="' + data[name] + '"/>')
			}
		}

		$t.find('[name="bg"]').wpColorPicker();

	})


	$('#menu-management .sf-settings-wrapper form').on('submit', function ( e ){
		e.preventDefault();

		var $form = $(this);
		var $wrap = $form.closest('.morph-content');
		var serialized = $form.serialize();
		var id =  $(this).closest('.sf-settings-wrapper').attr('data-sf-item-id');
		console.log( 'serialized: ' + serialized );

		//return;
		var data = {
			action: 'sf_save_item',
			settings: serialized,
			id: id.replace('menu-item-', '')
		};

		// loading
		$wrap.addClass('sf-loading sf-shrinking')

		$.post( sf_menus_meta.ajax_url, data, function( response ) {
			console.log('Got this from the server: ' , response );
			if( response == -1 ){

			}
			else{
				$wrap.removeClass('sf-loading');
				setTimeout(function(){$wrap.removeClass('sf-shrinking')}, 500);
				$wrap.find('.fa-times').click();
			}
		}, 'json' ).fail( function( d ){
			console.log( d.responseText );
			console.log( d );
		});

		return false;

	})

	/*	$( '#menu-management .fa-question-circle' ).on( 'click', function( e ){
	 var $pop = $(this).closest('.morph-button')
	 $pop.toggleClass('sf-help')
	 });*/

	$( '.sf-image-cont' ).on( 'click', function( event ){
		var $t = $( this );
		var $wrap = $t.closest( 'form' );
		var $input = $wrap.find(' .sf-media-input ');

		if ($t.has('img')) {
			$input.val('');
			$t.html('');
		}
	})

	var $currBtn, $input;

	$( '#menu-management .sf-choose-image' ).on( 'click', function( event ){

		$currBtn = $( this );
		$input = $currBtn.closest( 'form' ).find(' .sf-media-input ');
		// If the media frame already exists, reopen it.
		if ( file_frame ) {
			file_frame.open();
			return;
		}

		// Create the media frame.
		file_frame = wp.media.frames.file_frame = wp.media({
			multiple: false  // Set to true to allow multiple files to be selected
		});

		// When an image is selected, run a callback.
		file_frame.on( 'select', function() {
			// We set multiple to false so only get one image from the uploader

			attachment = file_frame.state().get('selection').first().toJSON();
			$currBtn.prev().html( '<img src="' + attachment.url + '"/>' )
			$input.val(attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.sizes.full.url);
			$currBtn = null;
		});

		// Finally, open the modal
		file_frame.open();
	});


	// icon picker
	//$('body').append('<div id="sf-iconpicker"> <div class="btn-group"> <button type="button" class="btn btn-primary iconpicker-component"><i class="fa fa-angle-left"></i></button> <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle iconpicker-element" data-selected="fa-car" data-toggle="dropdown"> <span class="caret"></span> </button> <div class="dropdown-menu iconpicker-container"><div class="iconpicker-popover popover fade in inline" style="top: auto; right: auto; bottom: auto; left: auto; max-width: none;"><div class="arrow"></div><div class="popover-content"><div class="iconpicker"><div class="iconpicker-items"><a role="button" href="#" class="iconpicker-item" title=".fa-adjust"><i class="fa fa-adjust"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-adn"><i class="fa fa-adn"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-align-center"><i class="fa fa-align-center"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-align-justify"><i class="fa fa-align-justify"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-align-left"><i class="fa fa-align-left"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-align-right"><i class="fa fa-align-right"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-ambulance"><i class="fa fa-ambulance"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-anchor"><i class="fa fa-anchor"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-android"><i class="fa fa-android"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-angle-double-down"><i class="fa fa-angle-double-down"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-angle-double-left"><i class="fa fa-angle-double-left"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-angle-double-right"><i class="fa fa-angle-double-right"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-angle-double-up"><i class="fa fa-angle-double-up"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-angle-down"><i class="fa fa-angle-down"></i></a><a role="button" href="#" class="iconpicker-item iconpicker-selected bg-primary" title=".fa-angle-left"><i class="fa fa-angle-left"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-angle-right"><i class="fa fa-angle-right"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-angle-up"><i class="fa fa-angle-up"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-apple"><i class="fa fa-apple"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-archive"><i class="fa fa-archive"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-arrow-circle-down"><i class="fa fa-arrow-circle-down"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-arrow-circle-left"><i class="fa fa-arrow-circle-left"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-arrow-circle-o-down"><i class="fa fa-arrow-circle-o-down"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-arrow-circle-o-left"><i class="fa fa-arrow-circle-o-left"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-arrow-circle-o-right"><i class="fa fa-arrow-circle-o-right"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-arrow-circle-o-up"><i class="fa fa-arrow-circle-o-up"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-arrow-circle-right"><i class="fa fa-arrow-circle-right"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-arrow-circle-up"><i class="fa fa-arrow-circle-up"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-arrow-down"><i class="fa fa-arrow-down"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-arrow-left"><i class="fa fa-arrow-left"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-arrow-right"><i class="fa fa-arrow-right"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-arrow-up"><i class="fa fa-arrow-up"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-arrows"><i class="fa fa-arrows"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-arrows-alt"><i class="fa fa-arrows-alt"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-arrows-h"><i class="fa fa-arrows-h"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-arrows-v"><i class="fa fa-arrows-v"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-asterisk"><i class="fa fa-asterisk"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-automobile"><i class="fa fa-automobile"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-backward"><i class="fa fa-backward"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-ban"><i class="fa fa-ban"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-bank"><i class="fa fa-bank"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-bar-chart-o"><i class="fa fa-bar-chart-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-barcode"><i class="fa fa-barcode"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-bars"><i class="fa fa-bars"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-beer"><i class="fa fa-beer"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-behance"><i class="fa fa-behance"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-behance-square"><i class="fa fa-behance-square"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-bell"><i class="fa fa-bell"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-bell-o"><i class="fa fa-bell-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-bitbucket"><i class="fa fa-bitbucket"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-bitbucket-square"><i class="fa fa-bitbucket-square"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-bitcoin"><i class="fa fa-bitcoin"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-bold"><i class="fa fa-bold"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-bolt"><i class="fa fa-bolt"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-bomb"><i class="fa fa-bomb"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-book"><i class="fa fa-book"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-bookmark"><i class="fa fa-bookmark"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-bookmark-o"><i class="fa fa-bookmark-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-briefcase"><i class="fa fa-briefcase"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-btc"><i class="fa fa-btc"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-bug"><i class="fa fa-bug"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-building"><i class="fa fa-building"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-building-o"><i class="fa fa-building-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-bullhorn"><i class="fa fa-bullhorn"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-bullseye"><i class="fa fa-bullseye"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-cab"><i class="fa fa-cab"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-calendar"><i class="fa fa-calendar"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-calendar-o"><i class="fa fa-calendar-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-camera"><i class="fa fa-camera"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-camera-retro"><i class="fa fa-camera-retro"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-car"><i class="fa fa-car"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-caret-down"><i class="fa fa-caret-down"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-caret-left"><i class="fa fa-caret-left"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-caret-right"><i class="fa fa-caret-right"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-caret-square-o-down"><i class="fa fa-caret-square-o-down"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-caret-square-o-left"><i class="fa fa-caret-square-o-left"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-caret-square-o-right"><i class="fa fa-caret-square-o-right"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-caret-square-o-up"><i class="fa fa-caret-square-o-up"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-caret-up"><i class="fa fa-caret-up"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-certificate"><i class="fa fa-certificate"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-chain"><i class="fa fa-chain"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-chain-broken"><i class="fa fa-chain-broken"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-check"><i class="fa fa-check"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-check-circle"><i class="fa fa-check-circle"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-check-circle-o"><i class="fa fa-check-circle-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-check-square"><i class="fa fa-check-square"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-check-square-o"><i class="fa fa-check-square-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-chevron-circle-down"><i class="fa fa-chevron-circle-down"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-chevron-circle-left"><i class="fa fa-chevron-circle-left"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-chevron-circle-right"><i class="fa fa-chevron-circle-right"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-chevron-circle-up"><i class="fa fa-chevron-circle-up"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-chevron-down"><i class="fa fa-chevron-down"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-chevron-left"><i class="fa fa-chevron-left"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-chevron-right"><i class="fa fa-chevron-right"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-chevron-up"><i class="fa fa-chevron-up"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-child"><i class="fa fa-child"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-circle"><i class="fa fa-circle"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-circle-o"><i class="fa fa-circle-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-circle-o-notch"><i class="fa fa-circle-o-notch"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-circle-thin"><i class="fa fa-circle-thin"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-clipboard"><i class="fa fa-clipboard"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-clock-o"><i class="fa fa-clock-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-cloud"><i class="fa fa-cloud"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-cloud-download"><i class="fa fa-cloud-download"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-cloud-upload"><i class="fa fa-cloud-upload"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-cny"><i class="fa fa-cny"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-code"><i class="fa fa-code"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-code-fork"><i class="fa fa-code-fork"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-codepen"><i class="fa fa-codepen"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-coffee"><i class="fa fa-coffee"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-cog"><i class="fa fa-cog"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-cogs"><i class="fa fa-cogs"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-columns"><i class="fa fa-columns"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-comment"><i class="fa fa-comment"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-comment-o"><i class="fa fa-comment-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-comments"><i class="fa fa-comments"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-comments-o"><i class="fa fa-comments-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-compass"><i class="fa fa-compass"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-compress"><i class="fa fa-compress"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-copy"><i class="fa fa-copy"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-credit-card"><i class="fa fa-credit-card"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-crop"><i class="fa fa-crop"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-crosshairs"><i class="fa fa-crosshairs"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-css3"><i class="fa fa-css3"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-cube"><i class="fa fa-cube"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-cubes"><i class="fa fa-cubes"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-cut"><i class="fa fa-cut"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-cutlery"><i class="fa fa-cutlery"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-dashboard"><i class="fa fa-dashboard"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-database"><i class="fa fa-database"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-dedent"><i class="fa fa-dedent"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-delicious"><i class="fa fa-delicious"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-desktop"><i class="fa fa-desktop"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-deviantart"><i class="fa fa-deviantart"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-digg"><i class="fa fa-digg"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-dollar"><i class="fa fa-dollar"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-dot-circle-o"><i class="fa fa-dot-circle-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-download"><i class="fa fa-download"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-dribbble"><i class="fa fa-dribbble"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-dropbox"><i class="fa fa-dropbox"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-drupal"><i class="fa fa-drupal"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-edit"><i class="fa fa-edit"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-eject"><i class="fa fa-eject"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-ellipsis-h"><i class="fa fa-ellipsis-h"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-ellipsis-v"><i class="fa fa-ellipsis-v"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-empire"><i class="fa fa-empire"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-envelope"><i class="fa fa-envelope"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-envelope-o"><i class="fa fa-envelope-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-envelope-square"><i class="fa fa-envelope-square"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-eraser"><i class="fa fa-eraser"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-eur"><i class="fa fa-eur"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-euro"><i class="fa fa-euro"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-exchange"><i class="fa fa-exchange"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-exclamation"><i class="fa fa-exclamation"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-exclamation-circle"><i class="fa fa-exclamation-circle"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-exclamation-triangle"><i class="fa fa-exclamation-triangle"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-expand"><i class="fa fa-expand"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-external-link"><i class="fa fa-external-link"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-external-link-square"><i class="fa fa-external-link-square"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-eye"><i class="fa fa-eye"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-eye-slash"><i class="fa fa-eye-slash"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-facebook"><i class="fa fa-facebook"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-facebook-square"><i class="fa fa-facebook-square"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-fast-backward"><i class="fa fa-fast-backward"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-fast-forward"><i class="fa fa-fast-forward"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-fax"><i class="fa fa-fax"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-female"><i class="fa fa-female"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-fighter-jet"><i class="fa fa-fighter-jet"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-file"><i class="fa fa-file"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-file-archive-o"><i class="fa fa-file-archive-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-file-audio-o"><i class="fa fa-file-audio-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-file-code-o"><i class="fa fa-file-code-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-file-excel-o"><i class="fa fa-file-excel-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-file-image-o"><i class="fa fa-file-image-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-file-movie-o"><i class="fa fa-file-movie-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-file-o"><i class="fa fa-file-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-file-pdf-o"><i class="fa fa-file-pdf-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-file-photo-o"><i class="fa fa-file-photo-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-file-picture-o"><i class="fa fa-file-picture-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-file-powerpoint-o"><i class="fa fa-file-powerpoint-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-file-sound-o"><i class="fa fa-file-sound-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-file-text"><i class="fa fa-file-text"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-file-text-o"><i class="fa fa-file-text-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-file-video-o"><i class="fa fa-file-video-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-file-word-o"><i class="fa fa-file-word-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-file-zip-o"><i class="fa fa-file-zip-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-files-o"><i class="fa fa-files-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-film"><i class="fa fa-film"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-filter"><i class="fa fa-filter"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-fire"><i class="fa fa-fire"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-fire-extinguisher"><i class="fa fa-fire-extinguisher"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-flag"><i class="fa fa-flag"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-flag-checkered"><i class="fa fa-flag-checkered"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-flag-o"><i class="fa fa-flag-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-flash"><i class="fa fa-flash"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-flask"><i class="fa fa-flask"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-flickr"><i class="fa fa-flickr"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-floppy-o"><i class="fa fa-floppy-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-folder"><i class="fa fa-folder"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-folder-o"><i class="fa fa-folder-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-folder-open"><i class="fa fa-folder-open"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-folder-open-o"><i class="fa fa-folder-open-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-font"><i class="fa fa-font"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-forward"><i class="fa fa-forward"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-foursquare"><i class="fa fa-foursquare"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-frown-o"><i class="fa fa-frown-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-gamepad"><i class="fa fa-gamepad"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-gavel"><i class="fa fa-gavel"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-gbp"><i class="fa fa-gbp"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-ge"><i class="fa fa-ge"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-gear"><i class="fa fa-gear"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-gears"><i class="fa fa-gears"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-gift"><i class="fa fa-gift"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-git"><i class="fa fa-git"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-git-square"><i class="fa fa-git-square"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-github"><i class="fa fa-github"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-github-alt"><i class="fa fa-github-alt"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-github-square"><i class="fa fa-github-square"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-gittip"><i class="fa fa-gittip"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-glass"><i class="fa fa-glass"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-globe"><i class="fa fa-globe"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-google"><i class="fa fa-google"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-google-plus"><i class="fa fa-google-plus"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-google-plus-square"><i class="fa fa-google-plus-square"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-graduation-cap"><i class="fa fa-graduation-cap"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-group"><i class="fa fa-group"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-h-square"><i class="fa fa-h-square"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-hacker-news"><i class="fa fa-hacker-news"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-hand-o-down"><i class="fa fa-hand-o-down"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-hand-o-left"><i class="fa fa-hand-o-left"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-hand-o-right"><i class="fa fa-hand-o-right"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-hand-o-up"><i class="fa fa-hand-o-up"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-hdd-o"><i class="fa fa-hdd-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-header"><i class="fa fa-header"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-headphones"><i class="fa fa-headphones"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-heart"><i class="fa fa-heart"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-heart-o"><i class="fa fa-heart-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-history"><i class="fa fa-history"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-home"><i class="fa fa-home"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-hospital-o"><i class="fa fa-hospital-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-html5"><i class="fa fa-html5"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-image"><i class="fa fa-image"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-inbox"><i class="fa fa-inbox"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-indent"><i class="fa fa-indent"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-info"><i class="fa fa-info"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-info-circle"><i class="fa fa-info-circle"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-inr"><i class="fa fa-inr"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-instagram"><i class="fa fa-instagram"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-institution"><i class="fa fa-institution"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-italic"><i class="fa fa-italic"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-joomla"><i class="fa fa-joomla"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-jpy"><i class="fa fa-jpy"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-jsfiddle"><i class="fa fa-jsfiddle"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-key"><i class="fa fa-key"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-keyboard-o"><i class="fa fa-keyboard-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-krw"><i class="fa fa-krw"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-language"><i class="fa fa-language"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-laptop"><i class="fa fa-laptop"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-leaf"><i class="fa fa-leaf"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-legal"><i class="fa fa-legal"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-lemon-o"><i class="fa fa-lemon-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-level-down"><i class="fa fa-level-down"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-level-up"><i class="fa fa-level-up"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-life-bouy"><i class="fa fa-life-bouy"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-life-ring"><i class="fa fa-life-ring"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-life-saver"><i class="fa fa-life-saver"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-lightbulb-o"><i class="fa fa-lightbulb-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-link"><i class="fa fa-link"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-linkedin"><i class="fa fa-linkedin"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-linkedin-square"><i class="fa fa-linkedin-square"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-linux"><i class="fa fa-linux"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-list"><i class="fa fa-list"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-list-alt"><i class="fa fa-list-alt"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-list-ol"><i class="fa fa-list-ol"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-list-ul"><i class="fa fa-list-ul"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-location-arrow"><i class="fa fa-location-arrow"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-lock"><i class="fa fa-lock"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-long-arrow-down"><i class="fa fa-long-arrow-down"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-long-arrow-left"><i class="fa fa-long-arrow-left"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-long-arrow-right"><i class="fa fa-long-arrow-right"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-long-arrow-up"><i class="fa fa-long-arrow-up"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-magic"><i class="fa fa-magic"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-magnet"><i class="fa fa-magnet"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-mail-forward"><i class="fa fa-mail-forward"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-mail-reply"><i class="fa fa-mail-reply"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-mail-reply-all"><i class="fa fa-mail-reply-all"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-male"><i class="fa fa-male"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-map-marker"><i class="fa fa-map-marker"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-maxcdn"><i class="fa fa-maxcdn"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-medkit"><i class="fa fa-medkit"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-meh-o"><i class="fa fa-meh-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-microphone"><i class="fa fa-microphone"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-microphone-slash"><i class="fa fa-microphone-slash"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-minus"><i class="fa fa-minus"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-minus-circle"><i class="fa fa-minus-circle"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-minus-square"><i class="fa fa-minus-square"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-minus-square-o"><i class="fa fa-minus-square-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-mobile"><i class="fa fa-mobile"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-mobile-phone"><i class="fa fa-mobile-phone"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-money"><i class="fa fa-money"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-moon-o"><i class="fa fa-moon-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-mortar-board"><i class="fa fa-mortar-board"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-music"><i class="fa fa-music"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-navicon"><i class="fa fa-navicon"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-openid"><i class="fa fa-openid"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-outdent"><i class="fa fa-outdent"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-pagelines"><i class="fa fa-pagelines"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-paper-plane"><i class="fa fa-paper-plane"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-paper-plane-o"><i class="fa fa-paper-plane-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-paperclip"><i class="fa fa-paperclip"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-paragraph"><i class="fa fa-paragraph"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-paste"><i class="fa fa-paste"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-pause"><i class="fa fa-pause"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-paw"><i class="fa fa-paw"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-pencil"><i class="fa fa-pencil"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-pencil-square"><i class="fa fa-pencil-square"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-pencil-square-o"><i class="fa fa-pencil-square-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-phone"><i class="fa fa-phone"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-phone-square"><i class="fa fa-phone-square"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-photo"><i class="fa fa-photo"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-picture-o"><i class="fa fa-picture-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-pied-piper"><i class="fa fa-pied-piper"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-pied-piper-alt"><i class="fa fa-pied-piper-alt"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-pied-piper-square"><i class="fa fa-pied-piper-square"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-pinterest"><i class="fa fa-pinterest"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-pinterest-square"><i class="fa fa-pinterest-square"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-plane"><i class="fa fa-plane"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-play"><i class="fa fa-play"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-play-circle"><i class="fa fa-play-circle"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-play-circle-o"><i class="fa fa-play-circle-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-plus"><i class="fa fa-plus"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-plus-circle"><i class="fa fa-plus-circle"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-plus-square"><i class="fa fa-plus-square"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-plus-square-o"><i class="fa fa-plus-square-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-power-off"><i class="fa fa-power-off"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-print"><i class="fa fa-print"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-puzzle-piece"><i class="fa fa-puzzle-piece"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-qq"><i class="fa fa-qq"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-qrcode"><i class="fa fa-qrcode"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-question"><i class="fa fa-question"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-question-circle"><i class="fa fa-question-circle"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-quote-left"><i class="fa fa-quote-left"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-quote-right"><i class="fa fa-quote-right"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-ra"><i class="fa fa-ra"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-random"><i class="fa fa-random"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-rebel"><i class="fa fa-rebel"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-recycle"><i class="fa fa-recycle"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-reddit"><i class="fa fa-reddit"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-reddit-square"><i class="fa fa-reddit-square"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-refresh"><i class="fa fa-refresh"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-renren"><i class="fa fa-renren"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-reorder"><i class="fa fa-reorder"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-repeat"><i class="fa fa-repeat"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-reply"><i class="fa fa-reply"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-reply-all"><i class="fa fa-reply-all"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-retweet"><i class="fa fa-retweet"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-rmb"><i class="fa fa-rmb"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-road"><i class="fa fa-road"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-rocket"><i class="fa fa-rocket"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-rotate-left"><i class="fa fa-rotate-left"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-rotate-right"><i class="fa fa-rotate-right"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-rouble"><i class="fa fa-rouble"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-rss"><i class="fa fa-rss"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-rss-square"><i class="fa fa-rss-square"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-rub"><i class="fa fa-rub"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-ruble"><i class="fa fa-ruble"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-rupee"><i class="fa fa-rupee"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-save"><i class="fa fa-save"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-scissors"><i class="fa fa-scissors"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-search"><i class="fa fa-search"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-search-minus"><i class="fa fa-search-minus"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-search-plus"><i class="fa fa-search-plus"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-send"><i class="fa fa-send"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-send-o"><i class="fa fa-send-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-share"><i class="fa fa-share"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-share-alt"><i class="fa fa-share-alt"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-share-alt-square"><i class="fa fa-share-alt-square"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-share-square"><i class="fa fa-share-square"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-share-square-o"><i class="fa fa-share-square-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-shield"><i class="fa fa-shield"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-shopping-cart"><i class="fa fa-shopping-cart"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-sign-in"><i class="fa fa-sign-in"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-sign-out"><i class="fa fa-sign-out"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-signal"><i class="fa fa-signal"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-sitemap"><i class="fa fa-sitemap"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-skype"><i class="fa fa-skype"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-slack"><i class="fa fa-slack"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-sliders"><i class="fa fa-sliders"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-smile-o"><i class="fa fa-smile-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-sort"><i class="fa fa-sort"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-sort-alpha-asc"><i class="fa fa-sort-alpha-asc"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-sort-alpha-desc"><i class="fa fa-sort-alpha-desc"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-sort-amount-asc"><i class="fa fa-sort-amount-asc"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-sort-amount-desc"><i class="fa fa-sort-amount-desc"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-sort-asc"><i class="fa fa-sort-asc"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-sort-desc"><i class="fa fa-sort-desc"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-sort-down"><i class="fa fa-sort-down"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-sort-numeric-asc"><i class="fa fa-sort-numeric-asc"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-sort-numeric-desc"><i class="fa fa-sort-numeric-desc"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-sort-up"><i class="fa fa-sort-up"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-soundcloud"><i class="fa fa-soundcloud"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-space-shuttle"><i class="fa fa-space-shuttle"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-spinner"><i class="fa fa-spinner"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-spoon"><i class="fa fa-spoon"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-spotify"><i class="fa fa-spotify"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-square"><i class="fa fa-square"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-square-o"><i class="fa fa-square-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-stack-exchange"><i class="fa fa-stack-exchange"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-stack-overflow"><i class="fa fa-stack-overflow"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-star"><i class="fa fa-star"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-star-half"><i class="fa fa-star-half"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-star-half-empty"><i class="fa fa-star-half-empty"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-star-half-full"><i class="fa fa-star-half-full"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-star-half-o"><i class="fa fa-star-half-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-star-o"><i class="fa fa-star-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-steam"><i class="fa fa-steam"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-steam-square"><i class="fa fa-steam-square"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-step-backward"><i class="fa fa-step-backward"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-step-forward"><i class="fa fa-step-forward"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-stethoscope"><i class="fa fa-stethoscope"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-stop"><i class="fa fa-stop"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-strikethrough"><i class="fa fa-strikethrough"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-stumbleupon"><i class="fa fa-stumbleupon"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-stumbleupon-circle"><i class="fa fa-stumbleupon-circle"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-subscript"><i class="fa fa-subscript"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-suitcase"><i class="fa fa-suitcase"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-sun-o"><i class="fa fa-sun-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-superscript"><i class="fa fa-superscript"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-support"><i class="fa fa-support"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-table"><i class="fa fa-table"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-tablet"><i class="fa fa-tablet"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-tachometer"><i class="fa fa-tachometer"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-tag"><i class="fa fa-tag"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-tags"><i class="fa fa-tags"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-tasks"><i class="fa fa-tasks"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-taxi"><i class="fa fa-taxi"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-tencent-weibo"><i class="fa fa-tencent-weibo"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-terminal"><i class="fa fa-terminal"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-text-height"><i class="fa fa-text-height"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-text-width"><i class="fa fa-text-width"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-th"><i class="fa fa-th"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-th-large"><i class="fa fa-th-large"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-th-list"><i class="fa fa-th-list"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-thumb-tack"><i class="fa fa-thumb-tack"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-thumbs-down"><i class="fa fa-thumbs-down"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-thumbs-o-down"><i class="fa fa-thumbs-o-down"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-thumbs-o-up"><i class="fa fa-thumbs-o-up"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-thumbs-up"><i class="fa fa-thumbs-up"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-ticket"><i class="fa fa-ticket"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-times"><i class="fa fa-times"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-times-circle"><i class="fa fa-times-circle"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-times-circle-o"><i class="fa fa-times-circle-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-tint"><i class="fa fa-tint"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-toggle-down"><i class="fa fa-toggle-down"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-toggle-left"><i class="fa fa-toggle-left"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-toggle-right"><i class="fa fa-toggle-right"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-toggle-up"><i class="fa fa-toggle-up"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-trash-o"><i class="fa fa-trash-o"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-tree"><i class="fa fa-tree"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-trello"><i class="fa fa-trello"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-trophy"><i class="fa fa-trophy"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-truck"><i class="fa fa-truck"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-try"><i class="fa fa-try"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-tumblr"><i class="fa fa-tumblr"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-tumblr-square"><i class="fa fa-tumblr-square"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-turkish-lira"><i class="fa fa-turkish-lira"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-twitter"><i class="fa fa-twitter"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-twitter-square"><i class="fa fa-twitter-square"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-umbrella"><i class="fa fa-umbrella"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-underline"><i class="fa fa-underline"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-undo"><i class="fa fa-undo"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-university"><i class="fa fa-university"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-unlink"><i class="fa fa-unlink"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-unlock"><i class="fa fa-unlock"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-unlock-alt"><i class="fa fa-unlock-alt"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-unsorted"><i class="fa fa-unsorted"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-upload"><i class="fa fa-upload"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-usd"><i class="fa fa-usd"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-user"><i class="fa fa-user"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-user-md"><i class="fa fa-user-md"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-users"><i class="fa fa-users"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-video-camera"><i class="fa fa-video-camera"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-vimeo-square"><i class="fa fa-vimeo-square"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-vine"><i class="fa fa-vine"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-vk"><i class="fa fa-vk"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-volume-down"><i class="fa fa-volume-down"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-volume-off"><i class="fa fa-volume-off"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-volume-up"><i class="fa fa-volume-up"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-warning"><i class="fa fa-warning"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-wechat"><i class="fa fa-wechat"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-weibo"><i class="fa fa-weibo"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-weixin"><i class="fa fa-weixin"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-wheelchair"><i class="fa fa-wheelchair"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-windows"><i class="fa fa-windows"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-won"><i class="fa fa-won"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-wordpress"><i class="fa fa-wordpress"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-wrench"><i class="fa fa-wrench"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-xing"><i class="fa fa-xing"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-xing-square"><i class="fa fa-xing-square"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-yahoo"><i class="fa fa-yahoo"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-yen"><i class="fa fa-yen"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-youtube"><i class="fa fa-youtube"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-youtube-play"><i class="fa fa-youtube-play"></i></a><a role="button" href="#" class="iconpicker-item" title=".fa-youtube-square"><i class="fa fa-youtube-square"></i></a></div></div></div></div></div> </div></div>')
})
