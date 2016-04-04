<?php

/**
* Slider Options
*/
add_action( 'tf_create_options', 'wpscr_metabox' );
function wpscr_metabox() {
	$titan = TitanFramework::getInstance( 'wpscr' );
	
	$metaBox = $titan->createMetaBox( array(
		'name' => 'Slider Options',
		'post_type' => 'slider'
		) );

	$options = wpscr_gallery_options();

	foreach ( $options as $option ) {
		$metaBox->createOption( $option );
	}	
}

/**
 * Force users to specify slider size
 */
add_action('admin_notices', 'wpscr_check_slider_size');
function wpscr_check_slider_size() {
	global $pagenow;

	// Check if we are creating a new slider
	if (($_GET['post_type'] == 'slider') && $pagenow == 'post-new.php') {

		$class = 'notice notice-error';
		$notice = __( 'To upload pictures, you first need to specify the slider’s size (width and height). <a href="#">Learn why &rarr;</a>', WPSCR_I18NDOMAIN );

		// Customize the UI
		echo '<style>#postdivrich { display: none; } #wpscr_shortcode_metabox { opacity: 0.5; } #wpscr_shortcode_metabox * { cursor: not-allowed; }</style>';

		// Add notice
		printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $notice );
	
	}
}

/**
 * Side Metabox displaying Shortcode
 */
add_action('add_meta_boxes', 'wpscr_add_shortcode_metabox');
function wpscr_add_shortcode_metabox() {
	add_meta_box(
		'wpscr_shortcode_metabox',
		'Slider Shortcode',
		'wpscr_shortcode_metabox',
		'slider',
		'side',
		'low'
		);
}

function wpscr_shortcode_metabox() {
	if( isset( $_GET["post"] ) ){

		// Array to shortcode conversion
		$id = trim($_GET["post"]);
		$sc_attr = array( 'id' => $id );
		$params = array();
		$sc_code = "";
		$array = wpscr_get_gallery_options( $id );

		foreach ($array as $key => $attr) {
			if( empty($attr) ) {
				continue;
			}

			if ( is_bool($attr) ) {
				$attr = $attr ? 'true' : 'false';
			}

			$sc_attr[$key] = $attr;

		}

		foreach ( $sc_attr as $attr => $value ) {
			$params[] = sprintf( '%1$s="%2$s"', $attr, $value );
		}

		$sc_code = sprintf( '[slick_carousel %s]', implode( ' ', $params ) );
	}
	?>

	<p><?php _e( 'Below is the generated shortcode for this slider.', WPSCR_I18NDOMAIN ); ?></p>
	<p><strong><?php _e( 'Click Update to generate the shortcode or refresh its attributes.', WPSCR_I18NDOMAIN ); ?></strong></p>
	<textarea id="wpscr_slider_sc" autocorrect="off" spellcheck="false"><?php echo $sc_code; ?></textarea>
	<a class="button-secondary" id="wpscr_slider_sc_copy" data-clipboard-target="#wpscr_slider_sc">
		<span data-copy-success="<?php _e( 'Copied!', WPSCR_I18NDOMAIN ); ?>"><?php _e( 'Copy to clipboard', WPSCR_I18NDOMAIN ); ?></span>
		<img src="<?php echo WPSCR_URL; ?>assets/vendor/clipboard.js/clippy.svg" width="13" alt="<?php _e( 'Copy to clipboard', WPSCR_I18NDOMAIN ); ?>">
	</a>

	<?php
}