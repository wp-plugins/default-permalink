<?php
/*
Plugin Name: Default Permalink
Plugin URI: http://www.redwoodcity.jp/entry/default-permalink
Description: The process to Prevent the Use of a multi-byte URL of the default permalink.Multi-byte URL can be specified when the user explicitly specified.
Author: RedWoodCity
Author URI: http://www.redwoodcity.jp/
Text Domain: default-permalink
Domain Path: /languages/
Version: 1.1
*/

define('DP_NAME', 'Default Permalink');

function auto_post_slug( $slug, $post_ID, $post_status, $post_type ) {

	if( get_option('df_enable') == "Enable") {
		if ( preg_match( '/(%[0-9a-f]{2})+/', $slug ) && !get_page($post_ID)->post_name ) {
			$slug = utf8_uri_encode( $post_type ) . '-' . $post_ID;
		}
	}
	
    return $slug;
}
add_filter( 'wp_unique_post_slug', 'auto_post_slug', 10, 4  );



add_action('admin_menu', 'df_menu');

function df_menu() {
  add_options_page( DP_NAME, DP_NAME, 'manage_options', 'df_menu', 'df_options_page');
  add_action( 'admin_init', 'register_df_settings' );
}

function register_df_settings() {
  register_setting( 'df-settings-group', 'df_enable' );
}

function df_options_page() {
  // HTML を表示させるコード
?>
 <div class="wrap">
    <h2><?php echo DP_NAME; ?></h2>
    <form method="post" action="options.php">
      <?php 
        settings_fields( 'df-settings-group' );
        do_settings_sections( 'df-settings-group' );
      ?>
      <table class="form-table">
        <tbody>
          <tr>
            <th scope="row">
              <label for="df_enable">Enable</label>
            </th>
              <td><input type="checkbox" id="df_enable" name="df_enable" value="Enable" <?php if( get_option('df_enable') == "Enable" ){ echo ' checked="checked"';} ?>> <label for="df_enable">To enable</label></td>
          </tr>
        </tbody>
      </table>
      <?php submit_button(); ?>
    </form>
  </div>
<?php
}

?>