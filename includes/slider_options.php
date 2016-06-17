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
			'max' => 2000
			),
		array(
			'id' => 'slider_height',
			'name' => __( 'Height', WPSCR_I18NDOMAIN ),
			'type' => 'number',
			'desc' => __( 'The height of the slider in pixels.', WPSCR_I18NDOMAIN ),
			'data_type' => 'int',
			'default' => 300,
			'max' => 2000
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
			'type' => 'code',
			'lang' => 'javascript',
			'desc' => __( 'Put your additional Slick parameters. One parameter per line. <a href="https://github.com/kenwheeler/slick/#settings" target="_blank">See all parameters</a>.', WPSCR_I18NDOMAIN ),
			'default' => ''
			)

		);

	return $options;

}

function wpscr_get_gallery_options( $post_id ) {

	$opts    = array();
	$options = wpscr_gallery_options();

	foreach ( $options as $option ) {

		$key          = 'wpscr_' . $option['id'];
		$sc_attr_name = str_replace( 'slider_', '', $option['id'] );
		$value        = get_post_meta( $post_id, $key, true );

		if ( 'customparameters' === $sc_attr_name ) {

			$params = explode( PHP_EOL, $value );

			foreach ( $params as $param ) {

				$param = trim( $param );

				if ( ',' === substr( $param, - 1 ) ) {
					$param = trim( $param, ',' );
				}

				$param = explode( ':', trim( $param, ' ,' ) );
				$input = trim( $param[1], " '" );

				// Because custom parameters are free text, we cannot typecast the value and it will always be returned as string.
				// In order to be able to use different data types, we'll hack the value and hope we're not wrong and don't break the user-intended behavior...
				if ( 'true' === $input || 'false' === $input ) {
					$input = wpscr_typecast( $input, 'bool' );
				} elseif ( is_numeric( $input ) ) {
					$input = wpscr_typecast( $input, 'int' );
				}

				$opts[ $param[0] ] = $input;

			}


		} else {

			if ( ! isset( $option['data_type'] ) ) {
				$option['data_type'] = '';
			}

			$opts[ $sc_attr_name ] = wpscr_typecast( $value, $option['data_type'] );

		}

	}

	return $opts;

}

function wpscr_typecast( $value, $data_type ) {

	if ( ! empty( $data_type ) ) {

		switch ( $data_type ) {
			case 'bool':
				$value = (bool) $value;
				break;

			case 'int':
				$value = (int) $value;
				break;

			default:
				$value = (string) $value;
				break;
		}

	}

	return $value;

}