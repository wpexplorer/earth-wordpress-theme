<div class="wrap" id="of_container">

	<div id="of-popup-save" class="of-save-popup">
		<div class="of-save-save"><?php esc_html_e( 'Options Updated', 'earth' ); ?></div>
	</div>

	<div id="of-popup-reset" class="of-save-popup">
		<div class="of-save-reset"><?php esc_html_e( 'Options Reset', 'earth' ); ?></div>
	</div>

	<div id="of-popup-fail" class="of-save-popup">
		<div class="of-save-fail"><?php esc_html_e( 'Error!', 'earth' ); ?></div>
	</div>

	<span style="display: none;" id="hooks"><?php echo json_encode(of_get_header_classes_array()); ?></span>
	<input type="hidden" id="reset" value="<?php if (isset($_REQUEST['reset'])) echo esc_attr( $_REQUEST['reset'] ); ?>" />
	<input type="hidden" id="security" name="security" value="<?php echo wp_create_nonce('of_ajax_nonce'); ?>" />

	<form id="of_form" method="post" action="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ) ?>" enctype="multipart/form-data" >

		<div id="header">

			<div class="logo">
				<h3><?php esc_html_e( 'Theme Settings', 'earth') ?></h3>
			</div>

			<div id="js-warning"><?php esc_html_e( 'Warning- This options panel will not work properly without javascript!', 'earth' ); ?></div>
			<div class="icon-option"></div>
			<div class="clear"></div>

    	</div>

		<div id="info_bar">

			<a>
				<div id="expand_options" class="expand"><?php esc_html_e( 'Expand', 'earth' ); ?></div>
			</a>

			<img style="display:none" src="<?php echo ADMIN_DIR; ?>assets/images/loading-bottom.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="<?php esc_html_e( 'Working...', 'earth' ); ?>" />

			<button id="of_save" type="button" class="button-primary">
				<?php esc_html_e( 'Save All Changes', 'earth' );?>
			</button>

		</div><!--.info_bar-->

		<div id="main">

			<div id="of-nav">
				<ul>
				  <?php echo $options_machine->Menu; ?>
				</ul>
			</div>

			<div id="content">
		  		<?php echo $options_machine->Inputs; ?>
		  	</div>

			<div class="clear"></div>

		</div>

		<div class="save_bar">

			<button id ="of_reset" type="button" class="button submit-button reset-button" ><?php esc_html_e( 'Options Reset', 'earth' );?></button>
			<img style="display:none" src="<?php echo ADMIN_DIR; ?>assets/images/loading-bottom.gif" class="ajax-reset-loading-img ajax-loading-img-bottom" alt="Working..." />

		</div><!--.save_bar-->

	</form>

	<div style="clear:both;"></div>

</div><!--wrap-->