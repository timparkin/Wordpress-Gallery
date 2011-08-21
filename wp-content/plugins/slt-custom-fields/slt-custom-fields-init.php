<?php

/* Initialize
***************************************************************************************/
function slt_cf_init() {
	global $slt_custom_fields;
	// Register scripts and styles
	wp_register_style( 'slt-cf-styles', $slt_custom_fields['css_url'] );
	//wp_register_script( 'slt-cf-scripts', plugins_url( 'slt-custom-fields.js', __FILE__ ), array( 'jquery' ) );
	wp_register_script( 'jquery-datepicker', plugins_url( 'jquery-datepicker/jquery-ui-1.8.16.custom.min.js', __FILE__ ), array( 'jquery-ui-core' ), '1.8.16', true );
	wp_register_style( 'jquery-datepicker-smoothness', $slt_custom_fields['datepicker_css_url'] );
	wp_register_script( 'slt-cf-file-select', plugins_url( 'slt-custom-fields-file-select.js', __FILE__ ), array( 'jquery', 'media-upload', 'thickbox' ) );
	wp_register_script( 'google-maps-api', 'http://maps.google.com/maps/api/js?sensor=false' );
	wp_register_script( 'slt-cf-gmaps', plugins_url( 'slt-custom-fields-gmaps.js', __FILE__ ), array( 'jquery-ui-core' ) );
	// Google Maps for front and admin
	wp_enqueue_script( 'google-maps-api' );
	wp_enqueue_script( 'slt-cf-gmaps' );
	// Generic hook, mostly for dependent plugins to hook to
	// See: http://core.trac.wordpress.org/ticket/11308#comment:7
	do_action( 'slt_cf_init' );
}

/* This stuff is currently hooked onto admin_init so header stuff is processed in time.
Would be good to find a way of being more specific, i.e. only doing stuff when the fields valid
for the current request demand individual items. Need to find a way of running slt_cf_init_fields
at the admin_init stage - can it get the info supplied to its args at this stage?
For now, a clumsy check against the requested file */
function slt_cf_admin_init() {
	$protocol = isset( $_SERVER[ 'HTTPS' ] ) ? 'https://' : 'http://';
	$requested_file = basename( $_SERVER['SCRIPT_FILENAME'] );
	if ( in_array( $requested_file, array( 'post-new.php', 'post.php', 'user-edit.php', 'profile.php' ) ) ) {
		wp_enqueue_style( 'slt-cf-styles' );
		//wp_enqueue_script( 'slt-cf-scripts' );
		add_action( 'admin_print_footer_scripts', 'wp_tiny_mce', 25 );
		wp_enqueue_script( 'jquery-datepicker' );
		wp_enqueue_style( 'jquery-datepicker-smoothness' );
	}
	if ( in_array( $requested_file, array( 'post-new.php', 'post.php' ) ) )
		add_action( 'post_edit_form_tag' , 'slt_cf_file_upload_form' );
	if ( in_array( $requested_file, array( 'user-edit.php', 'profile.php' ) ) )
		add_action( 'user_edit_form_tag' , 'slt_cf_file_upload_form' );
	// File select
	wp_enqueue_script( 'slt-cf-file-select' );
	wp_enqueue_style( 'thickbox' );
	wp_localize_script( 'slt-cf-file-select', 'slt_cf_file_select', array(
		'ajaxurl'			=> admin_url( 'admin-ajax.php', $protocol ),
		'text_select_file'	=> esc_html__( 'Select' )
	));
}

