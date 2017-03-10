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

    $form['settings']['verbose'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t("Display the e-mails on page."),
      '#default_value' => $config->get('verbose'),
      '#description' => $this->t('If enabled, anonymous users with permissions will see any verbose output mail.'),
    );

    $form['reroute'] = array(
      '#type' => 'fieldset',
      '#title' => $this->t('Rerouting'),
    );

    $form['reroute']['status'] = array(
        '#type'          => 'checkbox',
        '#title'         => $this->t('Enable rerouting'),
        '#default_value' => $config->get('reroute')['status'],
        '#description'   => $this->t('Check this box if you want to enable email rerouting. Uncheck to disable rerouting.'),
      );

      $form['reroute']['recipients'] = array(
        '#type'          => 'textfield',
        '#title'         => $this->t('Recipient(s)'),
        '#default_value' => $config->get('reroute')['recipients'],
        '#description'   => $this->t('Use ";" (semicolon) as email delimiter when sending to multiple recipients.'),
      );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
        $mails = explode(';', $form_state->getValue('reroute')['recipients']);
        $mails = array_map('trim', $mails);
        foreach ($mails as $mail) {
          if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $form_state->setErrorByName('reroute', $this->t("@email isn't a valid address.", array('@email' => $mail)));
          }
        }
    }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('backerymails.settings');

    // Save it as array for futur-proof.
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

    if ($form_state->hasValue('reroute')) {
        $reroute = array(
            'status'     => $form_state->getValue('reroute')['status'],
            'recipients' => $form_state->getValue('reroute')['recipients'],
        );

        $config->set('reroute', $reroute);
        $config->save();

        if ($form_state->getValue('reroute')['status']) {
          drupal_set_message($this->t('Drupal has been configured to reroute all outgoing e-mails.'), 'status');
        }
    }

    if ($form_state->hasValue('settings')) {
        $config->set('verbose', $form_state->getValue('settings')['verbose']);
        $config->save();

        if ($form_state->getValue('settings')['verbose']) {
          drupal_set_message($this->t('Drupal has been configured to display all outgoing e-mails.'), 'status');
        }
    }
  }

}
