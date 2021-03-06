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
      /*$screen_name 		= $_SESSION['request_vars']['screen_name'];
      $twitter_id			= $_SESSION['request_vars']['user_id'];
      $oauth_token 		= $_SESSION['request_vars']['oauth_token'];
      $oauth_token_secret = $_SESSION['request_vars']['oauth_token_secret'];*/
      //echo '<div class="welcome_txt">Welcome <strong>'.$screen_name.'</strong> (Twitter ID : '.$twitter_id.'). <a href="logout.php?logout">Logout</a>!</div>';
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
