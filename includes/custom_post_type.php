<?php

$slider = new CPT('Slider',array(
	'post_type_name' => 'wpscr',
	'singular' => 'Slider',
	'plural' => 'Sliders',
	'slug' => 'slider',
	'supports' => array('title', 'editor')
	));

$slider->menu_icon("dashicons-images-alt2");