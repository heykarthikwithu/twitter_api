<?php

/**
 * @file
 * Contains \Drupal\twitter_api\Controller\TwitterApiController.
 */

namespace Drupal\twitter_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\twitter_api\Twitter\TwitterUsers;
use Drupal\twitter_api\TwitterApiOAuth;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
    /*session_destroy();
    session_start();*/

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
    if ($lib_path = _hybridauth_library_path()) {
      try {
        // If Composer install was executed in the Hybridauth library use that
        // autoloader.
        if (file_exists($lib_path . '/../vendor/autoload.php')) {
          require_once $lib_path . '/../vendor/autoload.php';
        }
        require_once $lib_path . '/index.php';
      }

      catch (\Exception $e) {
        watchdog_exception('hybridauth', $e);
      }
    }
    return new AccessDeniedHttpException();
  }

  public function _hybridauth_window_auth(\Hybrid_Auth $hybridauth, $provider_id) {
    $params = [];
    /*$params = array(
      'hauth_return_to' => 'http://127.0.0.1/d81/twitter-api/process',
    );*/

    /*$provider = new \Hybrid_Provider_Adapter();
    $provider->factory($provider_id, $params);*/
    //$aa = \Hybrid_Auth::getAdapter($provider_id);
    // return $aa;

    if (is_object($hybridauth)) {
      try {
        $adapter = $hybridauth->authenticate($provider_id, $params);
        $aa = '';
        $profile = (array) ($adapter->getUserProfile());
        $a = '';
      }
      catch(\Exception $e) {
        watchdog_exception('hybridauth', $e);
      }
    }

    return $this->_hybridauth_window_process_auth($profile);
  }

  /**
   * Handle the Drupal authentication.
   */
  function _hybridauth_window_process_auth($data) {
    $uid = \Drupal::currentUser()->id();
    $url = 'http://127.0.0.1/d81/user/' . $uid . '/hybridauth';
    return (new RedirectResponse($url))->send();
  }

}
