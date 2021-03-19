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
class RenameAndMigrateEntityTableUpdate8001Test extends UpdatePathTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['backerymails'];

  /**
   * {@inheritdoc}
   */
  protected function setDatabaseDumpFiles() {
    // This conditional allows tests to pass both before and after 8.8.x. The
    // 8.4.0 fixtures were removed in 8.8.x.
    // https://www.drupal.org/project/consumers/issues/3115996
    // @todo: Remove this conditional after 8.7.x is no longer supported.

    if (file_exists(DRUPAL_ROOT . '/core/modules/system/tests/fixtures/update/drupal-8.8.0.bare.standard.php.gz')) {
      $this->databaseDumpFiles = [
        DRUPAL_ROOT . '/core/modules/system/tests/fixtures/update/drupal-8.8.0.bare.standard.php.gz',
       __DIR__ . '/../../../fixtures/update/drupal-8.backerymails-installed.php',
       __DIR__ . '/../../../fixtures/update/drupal-8.backerymails-entity-typos-8001.php',
      ];
    }
    else {
      $this->databaseDumpFiles = [
        // @todo: Remove this fixture after 8.7 is no longer supported.
        DRUPAL_ROOT . '/core/modules/system/tests/fixtures/update/drupal-8.bare.standard.php.gz',
        __DIR__ . '/../../../fixtures/update/drupal-8.backerymails-installed.php',
        __DIR__ . '/../../../fixtures/update/drupal-8.backerymails-entity-typos-8001.php',
      ];
    }
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
   * Ensure every existing entries in the old table are migrated.
   *
   * @see backerymails_update_8001()
   */
  public function testUpdate8001() {
    $database = Database::getConnection();

    $this->assertFalse($database->schema()->tableExists('backerymails_sent_mails'));
    $this->assertTrue($database->schema()->tableExists('backerymails_sended_mail'));
    $this->assertEquals(0, $database->query('SELECT count(*) FROM {backerymails_sended_mail}')->fetchField());

    $database->insert('backerymails_sended_mail')
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
    $this->assertEquals(1, $database->query('SELECT count(*) FROM {backerymails_sended_mail}')->fetchField());

    $this->runUpdates();

    $this->assertTrue($database->schema()->tableExists('backerymails_sent_mails'));
    $this->assertFalse($database->schema()->tableExists('backerymails_sended_mail'));

    $this->assertEquals(1, $database->query('SELECT count(*) FROM {backerymails_sent_mails}')->fetchField());
    $backerymails = BackerymailsEntity::loadMultiple();
    $this->assertCount(1, $backerymails);
  }

}
