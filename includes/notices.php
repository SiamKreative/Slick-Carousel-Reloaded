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
		<p><?php esc_html_e( 'The dependencies for Slick Carousel Reloaded are missing. The plugin can&#039;t be activated.' ); ?></p>
	</div>

<?php }