<?php

/**
 * @file
 * Contains \Drupal\twitter_api\Plugin\Block\TwitterApiLoginButton.
 */

namespace Drupal\twitter_api\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;

/**
 * Provides a 'TwitterApiLoginButton' block.
 *
 * @Block(
 *  id = "twitter_api_login_button",
 *  admin_label = @Translation("Twitter api login button"),
 * )
 */
class TwitterApiLoginButton extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];

    if(isset($_SESSION['status']) && $_SESSION['status'] == 'verified') {
      $build['twitter_api_logout_link'] = [
        '#title' => $this->t('Logout with Twitter'),
        '#type' => 'link',
        '#url' => Url::fromRoute('twitter_api.logout_process')
      ];
    }
    else {
      $build['twitter_api_login_link'] = [
        '#title' => $this->t('Login with Twitter'),
        '#type' => 'link',
        '#url' => Url::fromRoute('twitter_api.process')
      ];
    }

    return $build;
  }

}
