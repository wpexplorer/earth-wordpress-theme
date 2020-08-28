jQuery(function($){
	$(window).load(function() {
		
		// cache container
		var $container = $('#gallery-wrap');
		// initialize isotope
		$container.isotope({
		  // options...
		});
	
		
		// filter items when filter link is clicked
		$('.filter a').click(function(){
			
		  var selector = $(this).attr('data-filter');
		  	$container.isotope({ filter: selector });
			$(this).parents('ul').find('a').removeClass('active');
			$(this).addClass('active');
		  return false;
		});
		
		
		$(window).resize(function () {
		
			// cache container
			var $container = $('#gallery-wrap');
			// initialize isotope
			$container.isotope({
			  // options...
			});
		
			
			// filter items when filter link is clicked
			$('.filter a').click(function(){
				
			  var selector = $(this).attr('data-filter');
				$container.isotope({ filter: selector });
				$(this).parents('ul').find('a').removeClass('active');
				$(this).addClass('active');
			  return false;
			});
		
		}); // END resize
		
	}); // END window ready
}); // END function

