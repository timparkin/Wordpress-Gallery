<?php



register_post_type('photo', array(	'label' => 'Photos','description' => '','public' => true,'show_ui' => true,'show_in_menu' => true,'capability_type' => 'post','hierarchical' => true,'rewrite' => array('slug' => ''),'query_var' => true,'supports' => array('title','editor','excerpt','trackbacks','custom-fields','comments','revisions','thumbnail','author','page-attributes',), 'taxonomies' => array('category', 'post_tag'),'labels' => array (
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
				'name'			=> 'location',
				'label'			=> 'Location',
				'type'			=> 'text',
				'scope'			=> array( 'photo' ),
				'capabilities'	=> array( 'edit_posts' )
			),
			array(
				'name'			=> 'date_taken',
				'label'			=> 'Date Taken',
				'type'			=> 'date',
				'scope'			=> array( 'photo' ),
				'capabilities'	=> array( 'edit_posts' )
			),
			array(
				'name'			=> 'camera',
				'label'			=> 'Camera',
				'type'			=> 'select',
            	'options' => array( 
'Toyo 810MII' => 'Toyo 810MII',				
'Ebony 45SU' => 'Ebony 45SU',
'Chamonix 45N1' => 'Chamonix 45N1',
'Mamiya 7' => 'Mamiya 7',
'Mamiya C220' => 'Mamiya C220',
'Canon A1' => 'Canon A1',
'Olympus OM1' => 'Olympus OM1',
'Voigtlander Bessa' => 'Voigtlander Bessa'
				 ),				
				'scope'			=> array( 'photo' ),
				'capabilities'	=> array( 'edit_posts' )
			),
			array(
				'name'			=> 'lens',
				'label'			=> 'Lens',
				'type'			=> 'select',
				'options' => array( 
'80mm Schneider Super Symmar XL f/4.5' => '80mm Schneider Super Symmar XL f/4.5',
'110mm Schneider Super Symmar XL f/5.6' => '110mm Schneider Super Symmar XL f/5.6',
'150mm Rodenstock Sironar S f/5.6' => '150mm Rodenstock Sironar S f/5.6',
'240mm Fujinon A' => '240mm Fujinon A',
'360mm Nikkor T-ED' => '360mm Nikkor T-ED',
'500mm Nikkor T-ED' => '500mm Nikkor T-ED',
'450mm Fujinon A' => '450mm Fujinon A',
'600mm Nikkor T-ED' => '600mm Nikkor T-ED',
'800mm Nikkor T-ED' => '800mm Nikkor T-ED',
'1200mm Nikkor T-ED' => '1200mm Nikkor T-ED',
'Mamiya 50mm f/4.5 L' => 'Mamiya 50mm f/4.5 L',
'Mamiya 80mm f/4 L' => 'Mamiya 80mm f/4 L',
'Mamiya 150mm f/4.5 L' => 'Mamiya 150mm f/4.5 L',
'Canon FD 24mm f/2.8' => 'Canon FD 24mm f/2.8',
'Canon FD 50mm f/1.4' => 'Canon FD 50mm f/1.4',
'Canon FD 50mm f/1.8' => 'Canon FD 50mm f/1.8',
'Canon FD 100 f/2.8' => 'Canon FD 100mm f/2.8',
'Zuiko 28mm f/2.8' => 'Zuiko 28mm f/2.8',
'Zuiko 50mm f/1.8' => 'Zuiko 28mm f/2.8',
'Zuiko 75-100mm f/4' => 'Zuiko 75-150mm f/4',
'Color-Skopar 35mm f2.5 PII' => 'Color-Skopar 35mm f2.5 PII'
			 ),
				'scope'			=> array( 'photo' ),
				'capabilities'	=> array( 'edit_posts' )
			),	
			array(
				'name'			=> 'shutter_speed',
				'label'			=> 'Shutter Speed',
				'type'			=> 'select',
				'options' => array( 
'1/500' => '1/500',
'1/250' => '1/250',
'1/125' => '1/125',
'1/60' => '1/60',
'1/30' => '1/30',
'1/15' => '1/15',
'1/8' => '1/8',
'1/4' => '1/4',
'1/2' => '1/2','1s' => '1s',
'2s' => '2s',
'4s' => '4s',
'8s' => '8s',
'15s' => '15s',
'30s' => '30s',
'1m' => '1m',
'2m' => '2m'
				 ),
				'scope'			=> array( 'photo' ),
				'capabilities'	=> array( 'edit_posts' )
			),		array(
				'name'			=> 'aperture',
				'label'			=> 'Aperture',
				'type'			=> 'select',
				'options' => array( 
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
			),
			
		array(
				'name'			=> 'google_map',
				'label'			=> 'Google Map',
				'type'			=> 'gmap',
				'gmap_type'     => 'hybrid',
				'scope'			=> array( 'photo' ),
				'capabilities'	=> array( 'edit_posts' )
			),			
				
			
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

add_action('init', 'demo_add_default_boxes');

function demo_add_default_boxes() {
    register_taxonomy_for_object_type('post_tag', 'photo');
}
?>
