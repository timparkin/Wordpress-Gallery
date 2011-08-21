<?php

/* Save custom field values
***************************************************************************************/

function slt_cf_save( $request_type, $object_id, $object, $extras = array() ) {
	global $slt_custom_fields;
	
	// Metadata type
	if ( $request_type == 'attachment' )
		$metadata_type = 'post';
	else
		$metadata_type = $request_type;
	
	// Loop through boxes
	foreach ( $slt_custom_fields['boxes'] as $box ) {

		// Check post meta box nonce
		if ( $request_type == 'post' )
			$nonce_prefix = slt_cf_prefix( $request_type ) . $box['id'];
			
		if ( $request_type != 'post' || ( isset( $_POST[ $nonce_prefix . '_wpnonce' ] ) && wp_verify_nonce( $_POST[ $nonce_prefix . '_wpnonce' ], $nonce_prefix . '_save' ) ) ) {
		
			// Loop through fields
			foreach ( $box['fields'] as $field ) {
				$field_name = slt_cf_prefix( $request_type ) . $field['name'];
				
				// Process the submitted value
				$value = null;
				$update = true;

				if ( $field['type'] == 'checkboxes' ) {

					/* Multiple checkboxes - gather values into array
					*************************************************************/
					$value = array();
					foreach ( $field['options'] as $opt_key => $opt_value ) {
						if ( isset( $_POST[ $field_name . '_' . $opt_value ] ) )
							$value[] = $opt_value;
					}

				} else if ( isset( $_POST[ $field_name ] ) || ( $request_type == 'attachment' && isset( $_POST['attachments'][$object_id][$field_name] ) ) ) {

					/* Other field types
					*************************************************************/
					if ( isset( $_POST['attachments'][$object_id][$field_name] ) )
						$value =  $_POST['attachments'][$object_id][$field_name];
					else
						$value = $_POST[ $field_name ];

					if ( is_string( $value ) ) {
						// Basic trim for strings
						$value = trim( $value );
						if ( count( $field['allowtags'] ) ) {
							// Strip all tags except those allowed
							$value = strip_tags( $value, '<' . implode( '><', $field['allowtags'] ) . '>' );
						} else if ( in_array( $field['type'], array( 'text', 'textarea' ) ) ) {
							// If no tags are allowed, for text and textarea, strip all HTML
							$value = strip_tags( $value );
						}
					}
					if ( $field['type'] == 'wysiwyg' || $field['autop'] ) {
						// Auto-paragraphs for WYSIWYG and other fields with autop set
						$value = wpautop( $value );
					} else if ( $field['type'] == "textile" ) {
						// Textile formatting
						$value = $slt_cf_simple_formatting( $value, 'html' );
					}
		
				} // Field type if

				// Save meta entry
				if ( $update ) {
					
					// Apply filters to value first
					$value = apply_filters( 'slt_cf_pre_save_value', $value, $request_type, $object_id, $object, $field );

					// Run save actions
					do_action( 'slt_cf_pre_save', $value, $request_type, $object_id, $object, $field );
				
					// Separate fields?
					if ( ! $field['single'] && ( $field['type'] == 'checkboxes' || ( $field['type'] == 'select' && $field['multiple'] ) ) ) {		
						// Remove all old values
						delete_metadata( $request_type, $object_id, $field_name );
						// Add each new value separately
						foreach ( $value as $value_item )
							add_metadata( $metadata_type, $object_id, $field_name, $value_item, false );
					} else {
						// Update single value
						update_metadata( $metadata_type, $object_id, $field_name, $value );
					}

				}

			} // Fields foreach
			
		} // Nonce check if
		
	} // Boxes foreach

	// Return $post for attachments (it's a filter, not an action!)
	if ( $request_type == 'attachment' )
		return $object;
		
}

