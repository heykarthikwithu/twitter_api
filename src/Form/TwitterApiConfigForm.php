<?php

/**
 * @file
 * Contains Drupal\twitter_api\Form\TwitterApiConfigForm.
 */

namespace Drupal\twitter_api\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class TwitterApiConfigForm.
 *
 * @package Drupal\twitter_api\Form
 */
class TwitterApiConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'twitter_api.config',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'twitter_api_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('twitter_api.config');
    $form['consumer_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Consumer Key'),
      '#description' => $this->t('Enter the consumer key, generated from twitter app.'),
      '#size' => 64,
      '#default_value' => $config->get('consumer_key'),
    ];
    $form['consumer_secret'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Consumer Secret'),
      '#description' => $this->t('Enter the consumer secrect key, generated from the twitter api.'),
      '#size' => 64,
      '#default_value' => $config->get('consumer_secret'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('twitter_api.config')
      ->set('consumer_key', $form_state->getValue('consumer_key'))
      ->set('consumer_secret', $form_state->getValue('consumer_secret'))
      ->save();
  }

}
