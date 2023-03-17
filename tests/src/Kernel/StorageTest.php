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
  protected static $modules = [
    'system',
    'text',
    'backerymails',
    'backerymails_test',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    // Set the System Site mail.
    $this->config('system.site')->set('mail', 'admin@example.org')->save();

    $this->installEntitySchema('backerymails_entity');

    $this->mailManager = $this->container->get('plugin.manager.mail');
    $this->backerymailsStorage = $this->container->get('entity_type.manager')->getStorage('backerymails_entity');

    $this->container->get('config.factory')->getEditable('backerymails.settings')
      ->set('reroute', [
        'status'     => FALSE,
        'recipients' => 'reroute@example.org',
      ])->save();

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
   * When the exclusion is filled, the mail should not be stored but still sent.
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

    // Asserts sensitive excluded mails are still sent.
    $captured_emails = $this->getMails();
    self::assertCount(1, $captured_emails);
    self::assertEquals('backerymails_test_test', $captured_emails[0]['id']);
    self::assertEquals('admin@example.org', $captured_emails[0]['from']);
    self::assertNull($captured_emails[0]['reply-to']);

    self::assertSame([
      'MIME-Version'              => '1.0',
      'Content-Type'              => 'text/html; charset=UTF-8; format=flowed; delsp=yes',
      'Content-Transfer-Encoding' => '8Bit',
      'X-Mailer'                  => 'Drupal',
      'Return-Path'               => 'admin@example.org',
      'Sender'                    => 'admin@example.org',
      'From'                      => 'admin@example.org',
    ], $captured_emails[0]['headers']);
  }

}
