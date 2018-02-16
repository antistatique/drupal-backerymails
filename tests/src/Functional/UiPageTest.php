<?php

namespace Drupal\Tests\backerymails\Functional;

/**
 * Tests collection pages and clean.
 *
 * @group backerymails_ui
 * @group backerymails
 */
class UiPageTest extends BackerymailsTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['backerymails'];

  /**
   * We use the minimal profile because we want to test local action links.
   *
   * @var string
   */
  protected $profile = 'minimal';

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    // Create a user for tests.
    $account = $this->drupalCreateUser(['administer backerymails']);
    $this->drupalLogin($account);
  }

  /**
   * Tests that the collection page works.
   */
  public function testCollectionEmptyPage() {
    $this->drupalGet('admin/config/backerymails/mails');
    $this->assertSession()->statusCodeEquals(200);

    // Test that there is an empty listing.
    $this->assertSession()->pageTextContains('No content available.');
  }

  /**
   * Tests that collection page list backerymails works.
   */
  public function testCollectionPage() {
    $backerymail = $this->container->get('entity_type.manager')->getStorage('backerymails_entity')
      ->create([
        'module'        => 'backerymails.module',
        'module_key'    => 'backerymails.module_key',
        'mail_from'     => 'backerymails.mail_from',
        'mail_to'       => 'backerymails.mail_to',
        'mail_reply_to' => 'backerymails.mail_reply_to',
        'langcode'      => 'en',
        'subject'       => 'backerymails.subject',
        'body'          => 'backerymails.body',
      ]);
    $backerymail->save();

    $this->drupalGet('admin/config/backerymails/mails');
    $this->assertSession()->statusCodeEquals(200);

    // Test that there is a listing.
    $this->assertSession()->pageTextContains('backerymails.module');
    $this->assertSession()->pageTextContains('backerymails.module_key');
    $this->assertSession()->pageTextContains('backerymails.mail_from');
    $this->assertSession()->pageTextContains('backerymails.mail_to');
    $this->assertSession()->pageTextContains('backerymails.mail_reply_to');
    $this->assertSession()->pageTextContains('backerymails.subject');
  }

  /**
   * Tests that clean works.
   */
  public function testClear() {
    // Setup a template whisperer with one suggestion.
    $this->testCollectionPage();

    $this->clickLink('Delete All');
    $this->assertSession()->pageTextContains('Are you sure you want to clear all the entries?');
    $this->assertSession()->pageTextContains('All logs database entries will be deleted. This action cannot be undone.');

    $this->pressButton('Clear');
    $this->assertSession()->pageTextContains('All backerymails entries have been deleted.');
  }

}
