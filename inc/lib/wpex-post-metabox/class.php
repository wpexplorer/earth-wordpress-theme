<?php
/**
 * WPExplorer Custom Metabox Class
 *
 * @version 1.0
 * @license All rights reserved
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// The Metabox class
class WPEX_Post_Metabox {
	private $options        = array();
	private $post_types     = array();
	private $assets_dir_uri = '';

	/**
	 * Register this class with the WordPress API
	 *
	 * @since 1.0
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'init' ) );
	}

	/**
	 * The function responsible for creating the actual meta box.
	 *
	 * @since 1.0
	 */
	public function init() {

		// Get correct assets dir uri
		$this->assets_dir_uri = apply_filters(
			'wpex_post_metabox_assets_dir_uri',
			get_template_directory_uri() . '/inc/lib/wpex-post-metabox/assets/'
		);

		// Get options
		$this->options = apply_filters( 'wpex_post_meta_options', array() );

		// Return if there aren't any options defined
		if ( empty( $this->options ) ) {
			return;
		}

		// Types
		$get_types = wp_list_pluck( $this->options, 'post_types' );

		// Post types are required
		if ( empty( $get_types ) ) {
			return;
		}

		// Loop through all tabs and make array unique
		foreach( $get_types as $tab => $types ) {
			foreach ( $types as $type ) {
				if ( isset( $this->post_types[$type] ) ) {
					continue;
				}
				$this->post_types[] = $type;
			}
		}

		// Loop through post types and add metabox to corresponding post types
		foreach( $this->post_types as $type ) {
			add_action( 'add_meta_boxes_'. $type, array( $this, 'post_meta' ), 10 );
		}

		// Save meta
		add_action( 'save_post', array( $this, 'save_meta_data' ) );

		// Load scripts for the metabox
		add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts' ) );

	}

	/**
	 * The function responsible for creating the actual meta box.
	 *
	 * @since 1.0
	 */
	public function post_meta( $post ) {
		$obj = get_post_type_object( $post->post_type );
		add_meta_box(
			'wpex-metabox',
			$obj->labels->singular_name . ' '. esc_html__( 'Settings', 'earth' ),
			array( $this, 'display_meta_box' ),
			$post->post_type,
			'normal',
			'high'
		);
	}

	/**
	 * Enqueue scripts and styles needed for the metaboxes
	 *
	 * @since 1.0
	 */
	public function load_scripts( $hook ) {

		// Only needed on these admin screens
		if ( $hook != 'edit.php' && $hook != 'post.php' && $hook != 'post-new.php' ) {
			return;
		}

		// Get global post
		global $post;

		// Return if post is not object or it's the wrong type
		if ( ! is_object( $post ) || ! in_array( $post->post_type, $this->post_types ) ) {
			return;
		}

		// Enqueue metabox css
		wp_enqueue_style(
			'wpex-post-metabox',
			$this->assets_dir_uri . 'wpex-pmb.css',
			array(),
			EARTH_THEME_VERSION
		);

		// Enqueue media js
		wp_enqueue_media();

		// Enqueue color picker
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );

		// Enqueue metabox js
		wp_enqueue_script(
			'wpex-post-metabox',
			$this->assets_dir_uri . 'wpex-pmb.js',
			array( 'jquery', 'wp-color-picker' ),
			EARTH_THEME_VERSION,
			true
		);

		wp_localize_script( 'wpex-post-metabox', 'wpexMB', array(
			'reset'      => esc_html__(  'Reset Settings', 'earth' ),
			'cancel'     => esc_html__(  'Cancel Reset', 'earth' ),
			'dateFormat' => earth_convert_php_date_format_to_jquery( earth_get_event_date_format() ),
		) );

	}

	/**
	 * Renders the content of the meta box.
	 *
	 * @since 1.0
	 */
	public function display_meta_box( $post ) {

		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'wpex_metabox', 'wpex_metabox_nonce' );

		// Get current post data
		$post_id   = $post->ID;
		$post_type = get_post_type();

		// Get options
		$options = $this->options;

		// Empty notice
		$empty_notice = '<p>'. esc_html__( 'No meta options available for this post type or user.', 'earth' ) .'</p>';

		// Settings required
		if ( empty( $options ) ) {
			echo wp_kses_post( $empty_notice );
			return;
		}

		// Store tabs that should display on this specific page in an array for use later
		$active_tabs = array();
		$display_tab = false;
		foreach ( $options as $tab => $ops ) {
			if ( in_array( $post_type, $ops['post_types'] ) ) {
				$active_tabs[$tab] = $ops;
			}
		}

		// No active tabs
		if ( empty( $active_tabs ) ) {
			exit;
			echo wp_kses_post( $empty_notice );
			return;
		}

		// Get tab count
		$tab_count = count( $active_tabs );

		// Display tabs only if there is more than 1
		if ( $tab_count > 1 ) { ?>

			<ul class="wp-tab-bar">
				<?php
				// Output tab links
				$wpex_count = '';
				foreach ( $active_tabs as $tab ) {
					$wpex_count++;
					// Define tab title
					$tab_title = $tab['title'] ? $tab['title'] : esc_html__( 'Other', 'earth' ); ?>
					<li<?php if ( '1' == $wpex_count ) echo ' class="wp-tab-active"'; ?>>
						<a href="javascript:;" data-tab="#wpex-mb-tab-<?php echo intval( $wpex_count ); ?>"><?php echo esc_html( $tab_title ); ?></a>
					</li>
				<?php } ?>
			</ul><!-- .wpex-mb-tabnav -->

		<?php }

		// Output tab sections
		$wpex_count = '';

		foreach ( $active_tabs as $tab ) {

			$wpex_count++;

			// Wrap classes
			$wrap_classes = 'wpex-metabox-fields clr';
			if ( $tab_count > 1 ) {
				$wrap_classes .= ' wp-tab-panel';
			} else {
				$wrap_classes .= ' wpex-no-tabs';
			} ?>

			<div id="wpex-mb-tab-<?php echo intval( $wpex_count ); ?>" class="<?php echo esc_attr( $wrap_classes ); ?>">

				<table class="form-table">

					<?php
					// Loop through sections and store meta output
					foreach ( $tab['fields'] as $field ) {

						// Defaults
						$defaults = array(
							'name'   => esc_html( 'Field Name', 'earth' ),
							'std'    => '',
							'desc'   => '',
							'hidden' => false,
							'id'     => '',
							'type'   => '',
						);

						// Parse and extract
						$field = wp_parse_args( $field, $defaults );

						// Get field values
						$value = get_post_meta( $post_id, $field['id'], true );
						$value = $value ? $value : $field['std'];
						$value = $this->sanitize_value( $value, $field['type'], 'display' ); ?>

						<tr<?php if ( $field['hidden'] ) echo ' style="display:none;"'; ?> id="<?php echo esc_attr( $field['id'] ); ?>_tr">
							
							<th>
								
								<label for="wpex_main_layout"><strong><?php echo esc_html( $field['name'] ); ?></strong></label>
								
								<?php
								// Display field description
								if ( ! empty( $field['desc'] ) ) { ?>
									<p class="wpex-mb-description"><?php echo wp_kses_post( $field['desc'] ); ?></p>
								<?php } ?>

							</th>

							<?php
							// Output field type
							$method = 'field_' . $field['type'];
							if ( method_exists( $this, $method ) ) {
								echo '<td>' . $this->$method( $field, $value, $post ) . '</td>';
							} ?>

						</tr>

					<?php } ?>

				</table>

			</div>

		<?php } ?>

		<div class="clear"></div>

	<?php }

	/**
	 * Field Text
	 *
	 * @since 1.0
	 */
	public function field_text( $field, $value ) {
		echo '<td><input name="' . esc_attr( $field['id'] ) . '" type="text" value="' . $value . '" id="' . esc_attr( $field['id'] ) . '"></td>';
	}

	/**
	 * Field Date
	 *
	 * @since 1.0
	 */
	public function field_date( $field, $value, $post ) {

		wp_enqueue_script( 'jquery-ui' );

		wp_enqueue_script( 'jquery-ui-datepicker' );

		wp_enqueue_style(
			'jquery-ui-datepicker-style',
			'//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css'
		);

		if ( ! $value && 'earth_event_startdate' == $field['id'] ) {
			$deprecated_date = get_post_meta( $post->ID, 'timestamp_earth_event_start_date', true );
			$deprecated_date = $this->sanitize_value( $deprecated_date, $field['type'], 'display' );
			$value = $deprecated_date ? $deprecated_date : $value;
		}

		echo '<td>';

		echo '<input class="wpex-mb-date-field" name="' . esc_attr( $field['id'] ) . '" type="text" value="' . $value . '" id="' . esc_attr( $field['id'] ) . '">';

		echo '</td>';

	}

	/**
	 * Field Number
	 *
	 * @since 1.0
	 */
	public function field_number( $field, $value ) {

		$step = isset( $field['step'] ) ? floatval( $field['step'] ) : 1;
		$min  = isset( $field['min'] ) ? floatval( $field['min'] ) : 1;
		$max  = isset( $field['max'] ) ? floatval( $field['max'] ) : 10;

		echo '<td><input name="' . esc_attr( $field['id'] ) . '" type="number" value="' .  $value . '" step="' . $step . '" min="<?php echo floatval( $min ); ?>" max="<?php echo floatval( $max ); ?>" id="' . esc_attr( $field['id'] ) . '"></td>';

	}

	/**
	 * Field Text HTMl
	 *
	 * @since 1.0
	 */
	public function field_text_html( $field, $value ) {
		echo '<td><pre><textarea rows="1" name="' . esc_attr( $field['id'] ) . '" id="' . esc_attr( $field['id'] ) . '">' . esc_html( $value ) . '</textarea></pre></td>';
	}

	/**
	 * Field URL
	 *
	 * @since 1.0
	 */
	public function field_url( $field, $value ) {
		echo '<td><input name="' . esc_attr( $field['id'] ) . '" type="url" value="' . $value . '" id="' . esc_attr( $field['id'] ) . '"></td>';
	}

	/**
	 * Field Textarea
	 *
	 * @since 1.0
	 */
	public function field_textarea( $field, $value ) {
		$rows = isset ( $field['rows'] ) ? $field['rows'] : 4;
		echo '<td>';
		echo '<textarea rows="' . $rows . '" name="' . esc_attr( $field['id'] ) . '" id="' . esc_attr( $field['id'] ) . '">' . $value . '</textarea>';
		if ( 'earth_event_location_address' == $field['id'] && ! earth_get_option( 'google_api_key' ) ) {
			echo '<br />';
			echo '<div style="font-size:0.9em;"><strong>' . esc_html__( 'Important:', 'earth' ) . '</strong> ' .  esc_html__( 'You must first enter your Google Maps API key in the theme options panel in order to use this setting', 'earth' ) . '</div>';
		}
		echo '</td>';
	}

	/**
	 * Field Code
	 *
	 * @since 1.0
	 */
	public function field_code( $field, $value ) {
		$rows = isset ( $field['rows'] ) ? $field['rows'] : 1;
		$cols = isset ( $field['cols'] ) ? $field['cols'] : 1;
		echo '<td><pre><textarea rows="' . $rows . '" cols="' . $cols . '" name="' . esc_attr( $field['id'] ) . '" class="wpex-mb-textarea-code" id="' . esc_attr( $field['id'] ) . '">' . $value . '</textarea></pre></td>';
	}

	/**
	 * Field Checkbox
	 *
	 * @since 1.0
	 */
	public function field_checkbox( $field, $value ) {
		$value   = ( 'on' != $value ) ? false : true;
		$checked = checked( $value, true, false );
		echo '<td><input name="' . esc_attr( $field['id'] ) . '" type="checkbox" ' . $checked . ' id="' . esc_attr( $field['id'] ) . '"></td>';
	}

	/**
	 * Field Select
	 *
	 * @since 1.0
	 */
	public function field_select( $field, $value ) {
		
		$choices = isset ( $field['choices'] ) ? $field['choices'] : array();
		
		if ( empty( $choices ) ) {
			return;
		}

		echo '<td><select id="' . esc_attr( $field['id'] ) . '" name="' . esc_attr( $field['id'] ) . '">';
		
			foreach ( $choices as $choice_v => $name ) {

				$selected = selected( $value, $choice_v, false );
				
				echo '<option value="' .  esc_attr( $choice_v ) . '" ' . $selected . '>' . esc_html( $name ) . '</option>';

			}

		echo '</select></td>';

	}

	/**
	 * Field Color
	 *
	 * @since 1.0
	 */
	public function field_color( $field, $value ) {
		echo '<td><input name="' . esc_attr( $field['id'] ) . '" type="url" value="' . $value . '" class="wpex-mb-color-field" id="' . esc_attr( $field['id'] ) . '"></td>';
	}

	/**
	 * Field Media
	 *
	 * @since 1.0
	 */
	public function field_media( $field, $value ) {
		echo '<td>';
			echo '<div class="uploader">';
			echo '<input type="text" name="' . esc_attr( $field['id'] ) . '" value="' . $value. '" id="' . esc_attr( $field['id'] ) . '">';
			echo '<input class="wpex-mb-uploader button-secondary" name="' . esc_attr( $field['id'] ) . '" type="button" value="'. esc_html__( 'Upload', 'earth' ) . '" />';
			echo '</div>';
		echo '</td>';
	}

	/**
	 * Field Editor
	 *
	 * @since 1.0
	 */
	public function field_editor( $field, $value ) { ?>

		<td>

		<?php wp_editor( $value, $field['id'], array(
			'textarea_name' => $field['id'],
			'teeny'         => isset( $field['teeny'] ) ? $field['teeny'] : false,
			'textarea_rows' => isset( $field['rows'] ) ? intval( $field['rows'] ) : 10,
			'media_buttons' => isset( $field['media_buttons'] ) ? $field['media_buttons'] : true,
		) ); ?>

		</td>

		<?php

	}

	/**
	 * Field Time
	 *
	 * @since 1.0
	 */
	public function field_time( $field, $value ) {

		wp_enqueue_script( 'jquery' );

		wp_enqueue_script(
			'jquery-timepicker',
			$this->assets_dir_uri . 'jquery.timepicker.min.js',
			array( 'jquery' ),
			defined( EARTH_THEME_VERSION ) ? EARTH_THEME_VERSION : '',
			true
		);

		echo '<td><input name="' . esc_attr( $field['id'] ) . '" type="text" value="' . $value . '" class="wpex-mb-time-field" id="' . esc_attr( $field['id'] ) . '"></td>';
	}

	/**
	 * Sanitize values
	 *
	 * @since 1.0
	 */
	public function sanitize_value( $value, $type, $action = '' ) {
		if ( 'text' == $type || 'time' == $type ) {
			$value = sanitize_text_field( $value );
		} elseif ( 'text_html' == $type ) {
			$value = wp_kses_post( $value );
		} elseif ( 'textarea' == $type ) {
			$value = esc_textarea( $value );
		} elseif ( 'code' == $type ) {
			if ( 'display' == $action ) {
				$value = esc_textarea( $value );
			}
		} elseif ( 'color' == $type ) {
			if ( function_exists( 'sanitize_hex_color' ) ) {
				$value = sanitize_hex_color( $value );
			} else {
				$value = esc_attr( $value );
			}
		} elseif ( 'link' == $type ) {
			$value = esc_url( $value );
		} elseif ( 'number' == $type ) {
			$value = floatval( $value );
		} elseif ( 'select' == $type ) {
			$value = ( 'default' == $value ) ? '' : sanitize_text_field( $value );
		} elseif ( 'media' == $type ) {
			$value = intval( $value ); // Value should be an ID
		} if ( 'editor' == $type ) {
			$value = ( '<p><br data-mce-bogus="1"></p>' == $value ) ? '' : $value;
			$value = wp_kses_post( $value );
		} elseif ( 'date' == $type ) {
			if ( 'save' == $action ) {
				$value = $value ? strtotime( str_replace( '/', '-', esc_attr( $value ) ) ) : '';
			} else {
				$value = $value ? date_i18n( earth_get_event_date_format(), esc_attr( $value ) ) : '';
			}
		}
		return $value;
	}

	/**
	 * Save metabox data
	 *
	 * @since 1.0
	 */
	public function save_meta_data( $post_id ) {

		/*
		 * We need to verify this came from our screen and with proper authorization,
		 * because the save_post action can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['wpex_metabox_nonce'] ) ) {
			return;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['wpex_metabox_nonce'], 'wpex_metabox' ) ) {
			return;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		/* OK, it's safe for us to save the data now. Now we can loop through fields */

		// Check reset field
		$reset = isset( $_POST['wpex_metabox_reset'] ) ? $_POST['wpex_metabox_reset'] : '';

		// Get array of fields to save
		$options = $this->options;
		if ( empty( $options ) ) {
			return;
		}
		$fields = array();
		foreach( $options as $tab ) {
			foreach ( $tab['fields'] as $field ) {
				$fields[] = $field;
			}
		}

		// Return if fields are empty
		if ( empty( $fields ) ) {
			return;
		}

		// Loop through options and validate
		foreach ( $fields as $field ) {

			// Define loop main vars
			$value = '';
			$id    = $field['id'];

			// Make sure field exists and if so validate the data
			if ( isset( $_POST[$id] ) ) {

				// Get and sanitize value
				$value = $this->sanitize_value( $_POST[$id], $field['type'], 'save' );
				
				// Update meta if value exists
				if ( $value && 'on' != $reset ) {
					update_post_meta( $post_id, $id, $value );
				}

				// Otherwise cleanup stuff
				else {
					delete_post_meta( $post_id, $id );
				}
			}

		}

	}

}
new WPEX_Post_Metabox();