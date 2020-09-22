jQuery( function($)  {

	$(document).ready( function() {
		earthSuperfish();
		earthTooltips();
		earthFlickrEmbeds();
		earthScrollTopLink();
		earthToggles();
		earthLightbox();
		earthMobileNav();
	} );

	$(window).load(function()  {
		$( 'div#slider-wrap' ).removeClass( 'slides-loading' );
		$( 'span.oembed-loader' ).hide();
		$( 'div.hide-on-ready' ).css( {
			opacity: '1'
		} );
	} );

	// Superfish dropdowns
	function earthSuperfish() {
		if ( 'undefined' === typeof $.fn.superfish ) {
			console.log( 'superfish is undefined' );
			return;
		}
		$( '#mainnav ul.sf-menu' ).superfish( {
			autoArrows : false,
			speed      : 200,
			delay      : 200,
			animation  : {
				opacity :'show',
				height  :'show'
			}
		} );
	}

	// Tooltips
	function earthTooltips() {
		if ( 'undefined' === typeof $.fn.tipsy ) {
			console.log( 'tipsy is undefined' );
			return;
		}
		$('.tipsy-tooltip').tipsy( {
			fade: true,
			gravity: 's'
		} );
	}

	// Flickr embeds
	function earthFlickrEmbeds() {
		// Transparency
		$( '#flickr-slideshow-wrap object' ).each(function()  {
			$(this).prepend('<param name="wmode" value="transparent">');
			var flashHtml = $(this).html().replace ('<embed ', '<embed wmode="transparent"');
			$(this).html('');
			$(this).html(flashHtml);
		} );

		// Params
		$( document.createElement ('param') ).attr("name", "wmode").attr("value", "transparent").appendTo("#flickr-slideshow-wrap object");
	}

	// ScrollTop link
	function earthScrollTopLink() {

		var $scrollTopLink = $( 'a.backup' );
		if ( $scrollTopLink.length ) {
			$(window).scroll( function () {
				if ($(this).scrollTop() > 100 ) {
					$scrollTopLink.addClass( 'visible' );
				} else {
					$scrollTopLink.removeClass( 'visible' );
				}
			} );
			$scrollTopLink.on('click', function()  {
				$('html, body').animate({scrollTop:0}, 200);
				return false;
			} );
		}

	}

	// Toggles
	function earthToggles() {
		$( 'h3.trigger' ).click(function()  {
			$(this).toggleClass( 'active' ).next().slideToggle( 'fast' );
			return false;
		} );
	}

	// Lightbox
	function earthLightbox() {

		if ( 'undefined' === typeof $.fn.magnificPopup ) {
			console.log( 'magnificPopup is undefined' );
			return;
		}

		$( '.earth-lightbox' ).magnificPopup({ type: 'image' } );
		$( '.earth-lightbox-gallery' ).each(function() {
			$(this).magnificPopup({
				delegate: 'a',
				type: 'image',
				gallery:{enabled:true}
			} );
		} );

	}

	// Mobile nav
	function earthMobileNav() {

		if ( 'undefined' === typeof $.fn.uniform ) {
			console.log( 'uniform is undefined' );
			return;
		}

		if ( $('.earth-responsive').width() ) {
			$('<div class="mobile-menu-select"><select></select></div>').appendTo("#mainnav");
			$("<option />", {
				"selected": "selected",
				"value" : "",
				"text" : earthVars.responsiveMenuText
			}).appendTo(".mobile-menu-select select");

			$("#mainnav a").each(function() {
				var el = $(this);
				if (el.parents('.sub-menu').length >= 1) {
					$('<option />', {
					 'value' : el.attr("href"),
					 'text' : '- ' + el.text()
					}).appendTo(".mobile-menu-select select");
				}
				else if (el.parents('.sub-menu .sub-menu').length >= 1) {
					$('<option />', {
					 'value' : el.attr('href'),
					 'text' : '-- ' + el.text()
					} ).appendTo(".mobile-menu-select select");
				}
				else {
					$('<option />', {
					 'value' : el.attr('href'),
					 'text' : el.text()
					}).appendTo(".mobile-menu-select select");
				}
			} );
			$(".mobile-menu-select select").change( function() {
				window.location = $(this).find("option:selected").val();
			} );

			$(".mobile-menu-select select").uniform();
		}

	}

} );