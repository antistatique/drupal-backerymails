<?php

namespace Drupal\backerymails\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Backery Mails settings form.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'backerymails_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'backerymails.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);
    $config = $this->config('backerymails.settings');

    // Submitted form values should be nested.
    $form['#tree'] = TRUE;

    // Display a page description.
    $form['description'] = array(
      '#markup' => '<p>' . $this->t('This page allows you to configure settings which determines how e-mail messages are saved.') . '</p>',
    );

    $form['settings'] = array(
      '#type' => 'fieldset',
      '#title' => $this->t('General'),
    );

    $form['settings']['exclude_user_login_mails'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Exclude sensitives e-mails.'),
      '#default_value' => $config->get('excluded')['exclude_user_login_mails'],
      '#description' => $this->t('Drupal send sensitives e-mails to user account such "forgotten password". Enabling this setting will result in excluding all sensitives e-mails to be saved.'),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('backerymails.settings');

    // Save it as array for evolutivity.
    $excluded = $config->get('excluded', array());

    if ($form_state->hasValue('settings', 'exclude_user_login_mails')) {
      $excluded['exclude_user_login_mails'] = $form_state->getValue('settings', 'exclude_user_login_mails')['exclude_user_login_mails'];
      $config->set('excluded', $excluded);
      $config->save();

      if ($excluded['exclude_user_login_mails']) {
        drupal_set_message($this->t('Drupal has been configured to exclude all user sensitives e-mails.'), 'status');
      }
      else {
        drupal_set_message($this->t('Drupal has been configured to save all e-mails, even sensitives ones.'), 'warning');
      }
    }
  }

}
