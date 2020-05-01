<?php

/**
 * @file
 * Post update functions for Backerymails module.
 */

use Drupal\Core\Database\Database;

/**
 * Migrate data from the old existing Backerymails table to the new one.
 */
function backerymails_post_update_migrate_data(&$sandbox = NULL) {
  $database = Database::getConnection();

  if ($database->schema()->tableExists('backerymails_sended_mail') && $database->schema()->tableExists('backerymails_sent_mails')) {
    $query  = $database->select('backerymails_sended_mail', 'sent_mails')
      ->fields('sent_mails');
    $tuples = $query->execute()->fetchAll();
    foreach ($tuples as $tulpe) {
      $database->insert('backerymails_sent_mails')
        ->fields([
          'module' => $tulpe->module,
          'module_key' => $tulpe->module_key,
          'mail_from' => $tulpe->mail_from,
          'mail_to' => $tulpe->mail_to,
          'mail_reply_to' => $tulpe->mail_reply_to,
          'langcode' => $tulpe->langcode,
          'subject' => $tulpe->subject,
          'body__value' => $tulpe->body__value,
          'body__format' => $tulpe->body__format,
          'created' => $tulpe->created,
        ])
        ->execute();
    }
  }

  $database->schema()->dropTable('backerymails_sended_mail');
}
