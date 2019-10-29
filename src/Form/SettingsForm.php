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
    $form['description'] = [
      '#markup' => '<p>' . $this->t('This page allows you to configure settings which determines how e-mail messages are saved.') . '</p>',
    ];

    $form['settings'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('General'),
    ];

    $form['settings']['verbose'] = [
      '#type' => 'checkbox',
      '#title' => $this->t("Display the e-mails on page."),
      '#default_value' => $config->get('verbose'),
      '#description' => $this->t('If enabled, anonymous users with permissions will see any verbose output mail.'),
    ];

    $form['excludes'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Exclude(s)'),
    ];

    $form['excludes']['sensitives'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Exclude sensitives e-mails.'),
      '#default_value' => !empty($config->get('excludes')['sensitives']),
      '#description' => $this->t('Drupal send sensitives e-mails to user account such "forgotten password". Enabling this setting will result in excluding all sensitives e-mails to be saved.'),
    ];

    $form['excludes']['customs'] = [
      '#type'          => 'textarea',
      '#title'         => $this->t('Exclude(s)'),
      '#default_value' => implode("\r\n", $config->get('excludes')['customs']),
      '#description'   => $this->t('Specify customs "module.key" to exclude. Enter one "module.key" per line. An example is "update.status_notify" for every update core mails.'),
      '#placeholder'   => 'update.status_notify',
    ];

    $form['reroute'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Rerouting'),
      '#description' => $this->t('When enabled, the choosen recipient(s) will override original recipient(s).'),
    ];

    $form['reroute']['status'] = [
      '#type'          => 'checkbox',
      '#title'         => $this->t('Enable rerouting'),
      '#default_value' => $config->get('reroute')['status'],
      '#description'   => $this->t('Check this box if you want to enable email rerouting. Uncheck to disable rerouting.'),
    ];

    $form['reroute']['recipients'] = [
      '#type'          => 'textfield',
      '#title'         => $this->t('Recipient(s)'),
      '#default_value' => $config->get('reroute')['recipients'],
      '#description'   => $this->t('Use ";" (semicolon) as email delimiter when sending to multiple recipients.'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (!empty($form_state->getValue('reroute')['recipients'])) {
      $mails = explode(';', $form_state->getValue('reroute')['recipients']);
      $mails = array_map('trim', $mails);
      foreach ($mails as $mail) {
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
          $form_state->setErrorByName('reroute', $this->t("@email isn't a valid address.", ['@email' => $mail]));
        }
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('backerymails.settings');

    if ($form_state->hasValue('excludes')) {
      $excludes = ['customs' => [], 'sensitives' => []];
      if (!empty($form_state->getValue('excludes')['customs'])) {
        $excludes['customs'] = preg_split('/[\r\n]+/', $form_state->getValue('excludes')['customs'], 0, PREG_SPLIT_NO_EMPTY);
      }
      if ($form_state->getValue('excludes')['sensitives']) {
        $excludes['sensitives'][] = 'user.password_reset';
      }
      $config->set('excludes', $excludes);
      $config->save();

      if (!empty($excludes['sensitives'])) {
        $this->messenger()->addMessage($this->t('Drupal has been configured to exclude all user sensitives e-mails.'), 'status');
      }
      else {
        $this->messenger()->addMessage($this->t('Drupal has been configured to save all e-mails, even sensitives ones.'), 'warning');
      }
    }

    if ($form_state->hasValue('reroute')) {
      $reroute = [
        'status'     => (bool) $form_state->getValue('reroute')['status'],
        'recipients' => $form_state->getValue('reroute')['recipients'],
      ];

      $config->set('reroute', $reroute);
      $config->save();

      if ($form_state->getValue('reroute')['status']) {
        $this->messenger()->addMessage($this->t('Drupal has been configured to reroute all outgoing e-mails.'), 'warning');
      }
    }

    if ($form_state->hasValue('settings')) {
      $config->set('verbose', (bool) $form_state->getValue('settings')['verbose']);
      $config->save();

      if ($form_state->getValue('settings')['verbose']) {
        $this->messenger()->addMessage($this->t('Drupal has been configured to display all outgoing e-mails.'), 'warning');
      }
    }
  }

}
