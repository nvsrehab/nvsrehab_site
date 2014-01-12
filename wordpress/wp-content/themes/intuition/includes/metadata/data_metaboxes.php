<?php

//Create page meta fields
function cpotheme_metadata_posts(){

	$cpotheme_data = array();
	
	$cpotheme_data[] = array(
	'name' => 'post_featured',
	'std'  => '',
	'label' => __('Featured Post', 'cpotheme'),
	'desc' => __('Specifies whether this post appears in the homepage slider.', 'cpotheme'),
	'type' => 'yesno');
	
	return $cpotheme_data;
}

//Create page meta fields
function cpotheme_metadata_pages(){

	$cpotheme_data = array();
	
	$cpotheme_data[] = array(
	'name' => 'page_featured',
	'std'  => '',
	'label' => __('Featured Page', 'cpotheme'),
	'desc' => __('Specifies whether this page appears in the homepage feature listing.', 'cpotheme'),
	'type' => 'yesno');
	
	$cpotheme_data[] = array(
	'name' => 'page_icon',
	'std'  => '',
	'label' => __('Featured Icon', 'cpotheme'),
	'desc' => __('Sets an icon to be used as the featured image.', 'cpotheme'),
	'type' => 'select',
	'option' => cpotheme_metadata_icons(),
	'class' => 'fontawesome');
	
	return $cpotheme_data;
}