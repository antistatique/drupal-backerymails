<?php

namespace Drupal\backerymails\Entity;

use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;

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
 *
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
      ->setLabel(t('Entity ID'))
      ->setDescription(t('The entity ID for this menu link content entity.'))
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE);

    $fields['module'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Module'))
      ->setDescription(t('The module that send the mail.'));

    $fields['module_key'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Key'))
      ->setDescription(t('The key of the mail, concording to the module.'));

    $fields['mail_from'] = BaseFieldDefinition::create('string')
      ->setLabel(t('From'))
      ->setDescription(t('The sender of the mail.'));

    $fields['mail_to'] = BaseFieldDefinition::create('string')
      ->setLabel(t('To'))
      ->setDescription(t('The recipient(s) of the mail.'));

    $fields['mail_reply_to'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Reply-to'))
      ->setDescription(t('The reply-to(s) of the mail.'));

    $fields['langcode'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Langcode'))
      ->setSetting('max_length', 12)
      ->setDescription(t('The langcode of the mail.'));

    $fields['subject'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Subject'))
      ->setDescription(t('The subject of the mail.'));

    $fields['body'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Body'))
      ->setDescription(t('The body of the mail.'));

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    return $fields;
  }

}
