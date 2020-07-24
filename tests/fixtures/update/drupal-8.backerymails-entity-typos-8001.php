<?php

// @codingStandardsIgnoreFile

/**
 * @file
 * Contains database additions to drupal-8.8.0.bare.standard.php.gz for testing
 * the upgrade paths of Backerymails module.
 *
 * This will install a badly named entity table backerymails_sended_mail.
 */

use Drupal\Core\Database\Database;

$connection = Database::getConnection();

// Insert Backerymails Entity key_value entries.
$connection->insert('key_value')
->fields(array(
  'collection',
  'name',
  'value',
))
->values(array(
  'collection' => 'entity.definitions.installed',
  'name' => 'backerymails_entity.entity_type',
  'value' => 'O:36:"Drupal\Core\Entity\ContentEntityType":38:{s:25:" * revision_metadata_keys";a:0:{}s:15:" * static_cache";b:1;s:15:" * render_cache";b:1;s:19:" * persistent_cache";b:1;s:14:" * entity_keys";a:6:{s:2:"id";s:2:"id";s:8:"revision";s:0:"";s:6:"bundle";s:0:"";s:8:"langcode";s:0:"";s:16:"default_langcode";s:16:"default_langcode";s:29:"revision_translation_affected";s:29:"revision_translation_affected";}s:5:" * id";s:19:"backerymails_entity";s:16:" * originalClass";s:45:"Drupal\backerymails\Entity\BackerymailsEntity";s:11:" * handlers";a:5:{s:12:"view_builder";s:36:"Drupal\Core\Entity\EntityViewBuilder";s:10:"views_data";s:48:"Drupal\backerymails\Entity\BackerymailsViewsData";s:4:"form";a:1:{s:7:"default";s:36:"Drupal\Core\Entity\ContentEntityForm";}s:6:"access";s:58:"Drupal\backerymails\BackerymailsEntityAccessControlHandler";s:7:"storage";s:46:"Drupal\Core\Entity\Sql\SqlContentEntityStorage";}s:19:" * admin_permission";s:23:"administer backerymails";s:25:" * permission_granularity";s:11:"entity_type";s:8:" * links";a:3:{s:9:"canonical";s:53:"/admin/config/backerymails/mails/{sended_mail_entity}";s:10:"collection";s:32:"/admin/config/backerymails/mails";s:7:"display";s:68:"/admin/config/backerymails/mails/{sended_mail_entity}/manage-display";}s:17:" * label_callback";N;s:21:" * bundle_entity_type";N;s:12:" * bundle_of";N;s:15:" * bundle_label";N;s:13:" * base_table";s:24:"backerymails_sended_mail";s:22:" * revision_data_table";N;s:17:" * revision_table";N;s:13:" * data_table";N;s:15:" * translatable";b:0;s:19:" * show_revision_ui";b:0;s:8:" * label";O:48:"Drupal\Core\StringTranslation\TranslatableMarkup":3:{s:9:" * string";s:19:"Backerymails entity";s:12:" * arguments";a:0:{}s:10:" * options";a:0:{}}s:19:" * label_collection";s:0:"";s:17:" * label_singular";s:0:"";s:15:" * label_plural";s:0:"";s:14:" * label_count";a:0:{}s:15:" * uri_callback";N;s:8:" * group";s:7:"content";s:14:" * group_label";O:48:"Drupal\Core\StringTranslation\TranslatableMarkup":3:{s:9:" * string";s:7:"Content";s:12:" * arguments";a:0:{}s:10:" * options";a:1:{s:7:"context";s:17:"Entity type group";}}s:22:" * field_ui_base_route";s:21:"backerymails.settings";s:26:" * common_reference_target";b:0;s:22:" * list_cache_contexts";a:0:{}s:18:" * list_cache_tags";a:1:{i:0;s:24:"backerymails_entity_list";}s:14:" * constraints";a:1:{s:13:"EntityChanged";N;}s:13:" * additional";a:1:{s:10:"token_type";s:19:"backerymails_entity";}s:8:" * class";s:45:"Drupal\backerymails\Entity\BackerymailsEntity";s:11:" * provider";s:12:"backerymails";s:20:" * stringTranslation";N;}',
))
->values(array(
  'collection' => 'entity.definitions.installed',
  'name' => 'backerymails_entity.field_storage_definitions',
  'value' => "a:10:{s:2:\"id\";O:37:\"Drupal\Core\Field\BaseFieldDefinition\":5:{s:7:\" * type\";s:7:\"integer\";s:9:\" * schema\";a:4:{s:7:\"columns\";a:1:{s:5:\"value\";a:3:{s:4:\"type\";s:3:\"int\";s:8:\"unsigned\";b:1;s:4:\"size\";s:6:\"normal\";}}s:11:\"unique keys\";a:0:{}s:7:\"indexes\";a:0:{}s:12:\"foreign keys\";a:0:{}}s:10:\" * indexes\";a:0:{}s:17:\" * itemDefinition\";O:51:\"Drupal\Core\Field\TypedData\FieldItemDataDefinition\":2:{s:18:\" * fieldDefinition\";r:2;s:13:\" * definition\";a:2:{s:4:\"type\";s:18:\"field_item:integer\";s:8:\"settings\";a:6:{s:8:\"unsigned\";b:1;s:4:\"size\";s:6:\"normal\";s:3:\"min\";s:0:\"\";s:3:\"max\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:6:\"suffix\";s:0:\"\";}}}s:13:\" * definition\";a:7:{s:5:\"label\";O:48:\"Drupal\Core\StringTranslation\TranslatableMarkup\":3:{s:9:\" * string\";s:9:\"Entity ID\";s:12:\" * arguments\";a:0:{}s:10:\" * options\";a:0:{}}s:11:\"description\";O:48:\"Drupal\Core\StringTranslation\TranslatableMarkup\":3:{s:9:\" * string\";s:48:\"The entity ID for this menu link content entity.\";s:12:\" * arguments\";a:0:{}s:10:\" * options\";a:0:{}}s:9:\"read-only\";b:1;s:8:\"provider\";s:12:\"backerymails\";s:10:\"field_name\";s:2:\"id\";s:11:\"entity_type\";s:19:\"backerymails_entity\";s:6:\"bundle\";N;}}s:6:\"module\";O:37:\"Drupal\Core\Field\BaseFieldDefinition\":5:{s:7:\" * type\";s:6:\"string\";s:9:\" * schema\";a:4:{s:7:\"columns\";a:1:{s:5:\"value\";a:3:{s:4:\"type\";s:7:\"varchar\";s:6:\"length\";i:255;s:6:\"binary\";b:0;}}s:11:\"unique keys\";a:0:{}s:7:\"indexes\";a:0:{}s:12:\"foreign keys\";a:0:{}}s:10:\" * indexes\";a:0:{}s:17:\" * itemDefinition\";O:51:\"Drupal\Core\Field\TypedData\FieldItemDataDefinition\":2:{s:18:\" * fieldDefinition\";r:39;s:13:\" * definition\";a:2:{s:4:\"type\";s:17:\"field_item:string\";s:8:\"settings\";a:3:{s:10:\"max_length\";i:255;s:8:\"is_ascii\";b:0;s:14:\"case_sensitive\";b:0;}}}s:13:\" * definition\";a:6:{s:5:\"label\";O:48:\"Drupal\Core\StringTranslation\TranslatableMarkup\":3:{s:9:\" * string\";s:6:\"Module\";s:12:\" * arguments\";a:0:{}s:10:\" * options\";a:0:{}}s:11:\"description\";O:48:\"Drupal\Core\StringTranslation\TranslatableMarkup\":3:{s:9:\" * string\";s:30:\"The module that send the mail.\";s:12:\" * arguments\";a:0:{}s:10:\" * options\";a:0:{}}s:8:\"provider\";s:12:\"backerymails\";s:10:\"field_name\";s:6:\"module\";s:11:\"entity_type\";s:19:\"backerymails_entity\";s:6:\"bundle\";N;}}s:10:\"module_key\";O:37:\"Drupal\Core\Field\BaseFieldDefinition\":5:{s:7:\" * type\";s:6:\"string\";s:9:\" * schema\";a:4:{s:7:\"columns\";a:1:{s:5:\"value\";a:3:{s:4:\"type\";s:7:\"varchar\";s:6:\"length\";i:255;s:6:\"binary\";b:0;}}s:11:\"unique keys\";a:0:{}s:7:\"indexes\";a:0:{}s:12:\"foreign keys\";a:0:{}}s:10:\" * indexes\";a:0:{}s:17:\" * itemDefinition\";O:51:\"Drupal\Core\Field\TypedData\FieldItemDataDefinition\":2:{s:18:\" * fieldDefinition\";r:72;s:13:\" * definition\";a:2:{s:4:\"type\";s:17:\"field_item:string\";s:8:\"settings\";a:3:{s:10:\"max_length\";i:255;s:8:\"is_ascii\";b:0;s:14:\"case_sensitive\";b:0;}}}s:13:\" * definition\";a:6:{s:5:\"label\";O:48:\"Drupal\Core\StringTranslation\TranslatableMarkup\":3:{s:9:\" * string\";s:3:\"Key\";s:12:\" * arguments\";a:0:{}s:10:\" * options\";a:0:{}}s:11:\"description\";O:48:\"Drupal\Core\StringTranslation\TranslatableMarkup\":3:{s:9:\" * string\";s:46:\"The key of the mail, concording to the module.\";s:12:\" * arguments\";a:0:{}s:10:\" * options\";a:0:{}}s:8:\"provider\";s:12:\"backerymails\";s:10:\"field_name\";s:10:\"module_key\";s:11:\"entity_type\";s:19:\"backerymails_entity\";s:6:\"bundle\";N;}}s:9:\"mail_from\";O:37:\"Drupal\Core\Field\BaseFieldDefinition\":5:{s:7:\" * type\";s:6:\"string\";s:9:\" * schema\";a:4:{s:7:\"columns\";a:1:{s:5:\"value\";a:3:{s:4:\"type\";s:7:\"varchar\";s:6:\"length\";i:255;s:6:\"binary\";b:0;}}s:11:\"unique keys\";a:0:{}s:7:\"indexes\";a:0:{}s:12:\"foreign keys\";a:0:{}}s:10:\" * indexes\";a:0:{}s:17:\" * itemDefinition\";O:51:\"Drupal\Core\Field\TypedData\FieldItemDataDefinition\":2:{s:18:\" * fieldDefinition\";r:105;s:13:\" * definition\";a:2:{s:4:\"type\";s:17:\"field_item:string\";s:8:\"settings\";a:3:{s:10:\"max_length\";i:255;s:8:\"is_ascii\";b:0;s:14:\"case_sensitive\";b:0;}}}s:13:\" * definition\";a:6:{s:5:\"label\";O:48:\"Drupal\Core\StringTranslation\TranslatableMarkup\":3:{s:9:\" * string\";s:4:\"From\";s:12:\" * arguments\";a:0:{}s:10:\" * options\";a:0:{}}s:11:\"description\";O:48:\"Drupal\Core\StringTranslation\TranslatableMarkup\":3:{s:9:\" * string\";s:23:\"The sender of the mail.\";s:12:\" * arguments\";a:0:{}s:10:\" * options\";a:0:{}}s:8:\"provider\";s:12:\"backerymails\";s:10:\"field_name\";s:9:\"mail_from\";s:11:\"entity_type\";s:19:\"backerymails_entity\";s:6:\"bundle\";N;}}s:7:\"mail_to\";O:37:\"Drupal\Core\Field\BaseFieldDefinition\":5:{s:7:\" * type\";s:6:\"string\";s:9:\" * schema\";a:4:{s:7:\"columns\";a:1:{s:5:\"value\";a:3:{s:4:\"type\";s:7:\"varchar\";s:6:\"length\";i:255;s:6:\"binary\";b:0;}}s:11:\"unique keys\";a:0:{}s:7:\"indexes\";a:0:{}s:12:\"foreign keys\";a:0:{}}s:10:\" * indexes\";a:0:{}s:17:\" * itemDefinition\";O:51:\"Drupal\Core\Field\TypedData\FieldItemDataDefinition\":2:{s:18:\" * fieldDefinition\";r:138;s:13:\" * definition\";a:2:{s:4:\"type\";s:17:\"field_item:string\";s:8:\"settings\";a:3:{s:10:\"max_length\";i:255;s:8:\"is_ascii\";b:0;s:14:\"case_sensitive\";b:0;}}}s:13:\" * definition\";a:6:{s:5:\"label\";O:48:\"Drupal\Core\StringTranslation\TranslatableMarkup\":3:{s:9:\" * string\";s:2:\"To\";s:12:\" * arguments\";a:0:{}s:10:\" * options\";a:0:{}}s:11:\"description\";O:48:\"Drupal\Core\StringTranslation\TranslatableMarkup\":3:{s:9:\" * string\";s:29:\"The recipient(s) of the mail.\";s:12:\" * arguments\";a:0:{}s:10:\" * options\";a:0:{}}s:8:\"provider\";s:12:\"backerymails\";s:10:\"field_name\";s:7:\"mail_to\";s:11:\"entity_type\";s:19:\"backerymails_entity\";s:6:\"bundle\";N;}}s:13:\"mail_reply_to\";O:37:\"Drupal\Core\Field\BaseFieldDefinition\":5:{s:7:\" * type\";s:6:\"string\";s:9:\" * schema\";a:4:{s:7:\"columns\";a:1:{s:5:\"value\";a:3:{s:4:\"type\";s:7:\"varchar\";s:6:\"length\";i:255;s:6:\"binary\";b:0;}}s:11:\"unique keys\";a:0:{}s:7:\"indexes\";a:0:{}s:12:\"foreign keys\";a:0:{}}s:10:\" * indexes\";a:0:{}s:17:\" * itemDefinition\";O:51:\"Drupal\Core\Field\TypedData\FieldItemDataDefinition\":2:{s:18:\" * fieldDefinition\";r:171;s:13:\" * definition\";a:2:{s:4:\"type\";s:17:\"field_item:string\";s:8:\"settings\";a:3:{s:10:\"max_length\";i:255;s:8:\"is_ascii\";b:0;s:14:\"case_sensitive\";b:0;}}}s:13:\" * definition\";a:6:{s:5:\"label\";O:48:\"Drupal\Core\StringTranslation\TranslatableMarkup\":3:{s:9:\" * string\";s:8:\"Reply-to\";s:12:\" * arguments\";a:0:{}s:10:\" * options\";a:0:{}}s:11:\"description\";O:48:\"Drupal\Core\StringTranslation\TranslatableMarkup\":3:{s:9:\" * string\";s:28:\"The reply-to(s) of the mail.\";s:12:\" * arguments\";a:0:{}s:10:\" * options\";a:0:{}}s:8:\"provider\";s:12:\"backerymails\";s:10:\"field_name\";s:13:\"mail_reply_to\";s:11:\"entity_type\";s:19:\"backerymails_entity\";s:6:\"bundle\";N;}}s:8:\"langcode\";O:37:\"Drupal\Core\Field\BaseFieldDefinition\":5:{s:7:\" * type\";s:6:\"string\";s:9:\" * schema\";a:4:{s:7:\"columns\";a:1:{s:5:\"value\";a:3:{s:4:\"type\";s:7:\"varchar\";s:6:\"length\";i:12;s:6:\"binary\";b:0;}}s:11:\"unique keys\";a:0:{}s:7:\"indexes\";a:0:{}s:12:\"foreign keys\";a:0:{}}s:10:\" * indexes\";a:0:{}s:17:\" * itemDefinition\";O:51:\"Drupal\Core\Field\TypedData\FieldItemDataDefinition\":2:{s:18:\" * fieldDefinition\";r:204;s:13:\" * definition\";a:2:{s:4:\"type\";s:17:\"field_item:string\";s:8:\"settings\";a:3:{s:10:\"max_length\";i:12;s:8:\"is_ascii\";b:0;s:14:\"case_sensitive\";b:0;}}}s:13:\" * definition\";a:6:{s:5:\"label\";O:48:\"Drupal\Core\StringTranslation\TranslatableMarkup\":3:{s:9:\" * string\";s:8:\"Langcode\";s:12:\" * arguments\";a:0:{}s:10:\" * options\";a:0:{}}s:11:\"description\";O:48:\"Drupal\Core\StringTranslation\TranslatableMarkup\":3:{s:9:\" * string\";s:25:\"The langcode of the mail.\";s:12:\" * arguments\";a:0:{}s:10:\" * options\";a:0:{}}s:8:\"provider\";s:12:\"backerymails\";s:10:\"field_name\";s:8:\"langcode\";s:11:\"entity_type\";s:19:\"backerymails_entity\";s:6:\"bundle\";N;}}s:7:\"subject\";O:37:\"Drupal\Core\Field\BaseFieldDefinition\":5:{s:7:\" * type\";s:6:\"string\";s:9:\" * schema\";a:4:{s:7:\"columns\";a:1:{s:5:\"value\";a:3:{s:4:\"type\";s:7:\"varchar\";s:6:\"length\";i:255;s:6:\"binary\";b:0;}}s:11:\"unique keys\";a:0:{}s:7:\"indexes\";a:0:{}s:12:\"foreign keys\";a:0:{}}s:10:\" * indexes\";a:0:{}s:17:\" * itemDefinition\";O:51:\"Drupal\Core\Field\TypedData\FieldItemDataDefinition\":2:{s:18:\" * fieldDefinition\";r:237;s:13:\" * definition\";a:2:{s:4:\"type\";s:17:\"field_item:string\";s:8:\"settings\";a:3:{s:10:\"max_length\";i:255;s:8:\"is_ascii\";b:0;s:14:\"case_sensitive\";b:0;}}}s:13:\" * definition\";a:6:{s:5:\"label\";O:48:\"Drupal\Core\StringTranslation\TranslatableMarkup\":3:{s:9:\" * string\";s:7:\"Subject\";s:12:\" * arguments\";a:0:{}s:10:\" * options\";a:0:{}}s:11:\"description\";O:48:\"Drupal\Core\StringTranslation\TranslatableMarkup\":3:{s:9:\" * string\";s:24:\"The subject of the mail.\";s:12:\" * arguments\";a:0:{}s:10:\" * options\";a:0:{}}s:8:\"provider\";s:12:\"backerymails\";s:10:\"field_name\";s:7:\"subject\";s:11:\"entity_type\";s:19:\"backerymails_entity\";s:6:\"bundle\";N;}}s:4:\"body\";O:37:\"Drupal\Core\Field\BaseFieldDefinition\":5:{s:7:\" * type\";s:9:\"text_long\";s:9:\" * schema\";a:4:{s:7:\"columns\";a:2:{s:5:\"value\";a:2:{s:4:\"type\";s:4:\"text\";s:4:\"size\";s:3:\"big\";}s:6:\"format\";a:2:{s:4:\"type\";s:13:\"varchar_ascii\";s:6:\"length\";i:255;}}s:7:\"indexes\";a:1:{s:6:\"format\";a:1:{i:0;s:6:\"format\";}}s:11:\"unique keys\";a:0:{}s:12:\"foreign keys\";a:0:{}}s:10:\" * indexes\";a:0:{}s:17:\" * itemDefinition\";O:51:\"Drupal\Core\Field\TypedData\FieldItemDataDefinition\":2:{s:18:\" * fieldDefinition\";r:270;s:13:\" * definition\";a:2:{s:4:\"type\";s:20:\"field_item:text_long\";s:8:\"settings\";a:0:{}}}s:13:\" * definition\";a:6:{s:5:\"label\";O:48:\"Drupal\Core\StringTranslation\TranslatableMarkup\":3:{s:9:\" * string\";s:4:\"Body\";s:12:\" * arguments\";a:0:{}s:10:\" * options\";a:0:{}}s:11:\"description\";O:48:\"Drupal\Core\StringTranslation\TranslatableMarkup\":3:{s:9:\" * string\";s:21:\"The body of the mail.\";s:12:\" * arguments\";a:0:{}s:10:\" * options\";a:0:{}}s:8:\"provider\";s:12:\"backerymails\";s:10:\"field_name\";s:4:\"body\";s:11:\"entity_type\";s:19:\"backerymails_entity\";s:6:\"bundle\";N;}}s:7:\"created\";O:37:\"Drupal\Core\Field\BaseFieldDefinition\":5:{s:7:\" * type\";s:7:\"created\";s:9:\" * schema\";a:4:{s:7:\"columns\";a:1:{s:5:\"value\";a:1:{s:4:\"type\";s:3:\"int\";}}s:11:\"unique keys\";a:0:{}s:7:\"indexes\";a:0:{}s:12:\"foreign keys\";a:0:{}}s:10:\" * indexes\";a:0:{}s:17:\" * itemDefinition\";O:51:\"Drupal\Core\Field\TypedData\FieldItemDataDefinition\":2:{s:18:\" * fieldDefinition\";r:304;s:13:\" * definition\";a:2:{s:4:\"type\";s:18:\"field_item:created\";s:8:\"settings\";a:0:{}}}s:13:\" * definition\";a:6:{s:5:\"label\";O:48:\"Drupal\Core\StringTranslation\TranslatableMarkup\":3:{s:9:\" * string\";s:7:\"Created\";s:12:\" * arguments\";a:0:{}s:10:\" * options\";a:0:{}}s:11:\"description\";O:48:\"Drupal\Core\StringTranslation\TranslatableMarkup\":3:{s:9:\" * string\";s:37:\"The time that the entity was created.\";s:12:\" * arguments\";a:0:{}s:10:\" * options\";a:0:{}}s:8:\"provider\";s:12:\"backerymails\";s:10:\"field_name\";s:7:\"created\";s:11:\"entity_type\";s:19:\"backerymails_entity\";s:6:\"bundle\";N;}}}",
))
->values(array(
  'collection' => 'entity.storage_schema.sql',
  'name' => 'backerymails_entity.entity_schema_data',
  'value' => 'a:1:{s:24:"backerymails_sended_mail";a:1:{s:11:"primary key";a:1:{i:0;s:2:"id";}}}',
))
->execute();

