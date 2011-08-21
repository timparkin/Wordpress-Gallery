=== SLT Custom Fields ===
Contributors: gyrus, adriantoll
Donate link: http://www.babyloniantimes.co.uk/index.php?page=donate
Tags: admin, administration, custom, meta, page, pages, post, posts, custom fields, form, user, profile
Requires at least: 3.0
Tested up to: 3.1.2
Stable tag: 0.6

Provides theme developers with tools for managing post and user custom fields.

== Description ==
This plugin is aimed at theme developers who want a set of tools that allows them to easily and flexibly define custom fields for all post types, and for user profiles.

== Installation ==
1. Upload the `slt-custom-fields` directory into the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Register your boxes and fields with `slt_cf_register_box` (see Usage instructions)

== Getting started ==

Because this code began life just managing custom fields for posts by defining meta boxes for post edit screens, the basic unit here is "the box". However, a "box" can also refer to a section in the user profile screen, or on media attachment edit screens.

A box is defined containing one of more custom fields, each with their own settings. You set a box to be associated with posts (in the generic sense, including pages and Custom Post Types!), users or attachments using the `type` parameter.

Say you've defined `film` as a Custom Post Type, and you want to create custom fields to set the director and writer for film posts. You would add something like this to your theme's functions.php (or indeed your plugin code):

``<?php

if ( function_exists( 'slt_cf_register_box') )
	add_action( 'init', 'register_my_custom_fields' );

function register_my_custom_fields() {
	slt_cf_register_box( array(
		'type'		=> 'post',
		'title'		=> 'Credits',
		'id'		=> 'credits-box',
		'context'	=> 'normal',
		'priority'	=> 'high',
		'fields'	=> array(
			array(
				'name'			=> 'director',
				'label'			=> 'Director',
				'type'			=> 'text',
				'scope'			=> array( 'film' ),
				'capabilities'	=> array( 'edit_posts' )
			),
			array(
				'name'			=> 'writer',
				'label'			=> 'Writer',
				'type'			=> 'text',
				'scope'			=> array( 'film' ),
				'capabilities'	=> array( 'edit_posts' )
			)
		)
	));
}

?>``

Then, when you want to output these values in a loop:

``<?php

echo '<p>Director: ' . slt_cf_field_value( "director" ) . '</p>';
echo '<p>Writer: ' . slt_cf_field_value( "writer" ) . '</p>';

?>``

This is just the beginning! Check the Usage instructions for registering boxes and fields, especially the parameters for fields. The most immediately interesting parameters for fields to check out are: `type`, `scope`, `options_type`.

There are some option query placeholders, for creating dynamic queries to populate select, radio and checkbox fields.

There are also a few hooks. If the plugin currently lacks something you need, odds are you'll be able to hack it using a hook!

See also the list of useful functions for outputting and managing field data.


== Usage ==

= General settings =
You can update plugin settings with the following function:

`<?php slt_cf_setting( $key, $value ); ?>`

* **$key** (string) (required) - The key of the setting you want to update.
* **$value** (mixed) (required) - The value you want to set the setting to.

Here are the keys for the various settings:

* **prefix** (string) (default: '_slt_') - To avoid clashes with other plugins, all custom fields are stored in the database with a prefix on the key name. An underscore at the start means these values won't show up in the default WordPress custom fields meta box. If you want to use a different prefix, set it at the start of your theme's `functions.php` before you start using any custom fields, and never change it!
* **hide_default_custom_meta_box** (boolean) (default: true) - Whether or not to hide the default custom fields meta box on post edit screens.
* **css_url** (string) - The URL of a stylesheet file to override the built-in `slt-custom-fields.css` stylesheet.
* **datepicker_css_url** (string) - The URL of a stylesheet file to override the built-in theme for the jQuery datepicker (Smoothness).
* **datepicker_default_format** (string) (default: 'dd/mm/yy') - The default format for the jQuery datapicker. For available formats, see http://docs.jquery.com/UI/Datepicker/formatDate. This can be overridden for particular fields. NOTE: Change this to 'yy/mm/dd' if you want to be able to easily sort by date fields!

= Registering boxes and fields =
A box is registered thus:

`<?php slt_cf_register_box( $box ); ?>`

`$box` is an array of values defining the box:

