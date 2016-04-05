<?php

add_shortcode( 'slick_carousel', 'wpscr_shortcode' );

function wpscr_shortcode( $atts ) {

	// Build the shortcode attributes
	$attributes = wpscr_gallery_options();
	$sc_array = array('id' => '');

	foreach( $attributes as $attribute ) {
		$key = $attribute['id'];
		$default = $attribute['default'];
		$sc_array[$key] = $default;
	}

	// Create the shortcode
	$a = shortcode_atts( $sc_array, $atts );

	// Output the HTML
	$slider = '';
	
	// https://pippinsplugins.com/retrieving-image-urls-of-galleries/
	$gallery = get_post_gallery( $a['id'], false );

	// Check if Cloudinary is enabled
	$titan = TitanFramework::getInstance( 'wpscr_settings' );
	$cloudinary_username = $titan->getOption( 'slider_cloudinary_account' );
	$cloudinary_url = "http://res.cloudinary.com/$cloudinary_username/image/fetch/";

	if( $gallery ) {
	$attachments = explode( ",", $gallery['ids'] );
	
		$slider = '<div class="wpscr_slider" id="wpscr_slider_'. $a['id'] .'" data-id="'. $a['id'] .'">';
		foreach( $attachments as $attachment ) {
	
			$link = wp_get_attachment_url( $attachment );
			$size = wp_get_attachment_image_src( $attachment, 'full');
			$slider .= "<div class='wpscr_slide'><img src='$cloudinary_url$link' width='$size[1]' height='$size[2]' alt=''></div>";
	
		}
		$slider .= '</div>';
	}

	return $slider;
}