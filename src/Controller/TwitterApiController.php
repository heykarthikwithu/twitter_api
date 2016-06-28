<?php

/**
 * @file
 * Contains \Drupal\twitter_api\Controller\TwitterApiController.
 */

namespace Drupal\twitter_api\Controller;

use Drupal\Core\Controller\ControllerBase;
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

    if ($hybridauth = hybridauth_get_instance()) {
      return $this->_hybridauth_window_auth($hybridauth, 'Twitter');
    }
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
    $profile = [];

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
    if (empty($data)) {
      return (new RedirectResponse('/'))->send();
    }
    $uid = \Drupal::currentUser()->id();
    $url = 'http://127.0.0.1/d81/user/' . $uid . '/hybridauth';
    return (new RedirectResponse($url))->send();
  }

}
