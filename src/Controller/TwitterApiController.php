<?php

/**
 * @file
 * Contains \Drupal\twitter_api\Controller\TwitterApiController.
 */

namespace Drupal\twitter_api\Controller;

use Drupal\Core\Controller\ControllerBase;

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

//    global $twitter_obj;
//
//    if(isset($_REQUEST['connected']) && isset($_SESSION['status'])) {
//      $twitter_obj = New StripeAPI();
//      $twitter_obj->view();
//    }
//    else{
//      $twitter_obj = New StripeAPI();
//    }

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
