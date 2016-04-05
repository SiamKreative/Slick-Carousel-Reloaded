<?php

add_shortcode( 'slick_carousel', 'wpscr_shortcode' );

function wpscr_shortcode( $atts ) {

	if(!isset($atts['id'])) {
		return '';
	} 

	// Build the shortcode attributes
	$a = wpscr_get_gallery_options($atts['id']);

	// Output the HTML
	$slider = '';
	
	// https://pippinsplugins.com/retrieving-image-urls-of-galleries/
	$gallery = get_post_gallery( $atts['id'], false );

	// Cloudinary integration
	$cloudinary_url = "";
	$whitelist = array(
		'127.0.0.1',
		'::1'
	);

	// Disable if localhost
	if( !in_array($_SERVER['REMOTE_ADDR'], $whitelist) ) {
		$titan = TitanFramework::getInstance( 'wpscr_settings' );
		$cloudinary_username = $titan->getOption( 'slider_cloudinary_account' );
		$cloudinary_url = "https://res.cloudinary.com/$cloudinary_username/image/fetch/";
	}

	if( $gallery ) {
	$attachments = explode( ",", $gallery['ids'] );
	
		$slider = '<div class="wpscr_slider" id="wpscr_slider_'. $atts['id'] .'" data-id="'. $atts['id'] .'">';
		foreach( $attachments as $attachment ) {
	
			$link = wp_get_attachment_url( $attachment );
			$size = wp_get_attachment_image_src( $attachment, 'full');
			$slider .= "<div class='wpscr_slide'><img src='$cloudinary_url$link' width='$size[1]' height='$size[2]' alt=''></div>";
	
		}
		$slider .= '</div>';
	}

	return $slider;
}