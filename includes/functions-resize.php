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
 * @package   Slick Carousel Reloaded/Functions/Resize
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

add_action( 'tf_pre_save_options_wpscr', 'wpscr_pre_save_slider_options', 10 );
/**
 * Delete custom images if the size is being changed by the user
 *
 * @since 1.0.0
 * @return void
 */
function wpscr_pre_save_slider_options() {

	if ( ! isset( $_POST['wpscr_slider_width'] ) || ! isset( $_POST['wpscr_slider_height'] ) ) {
		return;
	}

	$post_id = get_the_ID();

	// Get new values just posted
	$width_new  = (int) $_POST['wpscr_slider_width'];
	$height_new = (int) $_POST['wpscr_slider_height'];

	// Get current values from DB
	$width_old  = (int) get_post_meta( $post_id, 'wpscr_slider_width', true );
	$height_old = (int) get_post_meta( $post_id, 'wpscr_slider_height', true );

	// No changes. Drop it.
	if ( $width_new === $width_old && $height_new === $height_old ) {
		return;
	}

	$ids     = wpscr_get_slider_images( $post_id );
	$uploads = wp_upload_dir();

	foreach ( $ids as $id ) {

		$image = image_get_intermediate_size( $id, wpscr_get_slider_image_size_name( $post_id ) );
		$path  = trailingslashit( $uploads['basedir'] ) . $image['path'];

		if ( file_exists( $path ) ) {
			unlink( $path );
		}

	}

	add_post_meta( $post_id, 'wpsrc_need_image_resize', '1' );

}

/**
 * Regenerate images sizes for a given image ID
 *
 * @since 1.0.0
 *
 * @param int $image_id ID of the image to regenerate sizes for
 *
 * @return int|WP_Error
 */
function wpscr_resize_slider_image( $image_id ) {

	$image = get_post( $image_id );

	if ( ! $image || 'attachment' != $image->post_type || 'image/' != substr( $image->post_mime_type, 0, 6 ) ) {
		return new WP_Error( 'invalid_image_id', sprintf( esc_html__( 'Failed resize: %s is an invalid image ID', WPSCR_I18NDOMAIN ), $image_id ) );
	}

	$fullsizepath = get_attached_file( $image->ID );

	if ( false === $fullsizepath || ! file_exists( $fullsizepath ) ) {
		return new WP_Error( 'file_not_found', sprintf( esc_html__( 'The originally uploaded image file cannot be found at %s', WPSCR_I18NDOMAIN ), '<code>' . esc_html( $fullsizepath ) . '</code>' ) );
	}

	$metadata = wp_generate_attachment_metadata( $image->ID, $fullsizepath );

	if ( is_wp_error( $metadata ) ) {
		return $metadata;
	}

	if ( empty( $metadata ) ) {
		return new WP_Error( 'unknown_error', esc_html__( 'Unknown failure reason', WPSCR_I18NDOMAIN ) );
	}

	// If this fails, then it just means that nothing was changed (old value == new value)
	return wp_update_attachment_metadata( $image->ID, $metadata );

}

add_action( 'admin_init', 'wpscr_maybe_resize_images' );
/**
 * Maybe resize slider images
 *
 * @since 1.0.0
 * @return int Number of images resized
 */
function wpscr_maybe_resize_images() {

	if ( ! isset( $_GET['post'] ) || 'slider' !== get_post_type( (int) $_GET['post'] ) ) {
		return 0;
	}

	$post_id = (int) $_GET['post'];
	$resize  = get_post_meta( $post_id, 'wpsrc_need_image_resize', true );
	$resized = 0;

	if ( ! empty( $resize ) ) {

		$ids = wpscr_get_slider_images( $post_id );

		foreach ( $ids as $id ) {

			$result = wpscr_resize_slider_image( $id );

			if ( ! is_wp_error( $result ) ) {
				$resized ++;
			}

		}

		if ( $resized > 0 ) {
			delete_post_meta( $post_id, 'wpsrc_need_image_resize' );
		}

	}

	return $resized;

}