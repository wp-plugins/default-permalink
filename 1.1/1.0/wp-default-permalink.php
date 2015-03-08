<?php
/*
Plugin Name: Default Permalink
Plugin URI: http://www.redwoodcity.jp/entry/default-permalink
Description: The process to Prevent the Use of a multi-byte URL of the default permalink.Multi-byte URL can be specified when the user explicitly specified.
Author: RedWoodCity
Author URI: http://www.redwoodcity.jp/
Text Domain: default-permalink
Domain Path: /languages/
Version: 1.0
*/


function auto_post_slug( $slug, $post_ID, $post_status, $post_type ) {
    if ( preg_match( '/(%[0-9a-f]{2})+/', $slug ) && !get_page($post_ID)->post_name ) {
        $slug = utf8_uri_encode( $post_type ) . '-' . $post_ID;
    }
    return $slug;
}
add_filter( 'wp_unique_post_slug', 'auto_post_slug', 10, 4  );


?>