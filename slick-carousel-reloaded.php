<?php
/**
 * Plugin Name: Slick Carousel Reloaded
 * Plugin URI: https://github.com/SiamKreative/slick-carousel-reloaded
 * Text Domain: wpscr
 * Domain Path: /languages/
 * Description: Probably the best WordPress implementation of <a href="http://kenwheeler.github.io/slick/">jQuery Slick</a>. Clean and robust code, regularly maintained on Github.
 * Author: Julien Vernet <julien@vernet.me>
 * Version: 1.0.0
 * Author URI: https://siamkreative.com/
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

// Setup plugin constants
if( ! defined( 'WPSCR_VERSION' ) ) {
	define( 'WPSCR_VERSION', '1.0.0' );
}
if( ! defined( 'WPSCR_URL' ) ) {
	define( 'WPSCR_URL', plugin_dir_url( __FILE__ ) );
}
if( ! defined( 'WPSCR_PATH' ) ) {
	define( 'WPSCR_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
}
if( ! defined( 'WPSCR_I18NDOMAIN' ) ) {
	define( 'WPSCR_I18NDOMAIN', 'wpscr' );
}
if( ! defined( 'WPSCR_PLUGIN_BASENAME' ) ) {
	define( 'WPSCR_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
}

// Check if the plugin dependencies are installed
if ( file_exists( WPSCR_PATH . 'vendor/autoload.php' ) ) {

	// Load composer dependencies individually (See https://git.io/vrG9d)
	require_once( 'vendor/gambitph/titan-framework/titan-framework-embedder.php' );
	require_once( 'vendor/johnbillion/extended-cpts/extended-cpts.php' );

	// Include required files
	require_once( 'includes/assets.php' );
	require_once( 'includes/custom_post_type.php' );
	require_once( 'includes/slider_options.php' );
	require_once( 'includes/metaboxes.php' );
	require_once( 'includes/settings_page.php' );
	require_once( 'includes/functions-misc.php' );
	require_once( 'includes/functions-slider.php' );
	require_once( 'includes/functions-resize.php' );
	require_once( 'includes/shortcode.php' );
	require_once( 'includes/dashboard_customisations.php' );

} else {

	// Add a warning notice if the plugin dependencies are missing
	add_action( 'admin_notices', 'wpscr_missing_dependencies_warning' );
	function wpscr_missing_dependencies_warning() { ?>

		<div id="message" class="error">
			<p><?php echo sprintf( wp_kses( __( 'The dependencies for Slick Carousel Reloaded are missing. Please <a href="%s">read this</a> for more details.', WPSCR_I18NDOMAIN ), array(  'a' => array( 'href' => array() ) ) ), esc_url( 'https://getcomposer.org/doc/01-basic-usage.md#installing-dependencies' ) ); ?></p>
		</div>

	<?php }

}