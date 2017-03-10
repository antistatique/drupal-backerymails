<?php

namespace Drupal\backerymails\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Url;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\Query\QueryFactory;

/**
 * Provides a form for clearing all the maillog entries.
 */
class ClearForm extends ConfirmFormBase {
  /**
   * EntityQuery instance.
   *
   * @var \Drupal\Core\Entity\Query\QueryFactory
   */
  private $entityQuery;

  /**
   * EntityTypeManagerInterface to load Backerymails.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  private $entityBackerymails;

  /**
   * Class constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity
   *   The interface for entity type managers.
   * @param \Drupal\Core\Entity\Query\QueryFactory $entityQuery
   *   The factory class Creating entity query objects.
   */
  public function __construct(EntityTypeManagerInterface $entity, QueryFactory $entityQuery) {
    $this->entityBackerymails = $entity->getStorage('backerymails_entity');
    $this->entityQuery        = $entityQuery;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    // Instantiates this form class.
    return new static(
    // Load the service required to construct this class.
    $container->get('entity_type.manager'),
    $container->get('entity.query')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'backerymails_clear';
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->t('All logs database entries will be deleted. This action cannot be undone.');
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Are you sure you want to clear all the entries?');
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('backerymails.settings');
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return $this->t('Clear');
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $result = $this->entityQuery->get('backerymails_entity')
      ->execute();
    $entities = $this->entityBackerymails->loadMultiple($result);
    $this->entityBackerymails->delete($entities);

    drupal_set_message($this->t("All backerymails entries have been deleted."));
    $form_state->setRedirect('backerymails.settings');
  }

}
