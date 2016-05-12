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
	if ( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'slider' && $pagenow == 'post-new.php' ) {

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

	$sc_code = '';
	
	if( isset( $_GET["post"] ) ){
		$id = trim($_GET["post"]);
		$sc_code = sprintf( '[slick_carousel id="%s"]', $id );
	}
	?>

	<p><?php _e( 'Below is the generated shortcode for this slider. Make sure to click Update first.', WPSCR_I18NDOMAIN ); ?></p>
	<textarea id="wpscr_slider_sc" autocorrect="off" spellcheck="false" rows="1"><?php echo $sc_code; ?></textarea>
	<a class="button-secondary" id="wpscr_slider_sc_copy" data-clipboard-target="#wpscr_slider_sc">
		<span data-copy-success="<?php _e( 'Copied!', WPSCR_I18NDOMAIN ); ?>"><?php _e( 'Copy to clipboard', WPSCR_I18NDOMAIN ); ?></span>
		<img src="<?php echo WPSCR_URL; ?>assets/vendor/clipboard.js/clippy.svg" width="13" alt="<?php _e( 'Copy to clipboard', WPSCR_I18NDOMAIN ); ?>">
	</a>
	<p><?php _e( 'The above shortcode only has the ID attribute. There is no other attributes, every parameters are attached to a specific slider.', WPSCR_I18NDOMAIN ); ?></p>

	<?php
}