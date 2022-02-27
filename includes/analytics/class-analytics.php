<?php
if (!defined('ABSPATH')) {
 exit;
}


/**
 * this is the main class of the plugin
 */
require_once 'analytics-functions.php';
require_once 'class-analytics-rest.php';

class AWM_WP_Analytics
{

 private $awm_post_type_options; /*the post types which use the analytics*/

 public function __construct()
 {
  $this->awm_post_type_options = get_option('awm_wp_anal_post_types') ?: array();

  add_filter('awm_add_options_boxes_filter', array($this, 'awm_import_options'), PHP_INT_MAX);
  add_filter('awm_add_meta_boxes_filter', array($this, 'analytics_metas'), PHP_INT_MAX);
  add_shortcode('awm-wpanl_recently_seen', array($this, 'recently_seen'));
  add_action('init', array($this, 'register_scripts_and_styles'), 100);
  add_action('wp_enqueue_scripts', array($this, 'enqueue_styles_script'), 100);
 }

 public function enqueue_styles_script()
 {
  if ((is_single() || is_front_page()) && in_array(get_post_type(), $this->awm_post_type_options)) {
   global $post;
   wp_localize_script('awm-wp-analytics', 'awm_wp_analytics_vars', array('awm_wp_id' => $post->ID));
   wp_enqueue_script('awm-wp-analytics');
  }
 }

 public function register_scripts_and_styles()
 {

  //wp_register_style('awm-global-style', awm_wp_analytics_url . 'assets/css/global/awm-global-style.min.css', false, '1.1.0');
  wp_register_script('awm-wp-analytics', awm_wp_analytics_url . 'assets/js/analytics.js', array(), awm_wp_analytics_script_version, true);
 }
 public function awm_import_options($boxes)
 {
  $boxes += array(
   'awm_import_options' => array(
    'title' => __('Analytics Settings', 'awm-wp-analytics'),
    'callback' => 'awm_wp_analytics_types',
    'parent' => 'edit.php?post_type=awm_field',
    'explanation' => __('Set the content types you want to track in the website', 'awm-wp-analytics')
   )
  );

  return $boxes;
 }

 public function recently_seen($atts)
 {
  extract(shortcode_atts(array(
   'post_type' => '',
   'exclude_id' => '',
  ), $atts));

  return '<div id="awm-wpanl-recently-seen" class="motivar_wrap single_arrow_slider" language="' . ICL_LANGUAGE_CODE . '" post_type="' . $post_type . '" exclude="' . $exclude_id . '"><h3 class="awm-wpanl_center">' . __('Recently viewed', 'motivar') . '</h3><div class="awm-wpanl-recently-wrapper"></div></div>';
 }
 public function analytics_metas($metaboxes)
 {
  $post_types = $this->awm_post_type_options;
  if (empty($post_types)) {
   return $metaboxes;
  }
  $metaboxes['stats'] = array(
   'title' => __('Analytics box', 'awm-wp-analytics'),
   'postTypes' => $post_types,
   'context' => 'side',
   'priority' => 'low',
   'library' => awm_wp_analytics_post_stats(),
  );
  return $metaboxes;
 }
}

new AWM_WP_Analytics();
