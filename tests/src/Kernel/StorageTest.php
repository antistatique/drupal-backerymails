<?php

namespace Drupal\Tests\backerymails\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\Core\Test\AssertMailTrait;

/**
 * @covers ::backerymails_mail_alter
 *
 * @group backerymails
 * @group backerymails_kernel
 */
class StorageTest extends KernelTestBase {
  use AssertMailTrait;

  /**
   * Composes and optionally sends an email message.
   *
   * @var \Drupal\Core\Mail\MailManagerInterface
   */
  protected $mailManager;

  /**
   * The backerymails storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $backerymailsStorage;

  /**
   * {@inheritdoc}
   */
  public static $modules = [
    'system',
    'text',
    'backerymails',
    'backerymails_test',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    // Set the System Site mail.
    $this->config('system.site')->set('mail', 'admin@example.org')->save();

    $this->installEntitySchema('backerymails_entity');

    $this->mailManager = $this->container->get('plugin.manager.mail');
    $this->backerymailsStorage = $this->container->get('entity_type.manager')->getStorage('backerymails_entity');

    $this->container->get('config.factory')->getEditable('backerymails.settings')
      ->set('excludes', [
        'customs'    => [],
        'sensitives' => [],
      ])->save();
  }

  /**
   * When sending an email, a backerymail should be stored.
   */
  public function testSendingShouldStore() {
    $email = $this->backerymailsStorage->loadMultiple();
    $this->assertCount(0, $email);

    // Send the email.
    $this->mailManager->mail('backerymails_test', 'test', 'foobar@example.org', 'en');

    // Asserts only one mail has been saved.
    $email = $this->backerymailsStorage->loadMultiple();
    $this->assertCount(1, $email);

    $email = reset($email);
    $this->assertEquals('backerymails_test', $email->getModule());
    $this->assertEquals('test', $email->getModuleKey());
    $this->assertEquals('admin@example.org', $email->getFrom());
    $this->assertEquals('foobar@example.org', $email->getTo());
    $this->assertEquals('', $email->getReplyto());
    $this->assertEquals('en', $email->getLangcode());
    $this->assertEquals('foo', $email->getSubject());
    $this->assertEquals('["bar"]', $email->getBody());
  }

  /**
   * When the exclusion is filled, the mail should not be saved nor sent.
   */
  public function testExclusionShouldNotStore() {
    $this->container->get('config.factory')->getEditable('backerymails.settings')
      ->set('excludes', [
        'customs' => ['backerymails_test.test'],
        'sensitives' => [],
      ])->save();

    // Send the email.
    $this->mailManager->mail('backerymails_test', 'test', 'foobar@example.org', 'en');

    // Asserts no mail has been saved.
    $saved_emails = $this->backerymailsStorage->loadMultiple();
    $this->assertCount(0, $saved_emails, 'No email was saved.');

    // Ensure that there is no email in the captured emails array.
    $captured_emails = $this->getMails();
    $this->assertCount(0, $captured_emails, 'No email was captured.');
  }

}
