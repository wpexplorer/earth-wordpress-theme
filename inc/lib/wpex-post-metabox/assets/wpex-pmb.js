( function( $ ) {

	"use strict";

	$( document ).on( 'ready', function() {

		// Date picker
		if ( $.fn.datepicker ) {
			$( '.wpex-mb-date-field' ).datepicker( {
				dateFormat: wpexMB.dateFormat
			} );
		}

		// Time picker
		if ( $.fn.timepicker ) {
			$( '.wpex-mb-time-field' ).timepicker( {
				startTime    : "07:00",
				endTime      : "22:00",
				show24Hours  : false,
				separator    : ':',
				step         : 30
			} );
		}

		/* Alter event end date when start date is changed
		$( '#earth_event_startdate' ).change( function() {
			$( '#earth_event_enddate' ).val( $( this ).val() );
		} );*/

		// Tabs
		$( 'div#wpex-metabox ul.wp-tab-bar a').click( function() {
			var lis = $( '#wpex-metabox ul.wp-tab-bar li' ),
				data = $( this ).data( 'tab' ),
				tabs = $( '#wpex-metabox div.wp-tab-panel');
			$( lis ).removeClass( 'wp-tab-active' );
			$( tabs ).hide();
			$( data ).show();
			$( this ).parent( 'li' ).addClass( 'wp-tab-active' );
			return false;
		} );

		// Color picker
		$( '.wpex-mb-color-field' ).wpColorPicker();

		// Media uploader
		var _custom_media = true,
		_orig_send_attachment = wp.media.editor.send.attachment;

		$( '.wpex-mb-uploader' ).click( function( e ) {

			var send_attachment_bkp	= wp.media.editor.send.attachment,
				button = $(this),
				id = button.prev();
			wp.media.editor.send.attachment = function( props, attachment ) {
				if ( _custom_media ) {
					$( id ).val( attachment.id );
				} else {
					return _orig_send_attachment.apply( this, [props, attachment] );
				}
			};
			wp.media.editor.open( button );
			return false;
		} );

		$( 'div#wpex-metabox .add_media' ).on('click', function() {
			_custom_media = false;
		} );

	} );

} ) ( jQuery );