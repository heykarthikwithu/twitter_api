<?php

/**
 * @file
 * Contains \Drupal\twitter_api\Controller\TwitterApiController.
 */

namespace Drupal\twitter_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\twitter_api;

/**
 * Class TwitterApiController.
 *
 * @package Drupal\twitter_api\Controller
 */
class TwitterApiController extends ControllerBase {

  /**
   * Login Process.
   *
   * @return string
   *   Return Hello string.
   */
  public function process() {

    //$path = drupal_get_path('module', 'twitter_api');
    //require_once($path . 'twitter_library/twitteroauth.php');
    $a = module_load_include('php', 'twitter_api', 'twitter_library/twitteroauth.php');

    global $twitter_obj;

    if(isset($_REQUEST['connected']) && isset($_SESSION['status'])) {
      $twitter_obj = New twitter_api\StripeAPI();
      $twitter_obj->view();
    }
    else{
      $twitter_obj = New twitter_api\StripeAPI();
    }

    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement process method..!')
    ];
  }

  /**
   * Logout Process.
   *
   * @return string
   *   Return Hello string.
   */
  public function logoutProcess() {

    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement process method..!')
    ];
  }

}
