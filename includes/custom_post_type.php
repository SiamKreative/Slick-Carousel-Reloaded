<?php

// create a slider custom post type
$slider = new CPT('slider');

// define the columns to appear on the admin edit screen
$slider->columns(array(
	'cb'         => '<input type="checkbox" />',
	'title'      => __('Title'),
	'dimensions' => __('Size'),
	'slides'     => __('Images'),
	'dots'       => __('Dots'),
	'arrows'     => __('Arrows'),
	'lazyload'   => __('Lazy Load'),
	'date'       => __('Date'),
));

// populate the dimensions column
$slider->populate_column('dimensions', function ($column, $post) {
	$post_id       = $post->ID;
	$titan         = TitanFramework::getInstance('wpscr');
	$slider_width  = $titan->getOption('slider_width', $post_id);
	$slider_height = $titan->getOption('slider_height', $post_id);
	echo "<code>$slider_width</code> &times; <code>$slider_height</code>";
});

// populate the slides column
$slider->populate_column('slides', function ($column, $post) {
	$post_id = $post->ID;
	$gallery = get_post_gallery($post_id, false);
	$count   = count($gallery['src']);
	echo $count;
});

// populate the dots pagination column
$slider->populate_column('dots', function ($column, $post) {
	$post_id         = $post->ID;
	$titan           = TitanFramework::getInstance('wpscr');
	$slider_infinite = $titan->getOption('slider_dots', $post_id);
	echo $slider_infinite ? '<span class="wpsrc_true">' . esc_html__('Yes', WPSCR_I18NDOMAIN) . '</span>' : '<span class="wpsrc_false">' . esc_html__('No', WPSCR_I18NDOMAIN) . '</span>';
});

// populate the arrows navigation column
$slider->populate_column('arrows', function ($column, $post) {
	$post_id         = $post->ID;
	$titan           = TitanFramework::getInstance('wpscr');
	$slider_infinite = $titan->getOption('slider_arrows', $post_id);
	echo $slider_infinite ? '<span class="wpsrc_true">' . esc_html__('Yes', WPSCR_I18NDOMAIN) . '</span>' : '<span class="wpsrc_false">' . esc_html__('No', WPSCR_I18NDOMAIN) . '</span>';
});

// populate the lazyload column
$slider->populate_column('lazyload', function ($column, $post) {
	$post_id         = $post->ID;
	$titan           = TitanFramework::getInstance('wpscr');
	$slider_lazyload = $titan->getOption('slider_lazyload', $post_id);
	echo $slider_lazyload;
});

// use custom icon for post type
$slider->menu_icon("dashicons-images-alt2");