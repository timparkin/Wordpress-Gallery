<?php

error_reporting(E_ALL);


register_post_type('photo', array(	'label' => 'Photos','description' => '','public' => true,'show_ui' => true,'show_in_menu' => true,'capability_type' => 'post','hierarchical' => true,'rewrite' => array('slug' => ''),'query_var' => true,'supports' => array('title','editor','excerpt','trackbacks','custom-fields','comments','revisions','thumbnail','author','page-attributes',),'labels' => array (
  'name' => 'Photos',
  'singular_name' => 'Photo',
  'menu_name' => 'Photos',
  'add_new' => 'Add Photo',
  'add_new_item' => 'Add New Photo',
  'edit' => 'Edit',
  'edit_item' => 'Edit Photo',
  'new_item' => 'New Photo',
  'view' => 'View Photo',
  'view_item' => 'View Photo',
  'search_items' => 'Search Photos',
  'not_found' => 'No Photos Found',
  'not_found_in_trash' => 'No Photos Found in Trash',
  'parent' => 'Parent Photo',
),) );


register_post_type('gallery', array(	'label' => 'Galleries','description' => '','public' => true,'show_ui' => true,'show_in_menu' => true,'capability_type' => 'post','hierarchical' => false,'rewrite' => TRUE,'query_var' => true,'supports' => array('title','editor','excerpt','trackbacks','custom-fields','comments','revisions','thumbnail','author','page-attributes',),'labels' => array (
  'name' => 'Galleries',
  'singular_name' => 'Gallery',
  'menu_name' => 'Galleries',
  'add_new' => 'Add Gallery',
  'add_new_item' => 'Add New Gallery',
  'edit' => 'Edit',
  'edit_item' => 'Edit Gallery',
  'new_item' => 'New Gallery',
  'view' => 'View Gallery',
  'view_item' => 'View Gallery',
  'search_items' => 'Search Galleries',
  'not_found' => 'No Galleries Found',
  'not_found_in_trash' => 'No Galleries Found in Trash',
  'parent' => 'Parent Gallery',
),) );




if ( function_exists( 'slt_cf_register_box') )
	add_action( 'init', 'register_my_custom_fields' );

function register_my_custom_fields() {
	slt_cf_register_box( array(
		'type'		=> 'post',
		'title'		=> 'Photo',
		'id'		=> 'photo-box',
		'context'	=> 'normal',
		'priority'	=> 'high',
		'fields'	=> array(
			array(
				'name'			=> 'photo',
				'label'			=> 'Photo',
				'type'			=> 'file',
				'scope'			=> array( 'photo' ),
				'capabilities'	=> array( 'edit_posts' )
			),
			array(
				'name'			=> 'thumbnail',
				'label'			=> 'Thumbnail',
				'type'			=> 'file',
				'scope'			=> array( 'photo' ),
				'capabilities'	=> array( 'edit_posts' )
			)
		)
	));
}

function my_connection_types() {
	if ( !function_exists( 'p2p_register_connection_type' ) )
		return;

	p2p_register_connection_type( array( 
		'from' => 'photo',
		'to' => 'gallery',
	        'reciprocal' => true
	) );
}
add_action( 'init', 'my_connection_types', 100 );
?>
