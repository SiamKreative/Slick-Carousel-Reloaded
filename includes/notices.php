<?php

add_action( 'admin_notices', 'wpscr_missing_dependencies_warning' );
/**
 * Add a warning notice if the plugin dependencies are missing
 *
 * @since 1.0.0
 * @return void
 */
function wpscr_missing_dependencies_warning() {

	if ( file_exists( WPSCR_PATH . 'vendor/autoload.php' ) ) {
		return;
	} ?>

	<div id="message" class="error">
		<p><?php echo sprintf( wp_kses( __( 'The dependencies for Slick Carousel Reloaded are missing. Please <a href="%s">read this</a> for more details.', WPSCR_I18NDOMAIN ), array(  'a' => array( 'href' => array() ) ) ), esc_url( 'https://getcomposer.org/doc/01-basic-usage.md#installing-dependencies' ) ); ?></p>
	</div>

<?php }