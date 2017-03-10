<?php

/**
 * @file
 * Legacy Drupal 7 code to implements hooks.
 */

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\backerymails\Entity\BackerymailsEntity;

/**
 * Hook Mail Alter.
 *
 * Implements hook_mail_alter().
 * Alter Drupal standard mail sender to trace the submission.
 */
function backerymails_mail_alter(&$message) {
  $config = \Drupal::config('backerymails.settings');

  // Check exclusion of this mail - to be saved.
  if ($config->get('excluded')['exclude_user_login_mails'] && $message['id'] == 'user_password_reset') {
    return;
  }

  $subject = $message['subject'];
  if ($subject instanceof TranslatableMarkup) {
    $subject = $subject->render();
  }

  $body = $message['body'];
  if ($body instanceof TranslatableMarkup) {
    $body = $body->render();
  }
  else {
    $body = json_encode($body);
  }

  // Check for rerouting mails
  if ($config->get('reroute')['status'] && !empty($config->get('reroute')['recipients'])) {
    $recipients = $config->get('reroute')['recipients'];
    $to = preg_replace('/\s+/', ' ', $recipients);
    $to = str_replace(';', ',', $to);
    $message['to'] = $to;
  }

  // Display the e-mail if the verbose is enabled.
  if ($config->get('verbose') && \Drupal::currentUser()->hasPermission('administer site configuration')) {
    // Print the message.
    $header_output = print_r($message['headers'], TRUE);
    $output = t('A mail has been sent: <br/> [Subject] => @subject <br/> [From] => @from <br/> [To] => @to <br/> [Reply-To] => @reply <br/> <pre>  [Header] => @header <br/> [Body] => @body </pre>', [
        '@subject' => $subject,
        '@from' => $message['from'],
        '@to' => $message['to'],
        '@reply' => isset($message['reply_to']) ? $message['reply_to'] : NULL,
        '@header' => $header_output,
        '@body' => $body
    ]);
    drupal_set_message($output, 'status', TRUE);
  }

  $data = array(
    'module'        => $message['module'],
    'module_key'    => $message['key'],
    'mail_from'     => $message['from'],
    'mail_to'       => $message['to'],
    'mail_reply_to' => isset($message['reply-to']) ? $message['reply-to'] : NULL,
    'langcode'      => isset($message['langcode']) ? $message['langcode'] : NULL,
    'subject'       => $subject,
    'body'          => $body,
  );

  $backerymail = BackerymailsEntity::create($data);
  $backerymail->save();
}
