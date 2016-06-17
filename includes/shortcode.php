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

	// Get loading spinner
	$titan = TitanFramework::getInstance( 'wpscr_settings' );
	$loading_spinner = $titan->getOption( 'slider_loading_spinner' );
	$loading_spinner_url = WPSCR_URL . "assets/vendor/svg-loaders/$loading_spinner.svg";
	if ( $loading_spinner == 'none' ) {
		$style = "";
	} else {
		$style = "style='background-image: url($loading_spinner_url);'";
	}

	// Get credit link	
	$credit_link = $titan->getOption( 'slider_show_credit' );
	$credit_html = $credit_link ? '<div class="wpscr_credit"><style type="text/css" scoped>small {position: absolute; top: 15px; right: 20px; color: white; opacity: 0.8;} small a {color: white; text-decoration: underline;}</style><small>Created with <a target="_blank" href="https://wordpress.org/plugins/slick-carousel-reloaded">Slick Carousel Reloaded</a></small></div>' : false;

	if( $gallery ) {
	$attachments = explode( ",", $gallery['ids'] );
	
		$slider = '<div class="wpscr_slider" id="wpscr_slider_'. $atts['id'] .'" data-id="'. $atts['id'] .'" '. $style .'>';
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
			$custom_url      = get_post_meta( $attachment, '_gallery_link_url', true );

			// Update markup for lazy load
			if ($a['lazyload'] == 'ondemand' || $a['lazyload'] == 'progressive') {
				// change the src attribute to data-lazy and add blank image
				$image = "<img class='wpscr_slide_img' src='//www.gstatic.com/psa/static/1.gif' data-lazy='$image_url' width='$media[1]' height='$media[2]' alt=''>";
			} else {
				$image = "<img class='wpscr_slide_img' src='$image_url' width='$media[1]' height='$media[2]' alt='$alt'>";
			}

			// Add link on slides
			if (!empty($custom_url)) {
				$image = "<a href='$custom_url'>$image</a>";
			}

			// Add markup for caption
			$caption_html = $caption ? "<div class='wpscr_caption'>$caption</div>" : false;

			$slider .= "<div class='wpscr_slide'>$image$caption_html</div>";
	
		}
		$slider .= "$credit_html</div>";
	}

	return $slider;
}