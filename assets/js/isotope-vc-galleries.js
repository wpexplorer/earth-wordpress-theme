(function($) {
	"use strict";

		function wpexFilterGalleries() {
			if ( $('.isotope-grid').length ) {
				$('.isotope-grid').each( function () {
					// Initialize isotope
					var $container = $(this);
					$container.isotope({
						itemSelector: '.isotope-entry'
					});
					// Isotope filter links
					var $filter = $container.prev('.galleries-filter');
					var $filterLinks = $filter.find('a');
					$filterLinks.each( function() {
						var $filterableDiv = $(this).data('filter');
						if ( $filterableDiv !== '*' && ! $container.find($filterableDiv).length ) {
							$(this).parent().hide('100');
						}
					});
					$filterLinks.css({ opacity: 1 } );
					$filterLinks.click(function(){
					var selector = $(this).attr('data-filter');
						$container.isotope({
							filter: selector
						});
						$(this).parents('ul').find('li').removeClass('active');
						$(this).parent('li').addClass('active');
					return false;
					});
				});
			}
		}

		$('#wrapper').imagesLoaded(function(){
			wpexFilterGalleries();
		});

		// Run or re-run functions on resize and orientation change
		var isIE8 = $.browser.msie && +$.browser.version === 8;
		if (isIE8) {
			document.body.onresize = function () {
				wpexFilterGalleries();
			};
		} else {
			$(window).resize(function () {
				wpexFilterGalleries();
			});
			window.addEventListener("orientationchange", function() {
				wpexFilterGalleries();
			});
		}

})(jQuery);