* **type** ( string | array ) ( post | user | attachment ) (required) - The type of box, i.e. which type of object its fields are applied to. You can pass multiple values in an array.
* **id** (string) (required) - A unique ID for the box.
* **title** (string) (required) - A title for the box.
* **description** (string) (optional) - A description for the box.
* **context** (string) ( normal | advanced | side ) (optional) (default: 'advanced') - The context for boxes on post edit screens, i.e. where on the edit screen it appears.
* **priority** (string) ( low | default | high ) (optional) (default: 'default') - On post edit screens, this governs how high up within the box's context it will appear.
* **fields** (array) (required) - The field definitions for this box.

The fields array should contain an array for each field, defining the following values:

* **name** (string) (required) - A unique name for the field.
* **label** (string) (required) - A label for the field. For multiple checkboxes and radio buttons, this label is actually for the legend element; each input's label is created from the specified options.
* **type** (string) ( text | textarea | textile | wysiwyg | select | file | radio | checkbox | checkboxes | date | gmap ) (optional) (default: 'text' ) - The type of input for the field. Note: file uploads are currently not allowed for user profiles; attachments can currently only accept text and select types.
* **scope** (array) (required) - For fields in post meta boxes, the scope defines which post type(s) the field should apply to. To apply to posts (of any type) assigned to terms in a taxonomy, pass the taxonomy name as the key, with an array of term names as the value, e.g. `array( 'category' => array( 'A Category' ) )`. Likewise, to apply to pages associated with particular templates, use `array( 'template' => array( 'page_template.php' ) )`. For fields in user profiles, the scope defines which user role(s) the field should apply to. For fields for attachments, the scope can define the MIME types the field should apply to; pass an empty array to apply to all attachments. To apply to particular posts, users or attachments by ID, use something like `array( 'posts' => array( 49, 66 ) )`.
* **label_layout** (string) ( block | inline ) (optional) (default: 'block') - How to position the label in relation to the input. 'block' puts the label on its own line above the input. For text, file uploads and selects, 'inline' will put the input on the same line as the label. Textarea and WYSIWYG fields always have 'block' labels; single checkboxes always have 'inline' labels.
* **hide_label** (boolean) (optional) (default: false) - Whether to hide the label. Use with care!
* **file_button_label** (string) (optional) (default: 'Select file') - A label for the button in when field type is `file`.
* **file_removeable** (boolean) (optional) (default: true) - For `file` fields, this signals whether to include a checkbox to remove the file from the field.
* **input_prefix** (string) (optional) - A prefix to place before the input. Only applicable to text and single-choice select fields.
* **input_suffix** (string) (optional) - A suffix to place after the input. Only applicable to text and single-choice select fields.
* **description** (string) (optional) - A description for the field.
* **default** (mixed) (optional) - Default value(s) for the field. For multiple select inputs and checkboxes, this should be an array of values. For `gmap` fields, it should also be an array, with the following keys: `centre_latlng`, `zoom`, `marker_latlng`.
* **multiple** (boolean) (optional) (default: false) - For select inputs, whether the select should allow multiple values.
* **options_type** (string) ( static | posts | users ) (optional) (default: 'static') - For multiple select inputs and checkboxes, what type of options are being supplied. 'static' means you need to supply the options; 'posts' means the input will be populated with the results of a `get_posts` query; 'users' means the input will be populated with users.
* **options** (array) (optional) - For 'static' options type fields (see above), an array of option values. The format should be: `array( 'Field label 1' => 'Field value 1', 'Field label 2' => 'Field value 2' )`. Option groups for select inputs are supported; include entries in the array like this: `array( 'Option group label' => '[optgroup]' )`.
* **options_query** (array) (optional) (default for posts: `array( 'posts_per_page' => -1 )`; default for users: `array()`) - For 'posts' option type fields, this value is passed to `get_posts` to populate the options. For 'users' option type fields, this should be an array of roles from which users are selected; an empty value means all users.
* **no_options** (string) (optional) (default: 'No options to choose from.' ) - Text to display if there's no options returned for populating the field.
* **exclude_current** (boolean) (optional) (default: true) - For posts and users options queries, whether to exclude the object being edited from the options.
* **single** (boolean) (optional) (default: true) - For fields that have multiple values (e.g. multiple checkboxes and selects), setting this to `false` will create multiple fields in the `postmeta` table, instead of storing a serialized array of values in one field. This allows for more flexible use of the `meta_query` parameter for queries.
* **required** (boolean) (optional) (default: false) - Currently only relevant for non-static options type fields. By default, an empty option will be included to allow no option to be selected. The empty option will use the `empty_option_text` value.
* **empty_option_text** (string) (optional) (default: '[None]') - If `required` is false, this is the text used for the empty option.
* **group_options** (boolean) (default: false ) - For non-static option types, setting this to true means the items will be grouped, e.g. for users, by role; for posts, by category.
* **width** (integer) (optional) - A width in em units for the input. For the `gmap` field type, the unit is pixels.
* **height** (integer) (optional) - A height in em units for the input. For the `gmap` field type, the unit is pixels.
* **capabilities** (array) (optional) (default for posts: `array( 'edit_posts' )`; default for users: `array( 'edit_users' )`) - The capabilities define which capabilities allow a user to manage this field. The field will appear for a user who has *any* of the capabilities given.
* **charcounter** (boolean) (optional) (default: false) - For textarea and textile fields, whether a JavaScript character counter should appear.
* **allowtags** (array) (optional) - For text and textarea field types, this array can specify HTML tags to be allowed, e.g. `array( 'a', 'em', 'strong' )`. By default, all tags are stripped.
* **autop** (boolean) (optional) (default: false) - For textarea and textile fields, whether to automatically add paragraph and line break tags.
* **preview_size** (string) ( thumbnail | medium | large | full ) (optional) (default: 'medium') - For file uploads, this specifies the size of image that should be shown when an image has been uploaded.
* **datepicker_format** (string) (optional) (default: `datepicker_default_format`) - The format for the jQuery datapicker. For available formats, see http://docs.jquery.com/UI/Datepicker/formatDate. Note that if you're going to order queries by this field, you'll need to format according, e.g. "yy/mm/dd".
* **location_marker** (boolean) (optional) (default: true) - For `gmap` fields, this flag signals whether or not a marker can be placed to pinpoint a location.
* **gmap_type** (string) (optional) ( 'hybrid' | 'roadmap' | 'satellite' | 'terrain' ) (default: 'roadmap') - For `gmap` fields, sets the initial map view type.

