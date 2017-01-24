<?php

namespace Drupal\backerymails\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
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
*     "canonical" = "/admin/config/backerymails/mails/{sended_mail_entity}",
*     "collection" = "/admin/config/backerymails/mails",
*   },
*   field_ui_base_route = "backerymails.settings"
* )
*/
class BackerymailsEntity extends ContentEntityBase implements BackerymailsEntityInterface {

    use EntityChangedTrait;

    /**
    * {@inheritdoc}
    */
    public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
        parent::preCreate($storage_controller, $values);
    }

    /**
     * @return \DateTime|null
     */
    public function getCreatedDate() {
        $timestamp = $this->get('created')->value;

        if (!$timestamp) {
        return null;
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

    public function getModule() {
        return $this->get('module')->value;
    }

    public function getModuleKey() {
        return $this->get('module_key')->value;
    }

    public function getFrom() {
        return $this->get('mail_from')->value;
    }

    public function getTo() {
        return $this->get('mail_to')->value;
    }

    public function getReplyto() {
        return $this->get('mail_reply_to')->value;
    }

    public function getLangcode() {
        return $this->get('langcode')->value;
    }

    public function getSubject() {
        return $this->get('subject')->value;
    }

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
            ->setSetting('unsigned', TRUE)
        ;

        $fields['module'] = BaseFieldDefinition::create('string')
            ->setLabel(t('Module'))
            ->setDescription(t('The module that send the mail.'))
        ;

        $fields['module_key'] = BaseFieldDefinition::create('string')
            ->setLabel(t('Key'))
            ->setDescription(t('The key of the mail, concording to the module.'))
        ;

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
