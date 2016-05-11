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

	if( $gallery ) {
	$attachments = explode( ",", $gallery['ids'] );
	
		$slider = '<div class="wpscr_slider" id="wpscr_slider_'. $atts['id'] .'" data-id="'. $atts['id'] .'">';
		foreach( $attachments as $attachment ) {

			$media = wp_get_attachment_image_src( $attachment, 'full');
			$image_url = wpsrc_get_image_optimized_url( $media[0] );

			// Update markup for lazy load
			if ($a['lazyload'] == 'ondemand' || $a['lazyload'] == 'progressive') {
				// change the src attribute to data-lazy and add blank image
				$image = "<img src='//www.gstatic.com/psa/static/1.gif' data-lazy='$image_url' width='$media[1]' height='$media[2]' alt=''>";
			} else {
				$image = "<img src='$image_url' {{layi}} width='$media[1]' height='$media[2]' alt=''>";
			}

			$slider .= "<div class='wpscr_slide'>$image</div>";
	
		}
		$slider .= '</div>';
	}

	return $slider;
}