= Option query placeholders =
Sometimes you want to pass data to queries that is only available at runtime. For instance, you might want a field to be populated with posts, via the `options_query` parameter, that are selected according to a another custom field which contains post IDs.

* **[OBJECT_ID]** Replaced with the ID of the object currently being edited
* **[TERM_IDS]** Replaced with the IDs of terms from the specified taxonomy that are associated with the current object. It's assumed that this will be used as the value for the `terms` parameter within the `tax_query` parameter; the taxonomy will be read from that array.

So, `options_query` might be defined for a field like this:

`'options_query' => array( 'posts_per_page' => -1, 'post_type' => 'article', 'meta_key' => slt_cf_field_key('article_issue'), 'meta_value' => '[OBJECT_ID]' )`

This field would be populated by all articles (a custom post type) where the `article_issue` field (indicating which issue the article is assigned to) is set to the ID of the issue currently being edited.

= Hooks =
The plugin provides hooks to let developers extend its functionality without hacking the plugin code.

**slt_cf_init** (action) - A generic hook, mostly for dependent plugins to hook to - see: http://core.trac.wordpress.org/ticket/11308#comment:7

**slt_cf_init_boxes** (filter) - This is applied to the registered boxes array after it's been initialized. Should return the possibly modified boxes array.

**slt_cf_check_scope** (filter) - Run when none of the built-in scope checks matches. Should return a boolean value which determines whether the scope check has passed or not. Seven arguments are passed to help decide on the scope check outcome: `$scope_match` is the current value of the scope match test (usually false); `$request_type` is the type of the current admin request, e.g. 'post' for any type of post editing or 'user' for editing a user profile; `$scope` is the scope of the current request, e.g. the post type or user's role; `$object_id` is the ID of the post or user being edited; `$scope_key` is the key of the scope being checked; `$scope_value` is the value of the scope being checked; `$field` is the array of settings for the field being checked. Example:

``add_action( 'slt_cf_check_scope', 'my_scope_check', 10, 7 );
function my_scope_check( $scope_match, $request_type, $scope, $object_id, $scope_key, $scope_value, $field ) {
	// This example will make sure fields with a 'global' scope apply everywhere the containing box appears
	if ( $scope_key == 'global' )
		$scope_match = true;
	return $scope_match;
}``

