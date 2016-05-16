<?php

add_action( 'tf_create_options', 'wpscr_settings' );
function wpscr_settings() {

	/**
	* General Options
	*/
	$titan = TitanFramework::getInstance( 'wpscr_settings' );

	$panel = $titan->createAdminPanel( array(
		'name'       => __( 'Settings', WPSCR_I18NDOMAIN ),
		'title'      => __( 'Slider Settings', WPSCR_I18NDOMAIN ),
		'id'         => 'wpscr_slider_settings',
		'parent'     => 'edit.php?post_type=slider',
		'capability' => 'administrator'
		)
	);

	$tab_general = $panel->createTab( array(
		'name' => 'General',
	) );

	$tab_general->createOption( array(
		'name' => __( 'Show Credit Link', WPSCR_I18NDOMAIN ),
		'desc' => __( 'Enable this option if you want to support the <a href="https://siamkreative.com/">developer of this plugin</a>. This adds a link to the plugin’s page on the footer of your site.', WPSCR_I18NDOMAIN ),
		'id' => 'slider_show_credit',
		'type' => 'enable',
		'default' => false,
		) );

	$tab_general->createOption( array(
		'name' => __( 'Cloudinary Account', WPSCR_I18NDOMAIN ),
		'id' => 'slider_cloudinary_account',
		'desc' => __( 'If you want to use Cloudinary to <a href="http://cloudinary.com/documentation/fetch_remote_images">fetch remote images</a> then please fill your Cloudinary username. If blank, Cloudinary network will not be used.', WPSCR_I18NDOMAIN ),
		'placeholder' => 'Username',
		'type' => 'text',
		'default' => '',
		) );

	$tab_style = $panel->createTab( array(
		'name' => 'Style',
	) );

	$tab_style->createOption( array(
		'name' => __( 'Slider Loading Spinner', WPSCR_I18NDOMAIN ),
		'desc' => __( 'These are retina-ready loading spinners. The background color is only here for demo purpose.', WPSCR_I18NDOMAIN ),
		'id' => 'slider_loading_spinner',
		'type' => 'radio-image',
		'options' => array(
			'audio' => WPSCR_URL . 'assets/vendor/svg-loaders/audio.svg',
			'ball-triangle' => WPSCR_URL . 'assets/vendor/svg-loaders/ball-triangle.svg',
			'bars' => WPSCR_URL . 'assets/vendor/svg-loaders/bars.svg',
			'circles' => WPSCR_URL . 'assets/vendor/svg-loaders/circles.svg',
			'grid' => WPSCR_URL . 'assets/vendor/svg-loaders/grid.svg',
			'hearts' => WPSCR_URL . 'assets/vendor/svg-loaders/hearts.svg',
			'oval' => WPSCR_URL . 'assets/vendor/svg-loaders/oval.svg',
			'puff' => WPSCR_URL . 'assets/vendor/svg-loaders/puff.svg',
			'rings' => WPSCR_URL . 'assets/vendor/svg-loaders/rings.svg',
			'spinning-circles' => WPSCR_URL . 'assets/vendor/svg-loaders/spinning-circles.svg',
			'tail-spin' => WPSCR_URL . 'assets/vendor/svg-loaders/tail-spin.svg',
			'three-dots' => WPSCR_URL . 'assets/vendor/svg-loaders/three-dots.svg',
		),
		'default' => 'oval',
		) );

	$tab_style->createOption( array(
		'name' => __( 'Load Slick’s Theme', WPSCR_I18NDOMAIN ),
		'desc' => __( 'If you disable this, the default’s theme for Slick will be removed. This is useful for developers who want to create their own style for Slick (LESS &amp; SCSS version available).', WPSCR_I18NDOMAIN ),
		'id' => 'slider_default_theme',
		'type' => 'enable',
		'default' => true,
		) );

	$tab_style->createOption( array(
		'name' => __( 'Custom CSS', WPSCR_I18NDOMAIN ),
		'desc' => __( 'Add valid CSS in the code editor above.', WPSCR_I18NDOMAIN ),
		'id' => 'slider_custom_css',
		'type' => 'code',
		'default' => file_get_contents(WPSCR_URL . 'assets/custom.css')
		) );

	$panel->createOption( array( 'type' => 'save', ) );
	
}