/* Initialize fields
***************************************************************************************/
function slt_cf_init_fields( $request_type, $scope, $object_id ) {
	global $slt_custom_fields, $wp_roles, $post;

	// Only run once per request
	static $init_run = false;
	if ( $init_run )
		return;
	$init_run = true;

	// Loop through boxes
	$unset_boxes = array();
	$field_names = array();
	foreach ( $slt_custom_fields['boxes'] as $box_key => &$box ) {
	
		// Initialize
		if ( ! is_array( $box['type'] ) )
			$box['type'] = array( $box['type'] );
	
		// Delete this box if it's not relevant to the current request
		if ( ! in_array( $request_type, $box['type'] ) ) {
			$unset_boxes[] = $box_key;
			continue;
		}
		
		// Check if required parameters are present
		if ( ! slt_cf_required_params( array( 'type', 'id', 'title' ), 'box', $box ) ) {		
			$unset_boxes[] = $box_key;
			continue;
		}
		
		// Set defaults
		$box_defaults = array(
			'cloning'		=> false,
			'context'		=> 'advanced',
			'priority'		=> 'default',
			'description'	=> '',
			'fields'		=> array()
		);
		$box = array_merge( $box_defaults, $box );
		
		// Check if parameters are the right types
		if (
			! slt_cf_params_type( array( 'id', 'title', 'context', 'priority', 'description' ), 'string', 'box', $box ) ||
			! slt_cf_params_type( array( 'cloning' ), 'boolean', 'box', $box ) ||
			! slt_cf_params_type( array( 'fields', 'type' ), 'array', 'box', $box )
		) {		
			$unset_boxes[] = $box_key;
			continue;
		}
	
		// Loop through fields
		$unset_fields = array();
		foreach ( $box['fields'] as $field_key => &$field ) {
		
			// Check if required parameters are present
			if ( ! slt_cf_required_params( array( 'name', 'label', 'scope' ), 'field', $field ) ) {		
				$unset_fields[] = $field_key;
				continue;
			}

			// If the name is the same as the box id, this can cause problems
			if ( $field['name'] == $box['id'] ) {
				trigger_error( '<b>' . SLT_CF_TITLE . ':</b> Box <b>' . $box['id'] . '</b> has a field with the same name as the box id, which can cause problems', E_USER_WARNING );
				$unset_fields[] = $field_key;
				continue;
			}
			
			// File field type no longer needs the File Select plugin
			if ( $field['type'] == 'file' && function_exists( 'slt_fs_button' )  )
				trigger_error( '<b>' . SLT_CF_TITLE . ':</b> File upload fields no longer need the SLT File Select plugin - you can remove it if you want! If you use that plugin\'s functionality elsewhere, you can now just call the functions provided by this Custom Fields plugin.', E_USER_NOTICE );
					
			// Set defaults
			$field_defaults = array(
				'cloning'					=> false,
				'label_layout'				=> 'block',
				'hide_label'				=> false,
				'file_button_label'			=> __( "Select file", "slt-custom-fields" ),
				'file_removeable'			=> true,
				'input_prefix'				=> '',
				'input_suffix'				=> '',
				'description'				=> '',
				'type'						=> 'text',
				'default'					=> null,
				'multiple'					=> false,
				'options'					=> array(),
				'options_type'				=> 'static',
				'no_options'				=> SLT_CF_NO_OPTIONS,
				'exclude_current'			=> true,
				'single'					=> true,
				'required'					=> false,
				'empty_option_text'			=> '[' . __( "None", "slt-custom-fields" ) . ']',
				'width'						=> 0,
				'height'					=> 0,
				'charcounter'				=> false,
				'allowtags'					=> array(),
				'autop'						=> false,
				'preview_size'				=> 'medium',
				'group_options'				=> false,
				'datepicker_format'			=> $slt_custom_fields['datepicker_default_format'],
				'location_marker'			=> true,
				'gmap_type'					=> 'roadmap'
			);
			switch ( $request_type ) {
				case 'post':
				case 'attachment': {
					$field_defaults['capabilities'] = array( 'edit_posts' );
					break;
				}
				case 'user': {
					$field_defaults['capabilities'] = array( 'edit_users' );
					break;
				}
			}
			$field = array_merge( $field_defaults, $field );
			// Defaults dependent on options type
			switch ( $field['options_type'] ) {
				case 'posts': {
					if ( ! array_key_exists( 'options_query', $field ) )
						$field['options_query'] = array( 'posts_per_page' => -1 );
					else
						$field['options_query'] = array_merge( array( 'posts_per_page' => -1 ), $field['options_query'] );
					break;
				}
				case 'users': {
					if ( ! array_key_exists( 'options_query', $field ) || empty( $field['options_query'] ) ) {
						$field['options_query'] = array_keys( $wp_roles->role_names );
					}
					break;
				}
				default: {
					if ( ! array_key_exists( 'options_query', $field ) )
						$field['options_query'] = array();
					break;
				}
			}
			// Defaults dependent on field type
			switch ( $field['type'] ) {
				case 'gmap': {
					if ( ! $field['width'] )
						$field['width'] = 500;
					if ( ! $field['height'] )
						$field['height'] = 300;
					if ( ! $field['default'] || ! is_array( $field['default'] ) )
						$field['default'] = array();
					break;
				}
			}

			// Check if parameters are the right types
			if (
				! slt_cf_params_type( array( 'name', 'label', 'type', 'label_layout', 'file_button_label', 'input_prefix', 'input_suffix', 'description', 'options_type', 'no_options', 'empty_option_text', 'preview_size', 'datepicker_format' ), 'string', 'field', $field ) ||
				! slt_cf_params_type( array( 'hide_label', 'file_removeable', 'multiple', 'exclude_current', 'required', 'group_options', 'autop' ), 'boolean', 'field', $field ) ||
				! slt_cf_params_type( array( 'scope', 'options', 'allowtags', 'options_query', 'capabilities' ), 'array', 'field', $field ) ||
				! slt_cf_params_type( array( 'width', 'height' ), 'integer', 'field', $field )
			) {		
				$unset_fields[] = $field_key;
				continue;
			}
			
			// Check capability
			if ( ( in_array( $request_type, array( 'post', 'attachment' ) ) && ! slt_cf_capability_check( $field['type'], $field['capabilities'], $object_id ) ) || ! slt_cf_capability_check( $field['type'], $field['capabilities'] ) ) {
				$unset_fields[] = $field_key;
				continue;
			}

			// Check scope
			if ( ! slt_cf_check_scope( $field, $request_type, $scope, $object_id ) ) {
				$unset_fields[] = $field_key;
				continue;
			}

			// Check uniqueness of field name in scope
			// ???? Code could be streamlined!
			$field_name_used = false;
			foreach ( $field['scope'] as $scope_key => $scope_value ) {
				if ( is_string( $scope_key ) ) {
					// Taxonomic scope
					if ( ! array_key_exists( $scope_key, $field_names ) )
						$field_names[ $scope_key ] = array();
					foreach ( $scope_value as $scope_term_name ) {
						if ( ! array_key_exists( $scope_term_name, $field_names[ $scope_key ] ) ) {
							// Register scope
							$field_names[ $scope_key ][ $scope_term_name ] = array();
						} else if ( in_array( $field['name'], $field_names[ $scope_key ][ $scope_term_name ] ) ) {
							// Field name already used in this scope
							trigger_error( '<b>' . SLT_CF_TITLE . ':</b> Field name <b>' . $field['name'] . '</b> has already been used within this scope', E_USER_WARNING );
							$field_name_used = true;
							$unset_fields[] = $field_key;
							break;
						}
						if ( ! $field_name_used ) {
							// Register field name in this scope
							$field_names[ $scope_key ][ $scope_term_name ][] = $field['name'];
						}
					}
				} else {
					// Normal scope, i.e. post type or user role
					if ( ! array_key_exists( $scope_value, $field_names ) ) {
						// Register scope
						$field_names[ $scope_value ] = array();
					} else if ( in_array( $field['name'], $field_names[ $scope_value ] ) ) {
						// Field name already used in this scope
						trigger_error( '<b>' . SLT_CF_TITLE . ':</b> Field name <b>' . $field['name'] . '</b> has already been used within this scope', E_USER_WARNING );
						$field_name_used = true;
						$unset_fields[] = $field_key;
						break;
					}
					// Register field name in this scope
					$field_names[ $scope_value ][] = $field['name'];
				}
			}
			if ( $field_name_used )
				continue;
			
			/****************************************************************************
			From this point on, this field is considered as valid for the current request
			****************************************************************************/
			
			// Gather dynamic options data?
			if ( $field['options_type'] != 'static' ) {

				// Check for any placeholder values in the query
				if ( array_search( '[OBJECT_ID]', $field['options_query'] ) ) {

					// Object ID
					switch ( $field['options_type'] ) {
						case 'posts': {
							global $post;
							$object_id = $post->ID;
							break;
						}
						case 'users': {
							global $user_id;
							$object_id = $user_id;
							break;
						}
					}
					$field['options_query'] = str_replace(
						array( '[OBJECT_ID]' ),
						array( $object_id ),
						$field['options_query']
					);

				} else if ( array_key_exists( 'tax_query', $field['options_query'] ) && $request_type == 'post' ) {

					// Taxonomy term IDs
					global $post;
					foreach ( $field['options_query']['tax_query'] as &$tax_query ) {
						if ( is_array( $tax_query ) && array_key_exists( 'terms', $tax_query ) && $tax_query['terms'] == '[TERM_IDS]' && array_key_exists( 'taxonomy', $tax_query ) && taxonomy_exists( $tax_query['taxonomy'] ) ) {
							$related_terms = get_the_terms( $post->ID, $tax_query['taxonomy'] );
							$related_term_ids = array();
							if ( $related_terms ) {
								foreach ( $related_terms as $related_term )
									$related_term_ids[] = $related_term->term_id;
								$tax_query['terms'] = $related_term_ids;
							} else {
								// No related terms - return no results
								$field['options_query'] = array( 'post__in' => array( 0 ) );
							}
						}
					}

				}

				switch ( $field['options_type'] ) {

					case 'posts': {
						// Get posts
						if ( ! array_key_exists( 'post_type', $field['options_query'] ) )
							$field['options_query']['post_type'] = 'post';
						// For now, grouping only works for categories
						if ( $field[ 'group_options' ] && in_array( 'category', get_object_taxonomies( $field['options_query']['post_type'] ) ) )
							$field['options_query']['orderby'] = 'category';
						// Exclude current post?
						if ( $field[ 'exclude_current' ] ) {
							global $post;
							$field['options_query']['post__not_in'][] = $post->ID;
						}
						$posts_query = new WP_Query( $field['options_query'] );
						$posts = $posts_query->posts;
						$field['options'] = array();
						$current_category = array();
						foreach ( $posts as $post_data ) {
							if ( $field[ 'group_options' ] ) {
								$this_category = get_the_category( $post_data->ID );
								if ( empty( $current_category ) || $this_category[0]->cat_ID != $current_category[0]->cat_ID ) {
									// New category, initiate an option group
									$field['options'][ $this_category[0]->cat_name ] = '[optgroup]';
									$current_category = $this_category;
								}
							}
							$field['options'][ slt_cf_abbreviate( $post_data->post_title ) ] = $post_data->ID;
						}
						break;
					}

					case 'users': {
						// Get users
						$field['options'] = array();
						$get_users_args = array();
						// Exclude current user?
						if ( $field[ 'exclude_current' ] ) {
							global $user_id;
							$get_users_args['exclude'] = $user_id;
						}
						// Loop through roles
						foreach ( $field['options_query'] as $role ) {
							// Get users for this role
							$get_role_args = array_merge( $get_users_args, array( 'role' => $role ) );
							$users = get_users( $get_role_args );
							if ( count( $users ) ) {
								// Grouping?
								if ( $field[ 'group_options' ] )
									$field['options'][ str_replace( '_', ' ', strtoupper( $role ) ) ] = '[optgroup]';
								// Add users to options
								foreach ( $users as $user_data )
									$field['options'][ $user_data->display_name ] = $user_data->ID;
							}
						}
						break;
					}

					default: {
						// Run filter for custom option types
						$field['options'] = apply_filters( 'slt_cf_populate_options', $field['options'], $request_type, $scope, $object_id, $field );
						break;
					}

				}
			}
					
		} // Fields foreach
			
		// Unset any invalid fields
		foreach ( array_unique( $unset_fields ) as $field_key )
			unset( $slt_custom_fields['boxes'][ $box_key ]['fields'][ $field_key ] );

	} // Boxes foreach
	
	// Unset any invalid boxes
	$num_boxes = count( $slt_custom_fields['boxes'] );
	for ( $box_key = 0; $box_key < $num_boxes; $box_key++ ) {
		if ( count( $slt_custom_fields['boxes'][ $box_key ]['fields'] ) == 0 || in_array( $box_key, $unset_boxes ) )
			unset( $slt_custom_fields['boxes'][ $box_key ] );
	}
	
	// Post-processing of boxes
	$slt_custom_fields['boxes'] = apply_filters( 'slt_cf_init_boxes', $slt_custom_fields['boxes'] );

}

