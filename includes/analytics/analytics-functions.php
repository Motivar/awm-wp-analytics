<?php
if (!defined('ABSPATH')) {
 exit;
}
if (!function_exists('awm_wp_analytics_post_stats')) {
 /**
  * here are the fields for the lead
  */
 function awm_wp_analytics_post_stats()
 {
  return array(
   '_awm_wp_views' => array(
    'label' => __('Views', 'awm-wp-analytics'),
    'case' => 'input',
    'type' => 'number',
    'attributes' => array('disabled' => true),
    'admin_list' => true
   )
  );
 }
}



if (!function_exists('awm_wp_analytics_types')) {
 function awm_wp_analytics_types()
 {
  return array(
   'awm_wp_anal_post_types' => array(
    'label' => __('Post types', 'awm-wp-analytics'),
    'case' => 'post_types',
    'attributes' => array('multiple' => 1)
   ),
   'awm_wp_anal_taxonomies' => array(
    'label' => __('Taxonomies', 'awm-wp-analytics'),
    'case' => 'taxonomies',
    'attributes' => array('multiple' => 1)
   ),

  );
 }
}
