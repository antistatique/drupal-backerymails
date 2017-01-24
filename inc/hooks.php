<?php

use Drupal\backerymails\Entity\BackerymailsEntity;

function backerymails_mail_alter(&$message) {

    // Check exclusion of this mail - to be saved
    $config = \Drupal::config('backerymails.settings');
    if ($config->get('excluded')['exclude_user_login_mails'] && $message['id'] == 'user_password_reset') {
        return;
    }

    $subject = $message['subject'];
    if ($subject instanceof Drupal\Core\StringTranslation\TranslatableMarkup) {
        $subject = $subject->render();
    }

    $body = $message['body'];
    if ($body instanceof Drupal\Core\StringTranslation\TranslatableMarkup) {
        $body = $body->render();
    } else {
        $body = json_encode($body);
    }

    $data = array(
        'module'        => $message['module'],
        'module_key'    => $message['key'],
        'mail_from'     => $message['from'],
        'mail_to'       => $message['to'],
        'mail_reply_to' => isset($message['reply-to']) ? $message['reply-to'] : null,
        'langcode'      => isset($message['langcode']) ? $message['langcode'] : null,
        'subject'       => $subject,
        'body'          => $body,
    );

    $backerymail = BackerymailsEntity::create($data);
    $backerymail->save();
}