**slt_cf_populate_options** (filter) - Run when none of the built-in option types match. Should return an array of options for select, checkboxes, radios, etc., in the same format as described for the `options` passed when `options_type` is 'static'.  Five arguments are passed to help decide on how to populate the options: `$options` is the current array of options (usually empty); `$request_type` is the type of the current admin request, e.g. 'post' for any type of post editing or 'user' for editing a user profile; `$scope` is the scope of the current request, e.g. the post type or user's role; `$object_id` is the ID of the post or user being edited; `$field` is the array of settings for the field being checked.

**slt_cf_pre_save_value** (filter) - Run just before the custom field value is saved. Should return the possibly modified value. Five arguments are passed: `$value` is the field value; `$request_type` is the type of the current admin request, e.g. 'post' for any type of post editing or 'user' for editing a user profile; `$object_id` is the ID of the post or user being edited; `$object` is entire object being edited; `$field` is the array of settings for the field being saved. Example:

``add_action( 'slt_cf_pre_save_value', 'my_value_filter', 10, 5 );
function my_value_filter( $value, $request_type, $object_id, $object, $field ) {
	// This example will make sure the 'important-notice' field has 'IMPORTANT!' prepended
	if ( $field['name'] == 'important-notice' && ! empty( $value ) && substr( $value, 0, 10 ) != 'IMPORTANT!' )
		$value = 'IMPORTANT! ' . $value;
	return $value;
}``

**slt_cf_pre_save** (action) - Run just before the custom field is saved.

= Retrieving values =
A wrapper function is provided for getting custom field values is provided:

`<?php slt_cf_field_value( $key [, $type, $id, $before, $after, $echo, $single ] ) ?>`

* **$key** (string) (required) - The key of the field. The prefix is added automatically.
* **$type** (string) ( post | user ) (optional) (default: 'post') - The type of object this field applies to.
* **$id** (integer) (optional) - The ID of the object this field applies to. When `$type` is set to 'post', this defaults to the current post ID.
* **$before** (string) (optional) (default: '') - Some text or HTML to prepend to the value. This is only part of what's returned if there is a value to return.
* **$after** (string) (optional) (default: '') - Some text or HTML to append to the value. This is only part of what's returned if there is a value to return.
* **$echo** (boolean) (optional) (default: false ) - Whether to echo or return the value.
* **$single** (boolean) (optional) (default: true ) - Set this to false when the field has been defined with `single` set to false.

There's also a function to retrieve all custom field values that have been set for a certain object (returned as an array, with prefix-less keys):

`<?php slt_cf_all_field_values( [ $type, $id ] ) ?>`

* **$type** (string) ( 'post' | 'user' | 'attachment' ) (optional) (default: 'post') - The type of object.
* **$id** (integer) (optional) - The ID of the object. When `$type` is set to 'post', this defaults to the current post ID.

And a simple one to add the prefix to a field key:

`<?php slt_cf_field_key( $key[, $object_type ] ) ?>`

* **$key** (string) (required) - The key to put the prefix on.
* **$object_type** (string) (optional) ('post' | 'user' | 'attachment') (default: 'post') - The object type. It's only really important to pass this when the object is an attachment, because attachments get the leading underscore stripped from the prefix.

If you've set the format for a date field to `yy/mm/dd`, to enable easy sorting, when you output the date you can use this function to reverse it. It optionally returns a timestamp for alternative formatting using `date`:

`<?php slt_cf_reverse_date( $date_string[, $sep, $to_timestamp ] ) ?>`

* **$date_string** (string) (required) - The date string to reverse.
* **$sep** (string) (optional) (default: '/') - The separator character.
* **$to_timestamp** (boolean) (optional) (default: false) - Whether to return a timestamp or not.

= Other useful functions =

`<?php slt_cf_get_posts_by_custom_first( $key [, $query, $custom_order, $numeric, $object_type] ) ?>`

This function gets posts, but sorts first by the specified custom field key, then by a standard WordPress field.

