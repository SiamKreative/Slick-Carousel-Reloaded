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
if( ! defined( 'WPSCR_VERSION' ) ){
	define( 'WPSCR_VERSION', '1.0.0' );
}
define( 'WPSCR_URL', plugin_dir_url( __FILE__ ) );
define( 'WPSCR_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'WPSCR_I18NDOMAIN', 'wpscr' );
define( 'WPSCR_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

// Load composer dependencies individually (See https://github.com/SiamKreative/slick-carousel-reloaded/issues/14)
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
require_once( 'includes/notices.php' );