<?php
/**
 * Creates a gallery metabox for WordPress
 *
 * Credits:
 * http://wordpress.org/plugins/easy-image-gallery/
 * https://github.com/woothemes/woocommerce
 *
 * @package Total WordPress Theme
 * @subpackage Framework
 * @version 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Start Class
if ( ! class_exists( 'WPEX_Gallery_Metabox' ) ) {

    class WPEX_Gallery_Metabox {
        private $config;
        private $post_types;
        private $assets_dir_uri;

        /**
         * Initialize the class and set its properties.
         *
         * @since 1.0.0
         */
        public function __construct() {

            // Get post types early on
            add_action( 'admin_init', array( $this, 'init' ) );

            // Add metabox
            add_action( 'add_meta_boxes', array( $this, 'add_meta' ) );

            // Save metabox
            add_action( 'save_post', array( $this, 'save_meta' ) );

            // Load needed scripts
            add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts' ) );

        }

        /**
         * Configure settings on init
         *
         * @since 1.0.0
         */
        public function init() {
            $this->config         = apply_filters( 'wpex_gallery_metabox_config', array() );
            $this->post_types     = isset( $this->config['post_types'] ) ? $this->config['post_types'] : array();
            $this->assets_dir_uri = isset( $this->config['dir_uri'] ) ? $this->config['dir_uri'] : get_template_directory_uri() . 'inc/framework/lib/';
        }

        /**
         * Adds the gallery metabox
         *
         * @since 1.0.0
         */
        public function add_meta( $post ) {

            if ( empty( $this->post_types ) ) {
                return;
            }

            foreach ( $this->post_types as $type ) {
                add_meta_box(
                    'wpex-gallery-metabox',
                    esc_html__( 'Image Gallery', 'earth' ),
                    array( $this, 'render' ),
                    $type,
                    'normal',
                    'high'
                );
            }

        }

        /**
         * Render the gallery metabox
         *
         * @since 1.0.0
         */
        public function render() {
            global $post; ?>
            <div id="wpex_gallery_images_container">
                <ul class="wpex_gallery_images">
                    <?php
                    $image_gallery = get_post_meta( $post->ID, '_easy_image_gallery', true );
                    $attachments = array_filter( explode( ',', $image_gallery ) );
                    if ( $attachments ) {
                        foreach ( $attachments as $attachment_id ) {
                            if ( wp_attachment_is_image ( $attachment_id  ) ) {
                                echo '<li class="image" data-attachment_id="' . $attachment_id . '"><div class="attachment-preview"><div class="thumbnail">
                                            ' . wp_get_attachment_image( $attachment_id, 'thumbnail' ) . '</div>
                                            <a href="#" class="wpex-gmb-remove" title="' . esc_html__( 'Remove image', 'earth' ) . '"><div class="media-modal-icon"></div></a>
                                        </div></li>';
                            }
                        }
                    } ?>
                </ul>
                <input type="hidden" id="image_gallery" name="image_gallery" value="<?php echo esc_attr( $image_gallery ); ?>" />
                <?php wp_nonce_field( 'easy_image_gallery', 'easy_image_gallery' ); ?>
            </div>
            <p class="add_wpex_gallery_images hide-if-no-js">
                <a href="#" class="button-primary"><?php esc_html_e( 'Add/Edit Images', 'earth' ); ?></a>
            </p>
            <p>
                <label for="easy_image_gallery_link_images">
                    <input type="checkbox" id="easy_image_gallery_link_images" value="on" name="easy_image_gallery_link_images"<?php echo checked( get_post_meta( get_the_ID(), '_easy_image_gallery_link_images', true ), 'on', false ); ?> /> <?php esc_html_e( 'Enable Lightbox for this gallery?', 'earth' )?>
                </label>
            </p>
        <?php
        }

        /**
         * Render the gallery metabox
         *
         * @since 1.0.0
         */
        public function save_meta( $post_id ) {

            // Check nonce
            if ( ! isset( $_POST[ 'easy_image_gallery' ] )
                || ! wp_verify_nonce( $_POST[ 'easy_image_gallery' ], 'easy_image_gallery' )
            ) {
                return;
            }

            // Check auto save
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return;
            }

            // Check user permissions
            $post_types = array( 'post' );
            if ( isset( $_POST['post_type'] ) && 'post' == $_POST['post_type'] ) {
                if ( ! current_user_can( 'edit_page', $post_id ) ) {
                    return;
                }
            } else {
                if ( ! current_user_can( 'edit_post', $post_id ) ) {
                    return;
                }
            }

            if ( isset( $_POST[ 'image_gallery' ] ) && !empty( $_POST[ 'image_gallery' ] ) ) {
                $attachment_ids = sanitize_text_field( $_POST['image_gallery'] );
                // Turn comma separated values into array
                $attachment_ids = explode( ',', $attachment_ids );
                // Clean the array
                $attachment_ids = array_filter( $attachment_ids  );
                // Return back to comma separated list with no trailing comma. This is common when deleting the images
                $attachment_ids =  implode( ',', $attachment_ids );
                update_post_meta( $post_id, '_easy_image_gallery', $attachment_ids );
            } else {
                // Delete gallery
                delete_post_meta( $post_id, '_easy_image_gallery' );
            }

            // link to larger images
            if ( isset( $_POST[ 'easy_image_gallery_link_images' ] ) ) {
                update_post_meta( $post_id, '_easy_image_gallery_link_images', $_POST[ 'easy_image_gallery_link_images' ] );
            } else {
                update_post_meta( $post_id, '_easy_image_gallery_link_images', 'off' );
            }

            // Add action
            do_action( 'wpex_save_gallery_metabox', $post_id );

        }

        /**
         * Load needed scripts
         *
         * @since 3.6.0
         */
        public function load_scripts( $hook ) {

            // Only needed on these admin screens
            if ( $hook != 'edit.php' && $hook != 'post.php' && $hook != 'post-new.php' ) {
                return;
            }

            // Get global post
            global $post;

            // Return if post is not object
            if ( ! is_object( $post ) ) {
                return;
            }

            // Return if wrong type or is VC live editor
            if ( ! in_array( $post->post_type, $this->post_types ) ) {
                return;
            }

            // CSS
            wp_enqueue_style(
                'earth-gmb-css',
                $this->assets_dir_uri . 'assets/wpex-gallery-metabox.css',
                false,
                EARTH_THEME_VERSION
            );

            // Load jquery sortable
            wp_enqueue_script( 'jquery-ui-sortable' );

            // Load metabox script
            wp_enqueue_script(
                'wpex-gmb-js',
                $this->assets_dir_uri . 'assets/wpex-gallery-metabox.js',
                array( 'jquery', 'jquery-ui-sortable' ),
                EARTH_THEME_VERSION,
                true
            );

            // Localize metabox script
            wp_localize_script( 'wpex-gmb-js', 'wpexGmb', array(
                'title'  => esc_html__( 'Add Images to Gallery', 'earth' ),
                'button' => esc_html__( 'Add to gallery', 'earth' ),
                'remove' => esc_html__( 'Remove image', 'earth' ),
            ) );

        }

    }

}

