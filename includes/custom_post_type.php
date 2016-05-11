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
		'dots'       => array(
			'title'    => 'Dots',
			'meta_key' => 'wpscr_slider_dots',
		),
		'arrows'     => array(
			'title'    => 'Arrows',
			'meta_key' => 'wpscr_slider_arrows',
		),
		'lazyload'   => array(
			'title'    => 'Lazy Load',
			'meta_key' => 'wpscr_slider_lazyload',
		),
		'published'  => array(
			'title'       => 'Published',
			'meta_key'    => 'published_date',
			'date_format' => 'd/m/Y',
		),
	),

), array(

	# Override the base names used for labels:
	'singular' => 'Slider',
	'plural'   => 'Slider',
	'slug'     => 'sliders',

));