/*-----------------------------------------------------------------------------------*/
/* Calendar Events
/*===================================================================================*/
jQuery(function($){
	
	//start calendar JS
	function getMonthname($digits) {
	
		var month=new Array();
			month[1]="Jan";
			month[2]="Feb";
			month[3]="Mar";
			month[4]="Apr";
			month[5]="May";
			month[6]="Jun";
			month[7]="Jul";
			month[8]="Aug";
			month[9]="Sep";
			month[10]="Oct";
			month[11]="Nov";
			month[12]="Dec";
		return month[$digits];
	
	}
	
	//dropdown select get calendar
	$("#cal-trigger #submit").live('click', function() {
		
		$("#ajax-loader").show(); // show ajax loader
	
		var ajaxurl = aqvars.ajaxurl;
		var serialized = $('#cal-trigger').serialize();
		var nonce = $('#security').val();
		
		var data = {		
			action: 'get_calendar',
			security: nonce,
			data: serialized	
		};
		
		$.post(ajaxurl, data, function(response) {
			
			$("#ajax-loader").hide(); // hide ajax loader
			$('#events_calendar').html(response); //replace calendar
			
		});
		
		return false;
	});
	
	//next month button
	$("#cal-nav #cal-next").live('click', function() {
		
		$("#ajax-loader").show(); // show ajax loader
		
		var ajaxurl = aqvars.ajaxurl;
		var serialized = $('#cal-next_val').serialize();
		var nonce = $('#security').val();
		
		var data = {		
			action: 'get_calendar',
			security: nonce,
			data: serialized
		};
		
		$.post(ajaxurl, data, function(response) {
		
			$("#ajax-loader").hide(); // hide ajax loader
			$('#events_calendar').html(response); //replace calendar
			
		});
		
		return false;
	});
		
	//prev month button
	$("#cal-nav #cal-prev").live('click', function() {
		
		$("#ajax-loader").show(); // show ajax loader
		
		var ajaxurl = aqvars.ajaxurl;
		var serialized = $('#cal-prev_val').serialize();
		var nonce = $('#security').val();
		
		var data = {		
			action: 'get_calendar',
			security: nonce,
			data: serialized
		};
		
		$.post(ajaxurl, data, function(response) {
			
			$("#ajax-loader").hide(); // hide ajax loader
			$('#events_calendar').html(response); //replace calendar
			
		});
		
		return false;
	});
	
	
});// END function