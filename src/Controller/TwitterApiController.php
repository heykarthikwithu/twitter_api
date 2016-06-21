<?php

/**
 * @file
 * Contains \Drupal\twitter_api\Controller\TwitterApiController.
 */

namespace Drupal\twitter_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\twitter_api\Twitter\TwitterUsers;
use Drupal\twitter_api\TwitterApiOAuth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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

    if ($hybridauth = hybridauth_get_instance()) {
      return $this->_hybridauth_window_auth($hybridauth, 'Twitter');
    }

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

  public function endpoint() {
    /*return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement process method..!')
    ];*/
    //return MENU_ACCESS_DENIED;
    return new AccessDeniedHttpException();
  }

  public function _hybridauth_window_auth(\Hybrid_Auth $hybridauth, $provider_id) {
    $params = array(
      'hauth_return_to' => 'http://127.0.0.1/d82/twitter-api/process',
    );

    /*$provider = new \Hybrid_Provider_Adapter();
    $provider->factory($provider_id, $params);*/
    //$aa = \Hybrid_Auth::getAdapter($provider_id);
    // return $aa;

    $adapter = $hybridauth->authenticate($provider_id, $params);
    $profile = (array) ($adapter->getUserProfile());
    $a = '';
  }

}