// Insert Backerymails Entity fields key_value entries.
$connection->insert('key_value')
->fields(array(
  'collection',
  'name',
  'value',
))
->values(array(
  'collection' => 'entity.storage_schema.sql',
  'name' => 'backerymails_entity.field_schema_data.body',
  'value' => 'a:1:{s:24:"backerymails_sended_mail";a:2:{s:6:"fields";a:2:{s:11:"body__value";a:3:{s:4:"type";s:4:"text";s:4:"size";s:3:"big";s:8:"not null";b:0;}s:12:"body__format";a:3:{s:4:"type";s:13:"varchar_ascii";s:6:"length";i:255;s:8:"not null";b:0;}}s:7:"indexes";a:1:{s:39:"backerymails_entity_field__body__format";a:1:{i:0;s:12:"body__format";}}}}',
))
->values(array(
  'collection' => 'entity.storage_schema.sql',
  'name' => 'backerymails_entity.field_schema_data.created',
  'value' => 'a:1:{s:24:"backerymails_sended_mail";a:1:{s:6:"fields";a:1:{s:7:"created";a:2:{s:4:"type";s:3:"int";s:8:"not null";b:0;}}}}',
))
->values(array(
  'collection' => 'entity.storage_schema.sql',
  'name' => 'backerymails_entity.field_schema_data.id',
  'value' => 'a:1:{s:24:"backerymails_sended_mail";a:1:{s:6:"fields";a:1:{s:2:"id";a:4:{s:4:"type";s:6:"serial";s:8:"unsigned";b:1;s:4:"size";s:6:"normal";s:8:"not null";b:1;}}}}',
))
->values(array(
  'collection' => 'entity.storage_schema.sql',
  'name' => 'backerymails_entity.field_schema_data.langcode',
  'value' => 'a:1:{s:24:"backerymails_sended_mail";a:1:{s:6:"fields";a:1:{s:8:"langcode";a:4:{s:4:"type";s:7:"varchar";s:6:"length";i:12;s:6:"binary";b:0;s:8:"not null";b:0;}}}}',
))
->values(array(
  'collection' => 'entity.storage_schema.sql',
  'name' => 'backerymails_entity.field_schema_data.mail_from',
  'value' => 'a:1:{s:24:"backerymails_sended_mail";a:1:{s:6:"fields";a:1:{s:9:"mail_from";a:4:{s:4:"type";s:7:"varchar";s:6:"length";i:255;s:6:"binary";b:0;s:8:"not null";b:0;}}}}',
))
->values(array(
  'collection' => 'entity.storage_schema.sql',
  'name' => 'backerymails_entity.field_schema_data.mail_reply_to',
  'value' => 'a:1:{s:24:"backerymails_sended_mail";a:1:{s:6:"fields";a:1:{s:13:"mail_reply_to";a:4:{s:4:"type";s:7:"varchar";s:6:"length";i:255;s:6:"binary";b:0;s:8:"not null";b:0;}}}}',
))
->values(array(
  'collection' => 'entity.storage_schema.sql',
  'name' => 'backerymails_entity.field_schema_data.mail_to',
  'value' => 'a:1:{s:24:"backerymails_sended_mail";a:1:{s:6:"fields";a:1:{s:7:"mail_to";a:4:{s:4:"type";s:7:"varchar";s:6:"length";i:255;s:6:"binary";b:0;s:8:"not null";b:0;}}}}',
))
->values(array(
  'collection' => 'entity.storage_schema.sql',
  'name' => 'backerymails_entity.field_schema_data.module',
  'value' => 'a:1:{s:24:"backerymails_sended_mail";a:1:{s:6:"fields";a:1:{s:6:"module";a:4:{s:4:"type";s:7:"varchar";s:6:"length";i:255;s:6:"binary";b:0;s:8:"not null";b:0;}}}}',
))
->values(array(
  'collection' => 'entity.storage_schema.sql',
  'name' => 'backerymails_entity.field_schema_data.module_key',
  'value' => 'a:1:{s:24:"backerymails_sended_mail";a:1:{s:6:"fields";a:1:{s:10:"module_key";a:4:{s:4:"type";s:7:"varchar";s:6:"length";i:255;s:6:"binary";b:0;s:8:"not null";b:0;}}}}',
))
->values(array(
  'collection' => 'entity.storage_schema.sql',
  'name' => 'backerymails_entity.field_schema_data.subject',
  'value' => 'a:1:{s:24:"backerymails_sended_mail";a:1:{s:6:"fields";a:1:{s:7:"subject";a:4:{s:4:"type";s:7:"varchar";s:6:"length";i:255;s:6:"binary";b:0;s:8:"not null";b:0;}}}}',
))
->execute();

