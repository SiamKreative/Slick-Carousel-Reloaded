<?php

/**
 * Adds links to the docs and GitHub
 *
 * @since 1.0.0
 *
 * @param	array  $plugin_meta The current array of links.
 * @param	string $plugin_file The plugin file.
 * @return	array  The current array of links together with our additions
 **/
add_filter( 'plugin_row_meta', 'plugin_links', 10, 2 );
function plugin_links( $plugin_meta, $plugin_file ) {
	if ( WPSCR_PLUGIN_BASENAME == $plugin_file ) {
		$plugin_meta[] = sprintf( "<a href='%s' target='_blank'>%s</a>",
			'https://slick-carousel-reloaded.readthedocs.org/en/latest/',
			__( 'Documentation', WPSCR_I18NDOMAIN )
		);
		$plugin_meta[] = sprintf( "<a href='%s' target='_blank'>%s</a>",
			'https://github.com/SiamKreative/slick-carousel-reloaded',
			__( 'GitHub Repo', WPSCR_I18NDOMAIN )
		);
		$plugin_meta[] = sprintf( "<a href='%s' target='_blank'>%s</a>",
			'https://github.com/SiamKreative/slick-carousel-reloaded/issues',
			__( 'Issue Tracker', WPSCR_I18NDOMAIN )
		);
	}
	return $plugin_meta;
}

/**
 * Customize admin footer text
 *
 * @since 1.0.0
 *
 * @param string $text Footer text
 * @return string
 */
add_filter( 'admin_footer_text', 'wpscr_admin_footer_text', 999, 1 );
function wpscr_admin_footer_text( $text ) {
	$screen = get_current_screen();

	// Customize only in our CPT
	if( $screen->post_type !== 'slider' ) {
		return $text;
	}

	return sprintf( __(  'If you like Slick Carousel Reloaded <a %s>please give it a 5-star rating</a>. Many thanks!', 'awesome-support' ), 'href="https://wordpress.org/support/view/plugin-reviews/slick-carousel-reloaded?rate=5#postform" target="_blank"', WPSCR_I18NDOMAIN );
}

add_filter( 'update_footer', 'wpscr_change_footer_version', 999);
function wpscr_change_footer_version( $text ) {
	$screen = get_current_screen();

	// Customize only in our CPT
	if( $screen->post_type !== 'slider' ) {
		return $text;
	}

	return sprintf( __(  'Made by %s.', WPSCR_I18NDOMAIN ), '<a href="https://siamkreative.com/" target="_blank">SiamKreative</a>' );
}

/**
 * Slider update messages.
 *
 * @since 1.0.0
 *
 * @param array $messages Existing post update messages.
 * @return array Amended post update messages with new CPT update messages.
 */
add_filter( 'post_updated_messages', 'wpscr_post_updated_messages' );
function wpscr_post_updated_messages( $messages ) {

	$post             = get_post();
	$post_type        = get_post_type( $post );
	$post_type_object = get_post_type_object( $post_type );
	
	$messages['slider'] = array(
		0  => '', // Unused. Messages start at index 1.
		1  => __( 'Slider updated.', WPSCR_I18NDOMAIN ),
		2  => __( 'Custom field updated.', WPSCR_I18NDOMAIN ),
		3  => __( 'Custom field deleted.', WPSCR_I18NDOMAIN),
		4  => __( 'Slider updated.', WPSCR_I18NDOMAIN ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Slider restored to revision from %s', WPSCR_I18NDOMAIN ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => __( 'Slider created. You can now upload pictures by creating a gallery.', WPSCR_I18NDOMAIN ),
		7  => __( 'Slider saved.', WPSCR_I18NDOMAIN ),
		8  => __( 'Slider submitted.', WPSCR_I18NDOMAIN ),
		9  => sprintf(
			__( 'Slider scheduled for: <strong>%1$s</strong>.', WPSCR_I18NDOMAIN ),
			// translators: Publish box date format, see http://php.net/date
			date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) )
		),
		10 => __( 'Slider draft updated.', WPSCR_I18NDOMAIN ),
	);

	return $messages;
}