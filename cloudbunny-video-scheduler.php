php
<?php
/*
Plugin Name: CloudBunny Video Scheduler
Description: Schedule and stream videos from Bunny.net
Version: 1.0
Author: EstonianWitchesAssociation.ee
*/

if (!defined('ABSPATH')) exit;

class CloudBunnyVideoScheduler {
private $api_handler;
private $scheduler;

public function __construct() {
$this->load_dependencies();
$this->init_hooks();
}

private function load_dependencies() {
require_once plugin_dir_path(__FILE__) . 'includes/class-api-handler.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-video-post-type.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-scheduler.php';
}

private function init_hooks() {
add_action('init', [$this, 'register_post_types']);
add_action('admin_menu', [$this, 'add_admin_menu']);
add_action('admin_init', [$this, 'register_settings']);
}

public function register_post_types() {
$video_post_type = new CloudBunnyVideoPostType();
$video_post_type->register();
}

public function add_admin_menu() {
add_menu_page(
'CloudBunny Settings', 
'CloudBunny', 
'manage_options', 
'cloudbunny-settings', 
[$this, 'render_settings_page']
);
}

public function register_settings() {
register_setting('cloudbunny_settings_group', 'cloudbunny_api_key');
register_setting('cloudbunny_settings_group', 'cloudbunny_stream_url');
}

public function render_settings_page() {
?>
<div class="wrap">
<h1>CloudBunny Video Scheduler Settings</h1>
<form method="post" action="options.php">
<?php
settings_fields('cloudbunny_settings_group');
do_settings_sections('cloudbunny_settings_group');
?>
<table class="form-table">
<tr>
<th>API Key</th>
<td>
<input 
type="text" 
name="cloudbunny_api_key" 
value="<?php echo esc_attr(get_option('cloudbunny_api_key')); ?>"
/>
</td>
</tr>
<tr>
<th>Stream URL</th>
<td>
<input 
type="text" 
name="cloudbunny_stream_url" 
value="<?php echo esc_attr(get_option('cloudbunny_stream_url')); ?>"
/>
</td>
</tr>
</table>
<?php submit_button(); ?>
</form>
</div>
<?php
}
}

new CloudBunnyVideoScheduler();
```