* **$key** (string) (required) - The key of the custom field to sort by first (prefix not needed).
* **$query** (array) (optional) (default: array()) - The `WP_Query` parameters, as per http://codex.wordpress.org/Function_Reference/WP_Query#Parameters - including the second lot of ordering parameters.
* **$custom_order** (string) ( 'ASC' | 'DESC' ) (optional) (default: 'DESC') The `order` value for the custom field ordering.
* **$numeric** (boolean) (optional) (default: false) Set to `true` if the custom field value to be ordered by is numeric.
* **$object_type** (string) ( 'post' | 'attachment' ) (optional) (default: 'post')

= Interface elements that can be useful outside this plugin =
Some field types have been included in this plugin in a way that exposes their code for use outside this plugin, e.g. on a theme options page.

`<?php slt_cf_gmap( $type = 'output', $name = 'gmap', $values = 'stored_data', $width = 500, $height = 300, $location_marker = true, $map_type_id = 'roadmap', $echo = true, $js_callback = '', $required = true ) ?>`

This function outputs a Google Map, for display or for use in a form.

* **$type** (string) ( output | input ) (optional) (default: 'output') - Whether the map is for display or for use in a form.
* **$name** (string) (optional) (default: 'gmap_{count}') - For `input` type maps, a name used as a base for the hidden input field names; for `output` type maps, this is used as based for the ID of the map container (it will be `$name_map_container`).
* **$values** (mixed) (optional) (default: 'stored_data') - Pass the default or current values as an array. The array keys, representing the values stored by the map, are: `centre_latlng` (the latitude and longitude values for the map's centre, comma-separated); `zoom` (the zoom level); `marker_latlng` (the latitude and longitude values for the location marker). If this is set to 'stored_data', the function will attempt to get values from the current post / user metadata.
* **$width** (integer) (optional) (default: 500) - Map width in pixels.
* **$height** (integer) (optional) (default: 300) - Map height in pixels.
* **$location_marker** (boolean) (optional) (default: true) - Whether or not to use a location marker.
* **$map_type_id** (string) (optional) ( 'hybrid' | 'roadmap' | 'satellite' | 'terrain' ) (default: 'roadmap') - Sets the initial map view type.
* **$echo** (boolean) (optional) (default: true) - Whether to echo or return the generated output.
* **$js_callback** (string) (optional) (default: '') - If given, this will be the name of a JavaScript function to be called once the map has been written to the page. The callback will be passed a reference to the Google Map object.
* **$required** (boolean) (optional) (default: true) - For maps in a form (type = 'input'), if this is set to false, a checkbox will be included, unchecked by default, controlling whether or not to use the  map.

For `input` maps, when the form is submitted, `$_POST[$name]` will be an array containing the values set by the manipulation of the map, with keys corresponding to the values detailed above.

`<?php slt_cf_file_select_button( $name, $value, $label = 'Select file', $preview_size = 'thumbnail', $removable = true ) ?>`

This function inserts a file select field, which includes a button to open the Media Library overlay, an optional 'Remove' checkbox, a hidden field containing the file's ID, and a preview where appropriate.

* **$name** (string) (required) - The name for the field containing the file's ID.
* **$value** (string) (required) - The current value of the field.
* **$label** (string) (optional) (default: 'Select file') A label for the button.
* **$preview_size** (string) (optional) (default: 'thumbnail') The size for the preview of images.
* **$removable** (boolean) (optional) (default: true) Should there be a checkbox allowing users to remove the selected file from the field?

= Shortcodes =

`[slt-cf-gmap]`

This shortcode, when used in a post's content, will display the map (if available) for that post. You can use the following optional attributes:

* **name** (string) (default: value set for the first map field) - The name of the map field to use. By default, the first map field set for the post will be used.
* **width** (integer) (default: value set the the map field) - Width in pixels.
* **height** (integer) (default: value set the the map field) - Height in pixels.

The map container generated will have the ID `$name_map_container`.

== Changelog ==
= 0.6 =
* Added `attachment` as an possible value of the box `type` parameter - custom fields for attachments! (Though accepted field types are limited to text and select for now.) Includes many minor changes to plugin code. Thanks to Frank at http://wpengineer.com/2076/add-custom-field-attachment-in-wordpress/
* Added `slt_cf_init` hook; changed initialization to allow dependent plugins to hook in
* Added `slt_cf_get_current_fields`
* Branched scope checking out from initialization code into separate `slt_cf_check_scope` function
* Added `gmap` field type
* Folded the functionality from the SLT File Select plugin into this plugin's code, leaving the functionality exposed for use in theme options pages etc.
* Added `single` field parameter, to allow storing multiple-choice values in separate postmeta fields instead of in a serialized array - this is for easier `meta_query` matching
* Added `template` option for the field `scope` parameter, to match page templates
* Added ctype functions for better validation
* Added `slt_cf_reverse_date` function
* Added `slt_cf_pre_save` action hook
* Added `$to_timestamp` parameter for `slt_cf_reverse_date` function

= 0.5.2 =
* Adjusted `options_query` default to include `posts_per_page=-1` is included in query if not specified

= 0.5.1 =
* Changed selection of users to use new WP 3.1 `get_users` function
* Made the `scope` parameter for fields required
* Added parameter type validation

= 0.5 =
* Added `slt_cf_get_posts_by_custom_first` function
* Changed behaviour of `required`, so the empty option isn't included for multiple selects
* Added `description` parameter for boxes
* Added `[TERM_IDS]` placeholder
* Added "No options" alert and `no_options` parameter for fields
* Added `exclude_current` parameter for fields
* Changed `file` field type to use SLT File Select plugin (with interface to Media Library)
* Added `file_button_label` and `file_removeable` parameters for fields
* Changed the way `slt_cf_display_post` checks to exclude link and comment screens in case custom post types 'link' or 'comment' are registered

= 0.4.2 =
* Fixed display of block labels when width is set (thanks Daniele!)
* Empty option only displayed for non-static selects (thanks Daniele!)
* A bunch of changes to how input prefixes and suffixes are handled (thanks again Daniele!)
* For clarity, the field settings `prefix` and `suffix` have been renamed `input_prefix` and `input_suffix`

= 0.4.1 =
* Added `required` and `empty_option_text` settings for fields

= 0.4 =
* Decreased priority of `show_user_profile` and `edit_user_profile` actions, to let other plugins (e.g. User Photo) put their bits in the 'About the user'-headed section
* Added `slt_cf_field_key` function
* Added `slt_cf_all_field_values` function
* Added `slt_cf_populate_options` filter for custom option types
* Added `prefix` and `suffix` settings for fields
* Added `slt_cf_default_id` function for better default ID handling
* Changed datepicker formatting setting so it can be overridden on a per-field basis
* Added `OBJECT_ID` placeholder for `options_query`
* Fixed bug that creates an `optgroup` tag when an options value is zero (thanks Daniele!)

= 0.3.1 =
* Fixed an error in `slt_cf_check_scope` handling

= 0.3 =
* Added support for assigning fields to posts with certain taxonomy terms assigned to them
* Added `group_options` setting for fields
* Added jQuery datepicker for date field type
* Altered interaction with AJAX requests to prevent 'undefined function' errors
* Added `slt_cf_check_scope` and `slt_cf_pre_save_value` filter hooks
* New built-in scope matches against post or user IDs
* Multiple values allowed for box type

= 0.2 =
* Added support for user profile custom fields
* Added check for duplicate field names in post meta boxes
* Improved initialization and interaction with hooks
* Added `users` value for `options_type`, to populate a field with users
* Added output options for `slt_cf_field_value`
* Added `css_url` setting to override default styles

= 0.1 =
* First version

== Other notes ==
= Ideas / to-do =

* Does `file` field type work OK for user profiles?
* GMap output for users? Default object ID for users is current user - doesn't work for user profile front-end output.
* Proper errors for missing 'type' parameter for boxes
* Post templates as scope conditions
* A `reciprocal` flag for fields. That is, if a field on post edit screens allows the selection of users, and the `reciprocal` flag is set, user profiles would automatically allow selection of the posts they're attached to.
* Add support for multiple values for the same field (underway - called 'cloning')
* Extend use of `required` field setting to enforce validation of field entries
* The capabilities system could be improved. Currently, if a field applies to a post type and a user role, you have to supply capabilities to edit that post type and to edit users for the capabilities check; if the user has either, they'll be able to use that field. Should capabilities be more closely related to corresponding items in the scope array?
* Add more hooks?
* More control over TinyMCE, removing irrelevant buttons, etc.
* File uploads for user profiles - how to 'attach' media library items to users?
* Add validation mechanisms
* `slt_cf_field_value` to handle echoing non-string values?
