<?php
if (!defined('ABSPATH')) {
  exit;
}

class AWM_WP_Analytics_API extends WP_REST_Controller
{


  /**
   * Registers all Filox Clearance API endpoints using the proper custom WP REST API configuration
   */
  public function register_routes()
  {

    register_rest_route('awm-wp-analytics/v1', "/analytics/", array(
      array(
        "methods" => WP_REST_Server::CREATABLE,
        "callback" => array($this, "awm_send_analytics"),
        "permission_callback" => function () {
          return true;
        }
      )
    ));

    register_rest_route('awm-wp-analytics/v1', "/recently-viewed/", array(
      array(
        "methods" => WP_REST_Server::READABLE,
        "callback" => array($this, "awm_show_recently"),
        "permission_callback" => function () {
          return true;
        }
      )
    ));
  }

  /**
   * Display recently viewed properties
   */
  public function awm_show_recently($request)
  {
    $content = array();
    if (!empty($request)) {
      global $sbpSession;
      global $sitepress;
      $params = $request->get_params();
      $post_type = $params['post_type'];
      $language = $params['lang'];
      $exclude = !empty($params['exclude']) ? $params['exclude'] : 0;

      if ($post_type) {
        global $sbpSession;
        $recently_viewed = $sbpSession->get('recently_viewed') ?: array();
        if (isset($recently_viewed[$post_type]) && !empty($recently_viewed[$post_type])) {
          switch ($post_type) {
            case 'sbp_accommodation':
            case 'sbp_travel_service':
            case 'flx_deals':
            case 'sbp_map_points':
              /*brute force grafeis edw to path*/
              $card_path = get_stylesheet_directory() . '/sbp_templates/partials/global/recent_card/recent_card.php';
              break;
            case 'flx_property':
              $card_path = get_stylesheet_directory() . '/sbp_templates/partials/global/property_card/property_card.php';
              break;
            case 'flx_business':
            case 'flx_restaurant':
              $card_path = get_stylesheet_directory() . '/sbp_templates/partials/global/business_card/business_card.php';
              break;
          }
          if (!empty($card_path)) {
            global $flx_product_id;
            foreach ($recently_viewed[$post_type] as $product_id) {
              $product_id = (int) icl_object_id($product_id, $post_type, true, $language);
              if ($product_id && $product_id != $exclude) {
                ob_start();
                $flx_product_id = $product_id;
                include $card_path;
                $content[$product_id] = ob_get_contents();
                ob_end_clean();
              }
            }
          }
        }
      }
    }
    return rest_ensure_response(new WP_REST_Response(implode('', $content)), 200);
  }



  /**
   * with these function we send the data to the site
   */
  public function awm_send_analytics($request)
  {
    if (!empty($request)) {
      //global $sbpSession;
      $params = $request->get_params();
      $id = absint($params['id']);
      if ($id) {
        // $recently_viewed = $sbpSession->get('recently_viewed') ?: array();
        $post_type = get_post_type($id);
        $views = get_post_meta($id, '_awm_wp_views', true) ?: 0;
        if (!isset($recently_viewed[$post_type]) || !in_array($id, $recently_viewed[$post_type])) {
          //$recently_viewed[$post_type][] = $id;
        }
        $views++;
        update_post_meta($id, '_awm_wp_views', $views);
        // $sbpSession->set('recently_viewed', $recently_viewed);
        return true;
      }
    }
    return false;
  }
}

add_action('rest_api_init', function () {
  $apiController = new AWM_WP_Analytics_API();
  $apiController->register_routes();
});
