<?php

function wp_get_attachment( $attachment_id ) {

	$attachment = get_post( $attachment_id );
	return array(
		'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
		'caption' => $attachment->post_excerpt,
		'description' => $attachment->post_content,
		'href' => get_permalink( $attachment->ID ),
		'src' => $attachment->guid,
		'title' => $attachment->post_title
	);
}

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

			// Get custom size
			$size = wpscr_get_slider_image_size_name( (int) $atts['id'] );

			// Fallback on full size in case something goes wrong with the custom one
			if ( empty( $size ) ) {
				$size = 'full';
			}

			$attachment_meta = wp_get_attachment($attachment);
			$caption         = $attachment_meta['caption'];
			$alt             = $attachment_meta['alt'];
			$media           = wp_get_attachment_image_src( $attachment, $size );
			$image_url       = wpscr_get_image_optimized_url( $media[0] );

			// Update markup for lazy load
			if ($a['lazyload'] == 'ondemand' || $a['lazyload'] == 'progressive') {
				// change the src attribute to data-lazy and add blank image
				$image = "<img src='//www.gstatic.com/psa/static/1.gif' data-lazy='$image_url' width='$media[1]' height='$media[2]' alt=''>";
			} else {
				$image = "<img src='$image_url' width='$media[1]' height='$media[2]' alt='$alt'>";
			}

			// Add markup for caption
			if($caption) {
				$caption_html = "<div class='wpscr_caption'>$caption</div>";
			} else {
				$caption_html = "";
			}

			$slider .= "<div class='wpscr_slide'>$image$caption_html</div>";
	
		}
		$slider .= '</div>';
	}

	return $slider;
}