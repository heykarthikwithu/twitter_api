<?php

namespace Drupal\twitter_api;

use Drupal\twitter_api\twitter_library\TwitterOAuth;

class StripeAPI{
  protected  $consumer_key	 = 'svE8J18C6m4eAp321ajcQ';
  protected  $consumer_secret	 = 'dweUUSn0QRKSiSTSh69N1toK2Lo3dzThnX4gJYbdA';
  protected  $oauth_callback	 = 'http://127.0.0.1/login-with-twitter-infotuts/callback.php';

  function __construct() {

    if(empty($_SESSION['status'])){
      $this->login_twitter();
    }
  }

  function login_twitter(){
    if ($this->consumer_key === '' || $this->consumer_secret === '') {
      echo 'You need a consumer key and secret to test the sample code. Get one from <a href="https://twitter.com/apps">https://twitter.com/apps</a>';
      // exit;
    }
    /* Build an image link to start the redirect process. */
    // echo $content = '<a href="/twitter-api/process"><img src="./images/lighter.png" alt="Sign in with Twitter"/></a>';

    // if(isset($_GET['connect']) && $_GET['connect']=='twitter'){

      $connection = new TwitterOAuth($this->consumer_key, $this->consumer_secret);// Key and Sec
      $request_token = $connection->getRequestToken($this->oauth_callback);// Retrieve Temporary credentials.

      $_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
      $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];


      switch ($connection->http_code) {
        case 200:    $url = $connection->getAuthorizeURL($token); // Redirect to authorize page.
          header('Location: ' . $url);
          break;
        default:
          echo 'Could not connect to Twitter. Refresh the page or try again later.';
      }
    //}
  }

  function twitter_callback(){
    $connection = new \TwitterOAuth($this->consumer_key, $this->consumer_secret, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
    $access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
    $_SESSION['access_token'] = $access_token;
    unset($_SESSION['oauth_token']);
    unset($_SESSION['oauth_token_secret']);

    if (200 == $connection->http_code) {
      echo $_SESSION['status'] = 'verified';
      header('Location: ./index.php?connected');
    } else {
      header('Location: ./destroy.php?2');
    }
  }


  function  view(){
    if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
      header('Location: ./destroy.php?3');
    }
    $access_token = $_SESSION['access_token'];

    $connection = new TwitterOAuth($this->consumer_key, $this->consumer_secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);

    /* If method is set change API call made. Test is called by default. */
    $content = $connection->get('account/verify_credentials');

//echo $content->name;echo $content->location;echo $content->followers_count;echo $content->friends_count;
//echo $content->friends_count;echo "<img src='{$content->profile_image_url}'/>";echo "<a href='./destroy.php'>LogOut</a>";
    ?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

      <title>Twitter Login</title>
      <link rel="stylesheet" href="style.css">
    </head>

    <body>

    <table cellspacing='0'> <!-- cellspacing='0' is important, must stay -->
      <!--<tr><th>Task Details</th><th>Progress</th><th>Vital Task</th></tr> Table Header -->
      <tr><th></th><th>Twitter Login Profile</th><th></tr><!-- Table Header -->
      <tr><td>Profile Pic</td><td></td><td><img src="<?php echo $content->profile_image_url; ?>"></td></tr><!-- Table Row -->
      <tr><td>Your Name</td><td></td><td><?php echo $content->name; ?></td></tr><!-- Table Row -->
      <tr class='even'><td>Followers Count</td><td></td><td><?php echo $content->followers_count; ?></td></tr><!-- Darker Table Row -->
      <tr><td>Friends</td><td></td><td><?php echo $content->friends_count; ?></td></tr>
      <tr class='even'><td>Location</td><td></td><td><?php echo $content->location; ?></td></tr>
      <tr class='even'><td></td><td><a href="./destroy.php">Logout</a></td><td></td></tr>
    </table>
    <center style="margin-right: 14%;"><h2><a href="http://infotuts.com/">InfoTuts</a></h2> </center>
    </body>
    </html>




  <?php

  }


}
