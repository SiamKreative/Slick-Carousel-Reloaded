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

if( !defined('WPSCR_VERSION') ){
	define( 'WPSCR_VERSION', '1.0.0' );
}

define( 'WPSCR_URL', plugin_dir_url( __FILE__ ) );
define( 'WPSCR_I18NDOMAIN', 'wpscr' );
define( 'WPSCR_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

if ( file_exists( 'vendor/autoload.php' ) ) {
	require_once( 'vendor/autoload.php' );
	require_once( 'vendor/gambitph/titan-framework/titan-framework-checker.php' );
	require_once( 'includes/assets.php' );
	require_once( 'includes/custom_post_type.php' );

	require_once( 'includes/slider_options.php' );
	require_once( 'includes/metaboxes.php' );

	require_once( 'includes/settings_page.php' );
	require_once( 'includes/functions-misc.php' );
	require_once( 'includes/functions-slider.php' );
	require_once( 'includes/shortcode.php' );
	require_once( 'includes/dashboard_customisations.php' );
}

add_action( 'admin_notices', 'wpscr_missing_dependencies_warning' );
/**
 * Add a warning notice if the plugin dependencies are missing
 *
 * @since 1.0.0
 * @return void
 */
function wpscr_missing_dependencies_warning() {

	if ( file_exists( 'vendor/autoload.php' ) ) {
		return;
	} ?>

	<div id="message" class="error">
		<p><?php esc_html_e( 'The dependencies for Slick Carousel Reloaded are missing. The plugin can&#039;t be activated.' ); ?></p>
	</div>

<?php }