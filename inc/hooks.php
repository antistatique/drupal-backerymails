<?php

/**
 * @file
 * Legacy Drupal 7 code to implements hooks.
 */

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\backerymails\Entity\BackerymailsEntity;

/**
 * Alter Drupal standard mail sender to trace the submission(s).
 *
 * Implements hook_mail_alter().
 *
 * @SuppressWarnings(PHPMD.DevelopmentCodeFragment)
 */
function backerymails_mail_alter(&$message) {
  $config = \Drupal::config('backerymails.settings');

  // Check for rerouting mails.
  if ($config->get('reroute')['status'] && !empty($config->get('reroute')['recipients'])) {
    $recipients = $config->get('reroute')['recipients'];
    $to = preg_replace('/\s+/', ' ', $recipients);
    $to = str_replace(';', ',', $to);

    // Save the original recipients and store it into a custom header.
    if (isset($message['to'])) {
      $message['headers']['X-Backerymails-To'] = $message['to'];
    }

    $message['to'] = $to;

    // Save the original cc and store it into a custom header.
    if (isset($message['headers']['Cc'])) {
      $message['headers']['X-Backerymails-Cc'] = $message['headers']['Cc'];
      $message['headers']['Cc'] = $to;
    }

    // Save the original bcc and store it into a custom header.
    if (isset($message['headers']['Bcc'])) {
      $message['headers']['X-Backerymails-Bcc'] = $message['headers']['Bcc'];
      $message['headers']['Bcc'] = $to;
    }
  }

  $excludes = [];
  // Get exclusion of sensitives mail(s) - to be skiped.
  $excludes += $config->get('excludes')['sensitives'];
  // Get exclusion of customs mail(s) - to be skiped.
  $excludes = array_merge($excludes, $config->get('excludes')['customs']);
  // Skip the saving for sensitives mail(s) but still sent them.
  if (in_array($message['module'] . '.' . $message['key'], $excludes, TRUE)) {
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

  // Display the e-mail if the verbose is enabled.
  if ($config->get('verbose') && \Drupal::currentUser()->hasPermission('administer site configuration')) {
    // Print the message.
    $header_output = print_r($message['headers'], TRUE);
    $output = t('A mail has been sent: <br/> [Subject] => @subject <br/> [From] => @from <br/> [To] => @to <br/> [Reply-To] => @reply <br/> <pre>  [Header] => @header <br/> [Body] => @body </pre>', [
      '@subject' => $subject,
      '@from'    => $message['from'],
      '@to'      => $message['to'],
      '@reply'   => $message['reply_to'] ?? NULL,
      '@header'  => $header_output,
      '@body'    => $body,
    ]);
    $messenger = \Drupal::messenger();
    $messenger->addMessage($output, 'status', TRUE);
  }

  $data = [
    'module'        => $message['module'],
    'module_key'    => $message['key'],
    'mail_from'     => $message['from'],
    'mail_to'       => $message['to'],
    'mail_reply_to' => $message['reply-to'] ?? NULL,
    'langcode'      => $message['langcode'] ?? NULL,
    'subject'       => $subject,
    'body'          => $body,
  ];

  $backerymail = BackerymailsEntity::create($data);
  $backerymail->save();
}
