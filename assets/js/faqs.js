jQuery(function($){
	$(document).ready(function(){
		// FAQs Toggle
		$(".faq-title").click(function(){
			var $this = $(this);
			
			$this.toggleClass("active-faq").next().slideToggle("fast");
				return false;
			});
	}); // END doc ready
});// END function