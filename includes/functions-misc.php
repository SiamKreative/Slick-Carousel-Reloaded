<?php
/**
 * Slick Carousel Reloaded
 *
 * Slick Carousel Reloaded for WordPress.
 *
 * LICENSE: This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License as published by the Free Software Foundation; either version 3 of the License, or (at
 * your option) any later version. This program is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * General Public License for more details. You should have received a copy of the GNU General Public License along
 * with this program. If not, see <http://opensource.org/licenses/gpl-license.php>
 *
 * @package   Slick Carousel Reloaded
 * @author    Julien Vernet <julien@vernet.me>
 * @version   1.0
 * @license   GPL-2.0+
 * @link      https://siamkreative.com/
 * @copyright 2016 Julien Vernet
 */

/**
 * Get all sliders on the current page
 *
 * Parse the current page content and extract all slider IDs if any.
 *
 * @since 1.0
 * @return array
 */
function wpscr_get_sliders() {

	if ( is_admin() ) {
		return array();
	}

	global $post;

	$sliders = array();

	// Make sure we have a post
	if ( ! isset( $post ) || ! is_object( $post ) || ! is_a( $post, 'WP_Post' ) ) {
		return $sliders;
	}

	// No slider shortcode? Abort.
	if ( ! has_shortcode( $post->post_content, 'slick_carousel' ) ) {
		return $sliders;
	}

	// Get the registered shortcodes patterns
	$pattern = get_shortcode_regex();

	preg_match_all( '/' . $pattern . '/s', $post->post_content, $matches );

	// Make sure our $matches are set
	if ( ! is_array( $matches ) || ! isset( $matches[2] ) ) {
		return $sliders;
	}

	foreach ( $matches[2] as $key => $tag ) {

		// Double check that this is indeed our shortcode
		if ( 'slick_carousel' !== $tag ) {
			continue;
		}

		// Triple check that the atts are matched
		if ( ! isset( $matches[3][ $key ] ) ) {
			continue;
		}

		// Get the shortcode atts
		$atts = shortcode_parse_atts( $matches[3][ $key ] );

		// We really only need the slider ID so let's just check for that
		if ( ! is_array( $atts ) || ! array_key_exists( 'id', $atts ) ) {
			continue;
		}

		// Add our slider to the list
		$sliders[] = (int) $atts['id'];

	}

	return $sliders;

}