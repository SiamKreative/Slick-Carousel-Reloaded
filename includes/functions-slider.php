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

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_action( 'after_setup_theme', 'wpscr_images_sizes_admin' );
/**
 * Defines the sliders images sizes
 *
 * Even though it is generally not a good practice to declare images sizes conditionally, this scenario is quite
 * specific. What we want to achieve is to have a custom, different image size for all sliders.
 *
 * If there is no conditional logic, the site will end up having a ton of images sizes that will be completely useless.
 * We only want to declare a slider image size for the particular slider in order to avoid overloading the server with
 * dozens of images.
 *
 * @since 1.0.0
 * @return void
 */
function wpscr_images_sizes_admin() {

	$post_id = false;

	// Used for the media library upload
	if ( isset( $_POST['post_id'] ) ) {
		$post_id = (int) $_POST['post_id'];
	}

	// User for the post edit screen
	if ( isset( $_GET['post'] ) ) {
		$post_id = (int) $_GET['post'];
	}

	if ( false === $post_id ) {
		return;
	}

	$post = get_post( $post_id );

	// Make sure we only apply this to the slider post type
	if ( 'slider' !== $post->post_type ) {
		return;
	}

	$width  = (int) get_post_meta( $post_id, 'wpscr_slider_width', true );
	$height = (int) get_post_meta( $post_id, 'wpscr_slider_height', true );

	if ( empty( $width ) || empty( $height ) ) {
		return;
	}

	$size_name = wpscr_get_slider_image_size_name( $post_id );

	add_image_size( $size_name, $width, $height );

}

/**
 * Get the name of the custom image size
 *
 * @since 1.0.0
 *
 * @param int $post_id ID of the slider/post
 *
 * @return string
 */
function wpscr_get_slider_image_size_name( $post_id ) {

	$width  = (int) get_post_meta( $post_id, 'wpscr_slider_width', true );
	$height = (int) get_post_meta( $post_id, 'wpscr_slider_height', true );

	if ( empty( $width ) || empty( $height ) ) {
		return '';
	}

	return 'wpscr_size_' . $post_id;

}