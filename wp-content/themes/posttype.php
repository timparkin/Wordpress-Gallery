<?php



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


register_taxonomy('location',array (
  0 => 'photo',
),array( 'hierarchical' => true, 'label' => 'Locations','show_ui' => true,'query_var' => true,'rewrite' => array('slug' => ''),'singular_label' => 'Location') );


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
				'name'			=> 'date_taken',
				'label'			=> 'Date Taken',
				'type'			=> 'text',
				'scope'			=> array( 'photo' ),
				'capabilities'	=> array( 'edit_posts' )
			),
			array(
				'name'			=> 'shutter_speed',
				'label'			=> 'Shutter Speed',
				'type'			=> 'text',
				'scope'			=> array( 'photo' ),
				'capabilities'	=> array( 'edit_posts' )
			),
			array(
				'name'			=> 'aperture',
				'label'			=> 'Aperture',
				'type'			=> 'select',
				'options_type' => array( 
'f/5.6' => 'f/5.6',
'f/6.3' => 'f/6.3',
'f/8' => 'f/8',
'f/8⅓' => 'f/8⅓',
'f/8½' => 'f/8½',
'f/8⅔' => 'f/8⅔',
'f/16' => 'f/16',
'f/16⅓' => 'f/16⅓',
'f/16½' => 'f/16½',
'f/16⅔' => 'f/16⅔',
'f/22' => 'f/22',
'f/22⅓' => 'f/22⅓',
'f/22½' => 'f/22½',
'f/22⅔' => 'f/22⅔',
'f/32' => 'f/32',
'f/32⅓' => 'f/32⅓',
'f/32½' => 'f/32½',
'f/32⅔' => 'f/32⅔',
'f/45' => 'f/45',
'f/45⅓' => 'f/45⅓',
'f/45½' => 'f/45½',
'f/45⅔' => 'f/45⅔'
				 ),
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
