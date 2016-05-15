<?php

register_extended_post_type('slider', array(

	# Add icon
	'menu_icon'    => 'dashicons-images-alt2',

	# Hide the post type to the site's main RSS feed:
	'show_in_feed' => false,

	# Add some custom columns to the admin screen:
	'admin_cols'   => array(
		'dimensions' => array(
			'title'    => 'Size',
			'function' => function () {
				global $post;
				$post_id       = $post->ID;
				$titan         = TitanFramework::getInstance('wpscr');
				$slider_width  = $titan->getOption('slider_width', $post_id);
				$slider_height = $titan->getOption('slider_height', $post_id);
				echo "<code>$slider_width</code> &times; <code>$slider_height</code>";
			},
		),
		'slides'     => array(
			'title'    => 'Images',
			'function' => function () {
				global $post;
				$post_id = $post->ID;
				$gallery = get_post_gallery($post_id, false);
				$count   = count($gallery['src']);
				echo $count;
			},
		),
		'shortcode'     => array(
			'title'    => 'Shortcode',
			'function' => function () {
				global $post;
				$post_id = $post->ID;
				$sc_code = sprintf( '[slick_carousel id="%s"]', $post_id );
				?>
				<textarea id="wpscr_slider_sc_<?php echo $post_id; ?>" class="wpscr_slider_sc" autocorrect="off" spellcheck="false" rows="1"><?php echo $sc_code; ?></textarea>
				<a class="button-secondary wpscr_copy_sc" data-clipboard-target="#wpscr_slider_sc_<?php echo $post_id; ?>">
					<span data-copy-success="<?php _e( 'Copied!', WPSCR_I18NDOMAIN ); ?>"><?php _e( 'Copy to clipboard', WPSCR_I18NDOMAIN ); ?></span>
					<img src="<?php echo WPSCR_URL; ?>assets/vendor/clipboard.js/clippy.svg" width="13" alt="<?php _e( 'Copy to clipboard', WPSCR_I18NDOMAIN ); ?>">
				</a>
				<?php
			},
		),
		'date'
	),

), array(

	# Override the base names used for labels:
	'singular' => 'Slider',
	'plural'   => 'Slider',
	'slug'     => 'sliders',

));