// Class needed only in the admin
if ( is_admin() ) {
    new WPEX_Gallery_Metabox;
}

/**
 * Check if the post has a gallery
 *
 * @since 3.0.0
 */
function wpex_post_has_gallery( $post_id = '' ) {
    $post_id = $post_id ? $post_id : get_the_ID();
    if ( get_post_meta( $post_id, '_easy_image_gallery', true ) ) {
        return true;
    }
}

/**
 * Retrieve attachment IDs
 *
 * @since 1.0.0
 */
function wpex_get_gallery_ids( $post_id = '' ) {
    $post_id = $post_id ? $post_id : get_the_ID();
    $attachment_ids = get_post_meta( $post_id, '_easy_image_gallery', true );
    if ( $attachment_ids ) {
        $attachment_ids = explode( ',', $attachment_ids );
        return array_filter( $attachment_ids );
    }
}

/**
 * Get array of gallery image urls
 *
 * @since 3.5.0
 */
function wpex_get_gallery_images( $post_id = '', $size = 'full' ) {
    $post_id = $post_id ? $post_id : get_the_ID();
    $ids     = wpex_get_gallery_ids( $post_id );
    if ( ! $ids ) {
        return;
    }
    $images = array();
    foreach ( $ids as $id ) {
        $img_url = wpex_image_resize( array(
            'attachment' => $id,
            'size'       => $size,
            'return'     => 'url',
        ) );
        if ( $img_url ) {
            $images[] = $img_url;
        }
    }
    return $images;
}

/**
 * Return gallery count
 *
 * @since 1.0.0
 */
function wpex_gallery_count( $post_id = '' ) {
    $ids = wpex_get_gallery_ids( $post_id );
    return count( $ids );
}

/**
 * Check if lightbox is enabled
 *
 * @since 1.0.0
 */
function wpex_gallery_is_lightbox_enabled( $post_id = '' ) {
    $post_id = $post_id ? $post_id : get_the_ID();
    if ( 'on' == get_post_meta( $post_id, '_easy_image_gallery_link_images', true ) ) {
        return true;
    }
}