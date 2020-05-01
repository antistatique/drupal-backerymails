<?php

namespace Drupal\backerymails\Entity;

use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Defines the Backerymails entity entity.
 *
 * @ingroup backerymails
 *
 * @ContentEntityType(
 *   id = "backerymails_entity",
 *   label = @Translation("Backerymails entity"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "views_data" = "Drupal\backerymails\Entity\BackerymailsViewsData",
 *     "form" = {
 *       "default" = "Drupal\Core\Entity\ContentEntityForm",
 *     },
 *     "access" = "Drupal\backerymails\BackerymailsEntityAccessControlHandler",
 *   },
 *   base_table = "backerymails_sended_mail",
 *   admin_permission = "administer backerymails",
 *   entity_keys = {
 *     "id" = "id",
 *   },
 *   links = {
 *     "canonical" = "/admin/config/backerymails/mails/{backerymails_entity}",
 *     "collection" = "/admin/config/backerymails/mails",
 *   },
 *   field_ui_base_route = "backerymails.settings"
 * )
 */
class BackerymailsEntity extends ContentEntityBase implements BackerymailsEntityInterface {
  use EntityChangedTrait;

  /**
   * Get the Created date.
   *
   * @return \DateTime|null
   *   The created date
   */
  public function getCreatedDate() {
    $timestamp = $this->get('created')->value;

    if (!$timestamp) {
      return NULL;
    }

    $datetime = \DateTime::createFromFormat('U', $timestamp);

    return $datetime;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * Get the module.
   */
  public function getModule() {
    return $this->get('module')->value;
  }

  /**
   * Get the module key.
   */
  public function getModuleKey() {
    return $this->get('module_key')->value;
  }

  /**
   * Get the email address to which bounce messages are delivered.
   */
  public function getFrom() {
    return $this->get('mail_from')->value;
  }

  /**
   * Get the recipient(s) of the e-mail.
   */
  public function getTo() {
    return $this->get('mail_to')->value;
  }

  /**
   * Get the reply-to of the e-mail.
   */
  public function getReplyto() {
    return $this->get('mail_reply_to')->value;
  }

  /**
   * Get the language.
   */
  public function getLangcode() {
    return $this->get('langcode')->value;
  }

  /**
   * Get the subject.
   */
  public function getSubject() {
    return $this->get('subject')->value;
  }

  /**
   * Get the body.
   */
  public function getBody() {
    return $this->get('body')->value;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(new TranslatableMarkup('Entity ID'))
      ->setDescription(new TranslatableMarkup('The entity ID for this menu link content entity.'))
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE);

    $fields['module'] = BaseFieldDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Module'))
      ->setDescription(new TranslatableMarkup('The module that send the mail.'));

    $fields['module_key'] = BaseFieldDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Key'))
      ->setDescription(new TranslatableMarkup('The key of the mail, concording to the module.'));

    $fields['mail_from'] = BaseFieldDefinition::create('string')
      ->setLabel(new TranslatableMarkup('From'))
      ->setDescription(new TranslatableMarkup('The sender of the mail.'));

    $fields['mail_to'] = BaseFieldDefinition::create('string')
      ->setLabel(new TranslatableMarkup('To'))
      ->setDescription(new TranslatableMarkup('The recipient(s) of the mail.'));

    $fields['mail_reply_to'] = BaseFieldDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Reply-to'))
      ->setDescription(new TranslatableMarkup('The reply-to(s) of the mail.'));

    $fields['langcode'] = BaseFieldDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Langcode'))
      ->setSetting('max_length', 12)
      ->setDescription(new TranslatableMarkup('The langcode of the mail.'));

    $fields['subject'] = BaseFieldDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Subject'))
      ->setDescription(new TranslatableMarkup('The subject of the mail.'));

    $fields['body'] = BaseFieldDefinition::create('text_long')
      ->setLabel(new TranslatableMarkup('Body'))
      ->setDescription(new TranslatableMarkup('The body of the mail.'));

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(new TranslatableMarkup('Created'))
      ->setDescription(new TranslatableMarkup('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
    ->setLabel(new TranslatableMarkup('Changed'))
    ->setDescription(new TranslatableMarkup('Changed'));

    return $fields;
  }

}
