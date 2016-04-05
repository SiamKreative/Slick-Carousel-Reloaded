<?php

add_action( 'wp_enqueue_scripts', 'wpscr_load_frontend_assets' );
function wpscr_load_frontend_assets() {

	// Check if the post type 'slider' is registered and has any posts
	if ( post_type_exists('slider') && get_posts( 'post_type=slider' ) ) {

		// Stylesheets
		wp_enqueue_style( 'wpscr_slick',  WPSCR_URL . 'assets/vendor/slick/slick.css', array(), '1.5.9' );

		// Load Slick Theme
		$titan         = TitanFramework::getInstance('wpscr_settings');
		$default_theme = $titan->getOption('slider_default_theme');
		if ($default_theme) {
			wp_enqueue_style('wpscr_slick_theme', WPSCR_URL . 'assets/vendor/slick/slick-theme.css', array('wpscr_slick'), '1.5.9');
		}

		// Scripts
		wp_enqueue_script( 'wpscr_slick', WPSCR_URL . 'assets/vendor/slick/slick.min.js', array( 'jquery' ), '1.5.9', true );
		wp_enqueue_script( 'wpscr_slick_init', WPSCR_URL . 'assets/slick-carousel-reloaded.js', array( 'jquery', 'wpscr_slick' ), WPSCR_VERSION, true );

		$sliders = wpscr_get_sliders();

		if ( ! empty( $sliders ) ) {
			foreach ( $sliders as $slider_id ) {
				$wpscr_options['sliders'][ $slider_id ] = wpscr_get_gallery_options( $slider_id );
			}
		}

		// Pass parameters as inline script tag
		wp_localize_script( 'wpscr_slick_init', 'wpscr', $wpscr_options );

	}
}

add_action( 'admin_enqueue_scripts', 'wpscr_load_dashboard_assets' );
function wpscr_load_dashboard_assets() {

	$screen = get_current_screen();

	// Only load assets in our CPT
	if( $screen->post_type == 'slider' ) {

		wp_enqueue_style( 'wpscr_admin',  WPSCR_URL . 'assets/dashboard.css', array(), '1.5.9' );
		wp_enqueue_script( 'wpscr_clipboard', WPSCR_URL . 'assets/vendor/clipboard.js/clipboard.min.js', array( 'jquery' ), '1.5.9', true );
		wp_enqueue_script( 'wpscr_autosize', WPSCR_URL . 'assets/vendor/autosize/autosize.min.js', array( 'jquery' ), '3.0.15', true );
		wp_enqueue_script( 'wpscr_admin', WPSCR_URL . 'assets/dashboard.js', array( 'jquery' ), '1.5.9', true );

	}
}