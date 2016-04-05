<?php

function wpscr_gallery_options() {

	$options = array(
		array(
			'id' => 'slider_width',
			'name' => __( 'Width', WPSCR_I18NDOMAIN ),
			'type' => 'number',
			'desc' => __( 'The width of the slider in pixels.', WPSCR_I18NDOMAIN ),
			'data_type' => 'int',
			'default' => 600,
			),
		array(
			'id' => 'slider_height',
			'name' => __( 'Height', WPSCR_I18NDOMAIN ),
			'type' => 'number',
			'desc' => __( 'The height of the slider in pixels.', WPSCR_I18NDOMAIN ),
			'data_type' => 'int',
			'default' => 300,
			),
		array(
			'id' => 'slider_slidetoshow',
			'name' => __( 'Slide to Show', WPSCR_I18NDOMAIN ),
			'type' => 'number',
			'max' => 20,
			'data_type' => 'int',
			'default' => 1,
			),
		array(
			'id' => 'slider_slidetoscroll',
			'name' => __( 'Slide to Scroll', WPSCR_I18NDOMAIN ),
			'type' => 'number',
			'max' => 20,
			'data_type' => 'int',
			'default' => 1,
			),
		array(
			'id' => 'slider_infinite',
			'name' => __( 'Infinite', WPSCR_I18NDOMAIN ),
			'type' => 'enable',
			'data_type' => 'bool',
			'default' => true,
			),
		array(
			'id' => 'slider_dots',
			'name' => __( 'Dots Pagination', WPSCR_I18NDOMAIN ),
			'type' => 'enable',
			'data_type' => 'bool',
			'default' => true,
			),
		array(
			'id' => 'slider_arrows',
			'name' => __( 'Arrows Navigation', WPSCR_I18NDOMAIN ),
			'type' => 'enable',
			'data_type' => 'bool',
			'default' => true,
			),
		array(
			'id' => 'slider_adaptiveheight',
			'name' => __( 'Adaptive Height', WPSCR_I18NDOMAIN ),
			'type' => 'enable',
			'data_type' => 'bool',
			'default' => false,
			),
		array(
			'id' => 'slider_lazyload',
			'name' => __( 'Lazy Load', WPSCR_I18NDOMAIN ),
			'options' => array(
				'false' => __( 'Disabled', WPSCR_I18NDOMAIN ),
				'ondemand' => __( 'On demand', WPSCR_I18NDOMAIN ),
				'progressive' => __( 'Progressive', WPSCR_I18NDOMAIN ),
				),
			'type' => 'radio',
			'desc' => __( 'Which type of lazy loading do you want to use? <a href="http://stackoverflow.com/a/25726743/1414881" target="_blank">More information here</a>.', WPSCR_I18NDOMAIN ),
			'default' => 'false',
			),
		array(
			'id' => 'slider_customparameters',
			'name' => __( 'Custom Parameters', WPSCR_I18NDOMAIN ),
			'type' => 'textarea',
			'desc' => __( 'Put your additional Slick parameters. One parameter per line. <a href="https://github.com/kenwheeler/slick/#settings" target="_blank">See all parameters</a>.', WPSCR_I18NDOMAIN ),
			'is_code' => true,
			'default' => ''
			)

		);

	return $options;

}

function wpscr_get_gallery_options( $post_id ) {

	$opts = array();
	$options = wpscr_gallery_options();

	foreach ( $options as $option ) {
		$key = 'wpscr_' . $option['id'];
		$sc_attr_name = str_replace('slider_', '', $option['id']);
		$value = get_post_meta( $post_id, $key, true );
		if( isset($option['data_type']) ) {
			switch ($option['data_type']) {
				case 'bool':
					$value = (bool)$value;
					break;
				
				case 'int':
					$value = (int)$value;
					break;
				
				default:
					$value = (string)$value;
					break;
			}
		}
		$opts[$sc_attr_name] = $value;
	}

	return $opts;

}