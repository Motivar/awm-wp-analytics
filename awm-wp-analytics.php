<?php
/*
Plugin Name: AWM WP Analytics
Plugin URI: https://motivar.io
Description: Track posts analytics with REST API.
Version: 1
Author: Giannopoulos Nikolaos
Author URI: https://motivar.io
 */

define('awm_wp_analytics_url', plugin_dir_url(__FILE__));
define('awm_wp_analytics_path', plugin_dir_path(__FILE__));
define('awm_wp_analytics_relative_path', dirname(plugin_basename(__FILE__)));
define('awm_wp_analytics_script_version', 0.2);

require_once 'includes/init.php';
