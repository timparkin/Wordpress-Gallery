/* SLT Custom Fields JavaScript
*********************************************************************/

jQuery( document ).ready( function($) {

	/* Cloning
	*****************************************************************/
	if ( $( "p.slt-cf-clone-field a" ).length ) {
		$( 'p.slt-cf-clone-field a' ).click( function() {
		
			// Initialize
			var masterFieldDiv, fieldName, fieldNameParts, fieldClassPrefix, lastCloneFieldName, newField, newFieldNumber, newFieldName;
			fieldClassPrefix = 'slt-cf-field_';
			masterFieldDiv = $( this ).parents( '.slt-cf' );
			fieldName = getValueFromClass( masterFieldDiv, fieldClassPrefix );
			
			// Store the field name for what is currently the last clone
			lastCloneFieldName = getValueFromClass( $( '.' + fieldClassPrefix + fieldName ).last(), fieldClassPrefix );

			// Clone the master field, placing the clone at the end of all clones
			$( '.' + fieldClassPrefix + fieldName ).last().after( masterFieldDiv.clone( true ) );

			// Get a handle for it and hide it straight away
			newField = $( '.' + fieldClassPrefix + fieldName ).last();
			newField.hide();

			// Determine new number / ID
			fieldNameParts = lastCloneFieldName.split( '_' );
			newFieldNumber = ( fieldNameParts.length > 1 ) ? ( fieldNameParts[1] + 1 ) : 2;
			newFieldName = fieldNameParts[0] + '_' + newFieldNumber;
			
			// Remove / add classes
			newField.removeClass( fieldClassPrefix + fieldName ).addClass( 'clone ' + fieldClassPrefix + newFieldName );
			
			// Adjust label and input ????
			newField.children( 'label' ).attr( 'for', newFieldName ).append( ' #' + newFieldNumber );

			// Remove unnecessary elements
			newField.children( '.description, p.slt-cf-clone-field' ).remove();

			// Reveal new field
			newField.slideDown();

			return false;
		});
	}

	// Get a value from a class
	function getValueFromClass( obj, prefix ) {
		var classes, value, i;
		classes = value = "";
		classes = obj.attr( "class" );
		classes = classes.split( " " );
		for ( i = 0; i < classes.length; i++ ) {
			if ( classes[i].length > prefix.length && classes[i].substr( 0, prefix.length ) == prefix ) {
				value = classes[i].substr( prefix.length );
				break;
			}
		}	
		return value;
	}

});
