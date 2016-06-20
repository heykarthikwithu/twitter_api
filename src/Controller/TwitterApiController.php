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

    $aa = '';

    if(isset($_REQUEST['oauth_token']) && $_SESSION['token']  !== $_REQUEST['oauth_token']) {

      //If token is old, distroy session and redirect user to index.php
      session_destroy();
      header('Location: index.php');

    }elseif(isset($_REQUEST['oauth_token']) && $_SESSION['token'] == $_REQUEST['oauth_token']) {

      //Successful response returns oauth_token, oauth_token_secret, user_id, and screen_name
      $config = $this->config('twitter_api.config');
      $connection = new TwitterApiOAuth($config->get('consumer_key'), $config->get('consumer_secret'), $_SESSION['token'] , $_SESSION['token_secret']);
      $access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
      if($connection->http_code == '200')
      {
        //Redirect user to twitter
        $_SESSION['status'] = 'verified';
        $_SESSION['request_vars'] = $access_token;

        //Insert user into the database
        $user_info = $connection->get('account/verify_credentials');
        $name = explode(" ",$user_info->name);
        $fname = isset($name[0])?$name[0]:'';
        $lname = isset($name[1])?$name[1]:'';
        $db_user = new TwitterUsers();
        $db_user->checkUser('twitter',$user_info->id,$user_info->screen_name,$fname,$lname,$user_info->lang,$access_token['oauth_token'],$access_token['oauth_token_secret'],$user_info->profile_image_url);

        //Unset no longer needed request tokens
        unset($_SESSION['token']);
        unset($_SESSION['token_secret']);
        header('Location: index.php');
      }else{
        die("error, try again later!");
      }

    }else{

      if(isset($_GET["denied"]))
      {
        header('Location: index.php');
        die();
      }

      //Fresh authentication
      $config = $this->config('twitter_api.config');
      $connection = new TwitterApiOAuth($config->get('consumer_key'), $config->get('consumer_secret'));
      $oauth_callback = (!empty($_SERVER['HTTPS'])) ?
        "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] :
        "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
      // $request_token = $connection->getRequestToken('/twitter-api/process');
      $request_token = $connection->getRequestToken($oauth_callback);

      //Received token info from twitter
      $_SESSION['token'] 			= $request_token['oauth_token'];
      $_SESSION['token_secret'] 	= $request_token['oauth_token_secret'];

      //Any value other than 200 is failure, so continue only if http code is 200
      if($connection->http_code == '200')
      {
        //redirect user to twitter
        $twitter_url = $connection->getAuthorizeURL($request_token['oauth_token']);
        header('Location: ' . $twitter_url);
      }else{
        die("error connecting to twitter! try again later!");
      }
    }


    /*return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement process method..!')
    ];*/
  }

  public function logoutProcess() {
    if(array_key_exists('logout',$_GET))
    {
      session_start();
      unset($_SESSION['userdata']);
      session_destroy();
      header("Location:index.php");
    }
  }

}
