<?php

/**
 * @file
 * Contains \Drupal\twitter_api\Controller\TwitterApiController.
 */

namespace Drupal\twitter_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\twitter_api\Twitter\TwitterUsers;
use Drupal\twitter_api\TwitterApiOAuth;

/**
 * Class TwitterApiController.
 *
 * @package Drupal\twitter_api\Controller
 */
class TwitterApiController extends ControllerBase {
  /**
   * Process.
   *
   * @return string
   *   Return Hello string.
   */
  public function process() {

    // Initialize session data.
    //session_start();

    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement process method..!')
    ];
  }

  public function logoutProcess() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement process method..!')
    ];
  }

}
