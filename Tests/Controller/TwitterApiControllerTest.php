<?php

/**
 * @file
 * Contains \Drupal\twitter_api\Tests\TwitterApiController.
 */

namespace Drupal\twitter_api\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the twitter_api module.
 */
class TwitterApiControllerTest extends WebTestBase {
  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return array(
      'name' => "twitter_api TwitterApiController's controller functionality",
      'description' => 'Test Unit for module twitter_api and controller TwitterApiController.',
      'group' => 'Other',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
  }

  /**
   * Tests twitter_api functionality.
   */
  public function testTwitterApiController() {
    // Check that the basic functions of module twitter_api.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via App Console.');
  }

}
