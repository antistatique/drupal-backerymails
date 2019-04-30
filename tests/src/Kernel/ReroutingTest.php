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
class ReroutingTest extends KernelTestBase {
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
      ->set('reroute', [
        'status'     => TRUE,
        'recipients' => 'reroute@example.org',
      ])->save();

    $this->container->get('config.factory')->getEditable('backerymails.settings')
      ->set('excludes', [
        'customs'    => [],
        'sensitives' => [],
      ])->save();
  }

  /**
   * Asserts the rerouting alter the mail for a proper rerouting.
   */
  public function testReroute() {
    // Send the email.
    $this->mailManager->mail('backerymails_test', 'test', 'foobar@example.org', 'en');

    // Asserts only one mail has been stored.
    $stored_emails = $this->backerymailsStorage->loadMultiple();
    $this->assertCount(1, $stored_emails, 'One email was rerouted.');

    // Asserts we store the rerouted values.
    $stored_emails = reset($stored_emails);
    $this->assertEquals('backerymails_test', $stored_emails->getModule());
    $this->assertEquals('test', $stored_emails->getModuleKey());
    $this->assertEquals('admin@example.org', $stored_emails->getFrom());
    $this->assertEquals('reroute@example.org', $stored_emails->getTo());

    // Asserts we have added the Backerymails headers because of rerouting.
    $captured_emails = $this->getMails();
    $captured_email = reset($captured_emails);
    $this->assertEquals('backerymails_test_test', $captured_email['id']);
    $this->assertEquals('admin@example.org', $captured_email['from']);
    $this->assertNull($captured_email['reply-to']);
    $this->assertSame([
      'MIME-Version'              => "1.0",
      'Content-Type'              => "text/plain; charset=UTF-8; format=flowed; delsp=yes",
      'Content-Transfer-Encoding' => "8Bit",
      'X-Mailer'                  => "Drupal",
      'Return-Path'               => 'admin@example.org',
      'Sender'                    => 'admin@example.org',
      'From'                      => ' <admin@example.org>',
      'X-Backerymails-To'         => "foobar@example.org",
    ], $captured_email['headers']);
  }

  /**
   * Asserts the rerouting alter the mail even on multiple recipients.
   */
  public function testRerouteMultipleRecipients() {
    $this->container->get('config.factory')->getEditable('backerymails.settings')
      ->set('reroute', [
        'status'     => TRUE,
        'recipients' => 'reroute@example.org;reroute+secondary@example.org',
      ])->save();

    // Send the email.
    $this->mailManager->mail('backerymails_test', 'test', 'foobar@example.org,bar@example.org', 'en');

    // Asserts only one mail has been rerouted.
    $stored_emails = $this->backerymailsStorage->loadMultiple();
    $this->assertCount(1, $stored_emails, 'One email was rerouted.');

    // Asserts we store the rerouted values.
    $stored_emails = reset($stored_emails);
    $this->assertEquals('backerymails_test', $stored_emails->getModule());
    $this->assertEquals('test', $stored_emails->getModuleKey());
    $this->assertEquals('admin@example.org', $stored_emails->getFrom());
    $this->assertEquals('reroute@example.org,reroute+secondary@example.org', $stored_emails->getTo());

    // Asserts we have added the Backerymails rerouting headers.
    $captured_emails = $this->getMails();
    $captured_email = reset($captured_emails);
    $this->assertEquals('backerymails_test_test', $captured_email['id']);
    $this->assertEquals('admin@example.org', $captured_email['from']);
    $this->assertNull($captured_email['reply-to']);
    $this->assertSame([
      'MIME-Version'              => "1.0",
      'Content-Type'              => "text/plain; charset=UTF-8; format=flowed; delsp=yes",
      'Content-Transfer-Encoding' => "8Bit",
      'X-Mailer'                  => "Drupal",
      'Return-Path'               => 'admin@example.org',
      'Sender'                    => 'admin@example.org',
      'From'                      => ' <admin@example.org>',
      'X-Backerymails-To'         => "foobar@example.org,bar@example.org",
    ], $captured_email['headers']);
  }

  /**
   * When an email is exluded, it should then no more rerouted.
   */
  public function testExcludesShouldNotReroute() {
    $this->container->get('config.factory')->getEditable('backerymails.settings')
      ->set('excludes', [
        'customs'    => ['backerymails_test.test'],
        'sensitives' => [],
      ])->save();

    // Send the email.
    $this->mailManager->mail('backerymails_test', 'test', 'foobar@example.org', 'en');

    // Asserts we don't store any exclusions.
    $stored_emails = $this->backerymailsStorage->loadMultiple();
    $this->assertCount(0, $stored_emails, 'No email was rerouted.');
  }

  /**
   * When rerouting is disabled, all email should works as intend.
   */
  public function testRerouteDisabled() {
    $this->container->get('config.factory')->getEditable('backerymails.settings')
      ->set('reroute', [
        'status'     => FALSE,
        'recipients' => 'reroute@example.org',
      ])->save();

    // Send the email.
    $this->mailManager->mail('backerymails_test', 'test', 'foobar@example.org', 'en');

    // Asserts only one mail has been stored.
    $stored_emails = $this->backerymailsStorage->loadMultiple();
    $this->assertCount(1, $stored_emails, 'One email was rerouted.');

    // Asserts we store the original values.
    $stored_emails = reset($stored_emails);
    $this->assertEquals('backerymails_test', $stored_emails->getModule());
    $this->assertEquals('test', $stored_emails->getModuleKey());
    $this->assertEquals('admin@example.org', $stored_emails->getFrom());
    $this->assertEquals('foobar@example.org', $stored_emails->getTo());
  }

}
