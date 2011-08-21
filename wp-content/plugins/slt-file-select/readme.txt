=== SLT File Select ===
Contributors: gyrus
Donate link: http://www.babyloniantimes.co.uk/index.php?page=donate
Tags: admin, administration, media, media library, custom fields
Requires at least: 3.0
Tested up to: 3.1.1
Stable tag: 0.2

Provides theme developers with a way to integrate the Media Library overlay dialogue with custom fields.

== Description ==
This plugin is aimed at theme developers who need a form interface for selecting an item from the Media Library, or uploading a new file into the Library. A hidden field is populated with the ID of the selected item, and for image files a preview of a specified size is displayed. For non-image files, an icon and a file link is shown.

`<?php slt_fs_button( $name, $value, $label = 'Select file', $preview_size = 'thumbnail', $removable = true ) ?>`

This function inserts the file select field, which includes a button to open the Media Library overlay, an optional 'Remove' checkbox, a hidden field containing the file's ID, and a preview where appropriate.

* **$name** (string) (required) - The name for the field containing the file's ID.
* **$value** (string) (required) - The current value of the field.
* **$label** (string) (optional) (default: 'Select file') A label for the button.
* **$preview_size** (string) (optional) (default: 'thumbnail') The size for the preview of images.
* **$removable** (boolean) (optional) (default: true) Should there be a checkbox allowing users to remove the selected file from the field?

== Installation ==
1. Upload the `slt-file-select` directory into the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Include the file select button in your form with `slt_fs_button` (see Usage instructions)

== Changelog ==
= 0.2.1 =
* Disabled Flash uploader for Media Library overlay when plugin is invoked
* Changed JS to remove 'Insert into Post' button then prepend 'Select' button due to odd circumstances where the 'Insert into Post' button is missing

= 0.2 =
* First release