$connection->schema()->createTable('backerymails_sended_mail', array(
  'fields' => array(
    'id' => array(
      'type' => 'serial',
      'size' => 'normal',
      'unsigned' => TRUE,
      'not null' => TRUE,
    ),
    'module' => array(
      'type' => 'varchar_ascii',
      'not null' => FALSE,
      'length' => '255',
    ),
    'module_key' => array(
      'type' => 'varchar_ascii',
      'not null' => FALSE,
      'length' => '255',
    ),
    'module_key' => array(
      'type' => 'varchar_ascii',
      'not null' => FALSE,
      'length' => '255',
    ),
    'mail_from' => array(
      'type' => 'varchar_ascii',
      'not null' => FALSE,
      'length' => '255',
    ),
    'mail_to' => array(
      'type' => 'varchar_ascii',
      'not null' => FALSE,
      'length' => '255',
    ),
    'mail_reply_to' => array(
      'type' => 'varchar_ascii',
      'not null' => FALSE,
      'length' => '255',
    ),
    'langcode' => array(
      'type' => 'varchar_ascii',
      'not null' => FALSE,
      'length' => '12',
    ),
    'subject' => array(
      'type' => 'varchar_ascii',
      'not null' => FALSE,
      'length' => '255',
    ),
    'body__value' => array(
      'type' => 'text',
      'not null' => FALSE,
      'size' => 'normal',
    ),
    'body__format' => array(
      'type' => 'varchar_ascii',
      'not null' => FALSE,
      'length' => '255',
    ),
    'created' => array(
      'type' => 'int',
      'not null' => FALSE,
    ),
    'changed' => array(
      'type' => 'int',
      'not null' => FALSE,
    ),
  ),
  'primary key' => array(
    'id',
  ),
  'mysql_character_set' => 'utf8mb4',
));
