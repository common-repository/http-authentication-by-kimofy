<?php
/*
Plugin Name: HTTP Authentication By KIMoFy
Plugin URI: https://kimofy.com/
Description: This plugin allows you to apply HTTP Authentication on your site. HTTP Authentication allows you to develop a site without letting the public view it without a designated username and password. You can apply HTTP Authentication all over the site or only the admin pages.
Version:     5.1
Donate link: https://paypal.me/KIMoFy
Author: KIMoFy
Author URI: https://kimofy.com/
*/

function http_auth_settings_link($links) { 
  $settings_link = '<a href="admin.php?page=http-auth-settings">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}

function http_auth_menu() {
	add_menu_page('HTTP Authentication Settings', 'HTTP Auth Settings', 'administrator', 'http-auth-settings', 'http_auth_settings_page');
  add_action( 'admin_init', 'http_auth_settings' );
}

function http_auth_settings() {
   register_setting( 'http-auth-settings-group', 'http_auth_username' );
   register_setting( 'http-auth-settings-group', 'http_auth_password' );
   register_setting( 'http-auth-settings-group', 'http_auth_message' );
   register_setting( 'http-auth-settings-group', 'http_auth_apply' );
   register_setting( 'http-auth-settings-group', 'http_auth_activate' );
}

function http_auth_settings_page() {
   echo '<div class="wrap">';
   echo '<h2>HTTP Authentication Settings</h2>';
   echo '<form method="post" action="options.php">';
   settings_fields( 'http-auth-settings-group' );
   do_settings_sections( 'http-auth-settings-group' );
   $http_activated = esc_attr( get_option('http_auth_activate') );
   $http_activated_value = "on";
   $http_activated_checked = "";
   if($http_activated == "on"){
      $http_activated_checked = "checked";
   }
   $http_apply = esc_attr( get_option('http_auth_apply') );
   $http_apply_admin = "checked";
   $http_apply_site = "";
   if($http_apply == "site"){
      $http_apply_admin = "";
      $http_apply_site = "checked";
   }
   wp_enqueue_style( 'style', plugins_url('/style.css', __FILE__) );
   ?>
   <table class="http-auth-table">
      <caption>HTTP Credentials :</caption>
      <tbody>
         <tr>
            <th>Username :</th>
            <td><input type="text" name="http_auth_username" value="<?php echo esc_attr( get_option('http_auth_username') ); ?>" class="regular-text" required /></td>
         </tr>
         <tr>
            <th>Password :</th>
            <td><input type="password" name="http_auth_password" value="<?php echo esc_attr( get_option('http_auth_password') ); ?>" class="regular-text" required /></td>
         </tr>
      </tbody>
	</table>

   

   <table class="http-auth-table http-for">
      <caption>Apply To :</caption>
      <tbody>
         <tr>
            <td><input type="radio" name="http_auth_apply" value="site" <?php echo $http_apply_site; ?> /><strong>Complete Site</strong></td>
         </tr>
         <tr>
            <td><input type="radio" name="http_auth_apply" value="admin" <?php echo $http_apply_admin ?> /><strong>Login and Admin Pages</strong></td>
         </tr>
      </tbody>
   </table>

   <table class="http-auth-table">
      <tbody>
         <tr>
            <td><input type="checkbox" name="http_auth_activate" value="<?php echo $http_activated_value; ?>" <?php echo $http_activated_checked; ?> /><strong>Activate HTTP Authorization</strong></td>
         </tr>
      </tbody>
   </table>

   <?php
   submit_button(); 
   echo '</form>';
   echo '</div>';
}

if( !is_admin() ){
   $http_activated = esc_attr( get_option('http_auth_activate') );
   if($http_activated != "on"){
      return;
   }
   $http_applicable = esc_attr( get_option('http_auth_apply') );
   if( $http_applicable == "admin" ){
      if( strpos($_SERVER['REQUEST_URI'], '/wp-admin') === false && strpos($_SERVER['REQUEST_URI'], '/wp-login') === false ){
         return;
      }
   }
   $realm = 'Restricted Area';
   $username = esc_attr( get_option('http_auth_username') );
   $password = esc_attr( get_option('http_auth_password') );

   $user = $_SERVER['PHP_AUTH_USER'];
   $pass = $_SERVER['PHP_AUTH_PW'];

   if ( !($user == $username && $pass == $password) ){
      $message = esc_attr( get_option('http_auth_message') );
      header('WWW-Authenticate: Basic realm="'.$realm.'"');
      header('HTTP/1.0 401 Unauthorized');
      if( empty($message)){
         $message = "This Site is Restricted. Please contact the administrator for access.";
      }
      die ( http_auth_cancel_page($message) );
   }
}

function http_auth_cancel_page($message = ''){
   $sitename = get_bloginfo ( 'name' );
   return '
<!DOCTYPE html>
<html>
<head>
<title>Unauthorized (401)</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" >
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style type="text/css">
body {
  background-color: #eee;
}

body, h1, p {
  font-family: "Helvetica Neue", "Segoe UI", Segoe, Helvetica, Arial, "Lucida Grande", sans-serif;
  font-weight: normal;
  margin: 0;
  padding: 0;
  text-align: center;
}

.container {
  margin-left:  auto;
  margin-right:  auto;
  margin-top: 177px;
  max-width: 1170px;
  padding-right: 15px;
  padding-left: 15px;
}

.row:before, .row:after {
  display: table;
  content: " ";
}

.col-md-6 {
  width: 50%;
}

.col-md-push-3 {
  margin-left: 25%;
}

h1 {
  font-size: 48px;
  font-weight: 300;
  margin: 0 0 20px 0;
}

.lead {
  font-size: 21px;
  font-weight: 200;
  margin-bottom: 20px;
}

p {
  margin: 0 0 10px;
}

a {
  color: #3282e6;
  text-decoration: none;
}
</style>
</head>

<body>
<div class="container text-center" id="error">
  <svg height="100" width="100">
    <polygon points="50,25 17,80 82,80" stroke-linejoin="round" style="fill:none;stroke:#ff8a00;stroke-width:8" />
    <text x="42" y="74" fill="#ff8a00" font-family="sans-serif" font-weight="900" font-size="42px">!</text>
  </svg>
 <div class="row">
    <div class="col-md-12">
      <div class="main-icon text-warning"><span class="uxicon uxicon-alert"></span></div>
        <h1>Unauthorized (401)</h1>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 col-md-push-3">
      <p class="lead">This server could not verify that you are authorized to access the document requested.  Either you supplied the wrong credentials (e.g., bad password), or your browser does not understand how to supply the credentials required.</p>
    </div>
  </div>
</div>

</body>
</html>';
}

if(function_exists("add_action") && function_exists("add_filter")) { 
   $plugin = plugin_basename(__FILE__); 
   add_filter("plugin_action_links_$plugin", 'http_auth_settings_link' );
   
   add_action( 'admin_menu', 'http_auth_menu' );
}
