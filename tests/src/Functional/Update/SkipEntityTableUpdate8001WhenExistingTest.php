<?php

namespace Drupal\Tests\backerymails\Functional\Update;

use Drupal\backerymails\Entity\BackerymailsEntity;
use Drupal\Core\Database\Database;
use Drupal\FunctionalTests\Update\UpdatePathTestBase;

/**
 * Tests Backerymails entity base-table renamed and migrated.
 *
 * @group backerymails
 * @group legacy
 *
 * @see backerymails_update_8001()
 * @see backerymails_post_update_migrate_data()
 */
class SkipEntityTableUpdate8001WhenExistingTest extends UpdatePathTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['backerymails'];

  /**
   * {@inheritdoc}
   */
  protected function setDatabaseDumpFiles() {
    $this->databaseDumpFiles = [
      DRUPAL_ROOT . '/core/modules/system/tests/fixtures/update/drupal-8.bare.standard.php.gz',
      __DIR__ . '/../../../fixtures/update/drupal-8.backerymails-installed.php',
      __DIR__ . '/../../../fixtures/update/drupal-8.backerymails-entity-installed.php',
    ];
  }

  /**
   * {@inheritdoc}
   */
  protected function doSelectionTest() {
    parent::doSelectionTest();
    $this->assertSession()->responseContains('Update Backerymails entity base table in order to fix typo in table name.');
  }

  /**
   * Tests backerymails_update_8001().
   *
   * Ensure when backerymails is installed for the first time with the proper
   * base table name, the hook update does not generate errors.
   *
   * @see backerymails_update_8001()
   */
  public function testUpdate8001() {
    $database = Database::getConnection();

    $this->assertTrue($database->schema()->tableExists('backerymails_sent_mails'));
    $this->assertFalse($database->schema()->tableExists('backerymails_sended_mail'));


    $database->insert('backerymails_sent_mails')
      ->fields([
        'module',
        'module_key',
        'mail_from',
        'mail_to',
        'mail_reply_to',
        'langcode',
        'subject',
        'body__value',
        'body__format',
      ])
      ->values([
        'backerymails.module',
        'backerymails.module_key',
        'backerymails.mail_from',
        'backerymails.mail_to',
        'backerymails.mail_reply_to',
        'en',
        'backerymails.subject',
        'backerymails.body',
        null,
      ])
      ->execute();

    $this->runUpdates();

    $this->assertTrue($database->schema()->tableExists('backerymails_sent_mails'));
    $this->assertFalse($database->schema()->tableExists('backerymails_sended_mail'));

    $this->assertEquals(1, $database->query('SELECT count(*) FROM {backerymails_sent_mails}')->fetchField());
    $backerymails = BackerymailsEntity::loadMultiple();
    $this->assertCount(1, $backerymails);
  }

}
