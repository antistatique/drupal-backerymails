<?php

namespace Drupal\backerymails;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Backerymails entity entity.
 *
 * @see \Drupal\backerymails\Entity\BackerymailsEntity.
 */
class BackerymailsEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\backerymails\Entity\BackerymailsEntityInterface $entity */
    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'administer backerymails');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'administer backerymails');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

}
