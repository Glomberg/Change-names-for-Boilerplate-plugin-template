<?php
/**
 * Change names for Boilerplate Plugin Template
 *
 * For example, if your plugin is named 'example-me' then:
 * rename files from plugin-name to example-me
 * change plugin_name to example_me
 * change PLUGIN_NAME_ to EXAMPLE_ME_
 *
 * Date: 05.01.2018
 * Author: Viktor Ievlev (Glomberg) bazz@bk.ru
 *
 */

/****************************************************/
$old_file_name   = 'plugin-name';
$new_file_name   = 'example-me';

$old_title       = 'plugin_name';
$new_title       = 'example_me';

$old_title2      = 'Plugin_Name';
$new_title2      = 'Example_Me';

$old_prefix      = 'PLUGIN_NAME_';
$new_prefix      = 'EXAMPLE_ME_';
/****************************************************/

$path = __DIR__;

/**
 * The function renames the file
 *
 * @param $name - string - file path
 */
function file_renaming( $name ) {

	global $old_file_name, $new_file_name;

	$new_name = str_replace( $old_file_name, $new_file_name, basename( $name ) );
	$rename = rename( $name, dirname( $name ) . '/' . $new_name );
	if( $rename ) {
		echo 'File "' . basename( $name ) . '" was renamed to "' . $new_name . '".<br>';
	} else {
		echo 'Renaming failure!<br>';
	}

}

/**
 * Rename content of the file
 *
 * @param $name - string - file path
 */
function change_titles_and_prefixes( $name ) {

	global $old_file_name, $new_file_name, $old_title, $new_title, $old_title2, $new_title2, $old_prefix, $new_prefix;

	$content = file_get_contents( $name );
	$new_content = str_replace(
		array( $old_file_name, $old_title, $old_title2, $old_prefix ),
		array( $new_file_name, $new_title, $new_title2, $new_prefix ),
		$content
	);
	if( file_put_contents( $name, $new_content ) &&  $content != $new_content ) {
		echo 'New content was written to "' . basename( $name ) . '".<br>';
	}

}

/**
 * General utility function
 *
 * @param $path
 */
function boilerplate_change_names( $path ) {

	global $old_file_name;

	$list = glob( $path . '/*', GLOB_MARK );

	foreach( $list as $name ) :

		if( $name != __FILE__ ) {
			if( ! is_dir( $name ) ) {

				change_titles_and_prefixes( $name );

				$e = strpos( basename( $name ), $old_file_name );
				if( $e !== false) {
					file_renaming( $name );
				}

			} else {

				boilerplate_change_names( $name );

			}
		}

	endforeach;

}

echo '<pre>';
boilerplate_change_names( $path );
echo '</pre>';
