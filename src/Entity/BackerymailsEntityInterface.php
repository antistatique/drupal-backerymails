<?php

namespace Drupal\backerymails\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface for defining Backerymails entity entities.
 *
 * @ingroup backerymails
 */
interface BackerymailsEntityInterface extends ContentEntityInterface, EntityChangedInterface {

  /**
   * Gets the Backerymails entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Backerymails entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Backerymails entity creation timestamp.
   *
   * @param int $timestamp
   *   The Backerymails entity creation timestamp.
   *
   * @return \Drupal\backerymails\Entity\BackerymailsEntityInterface
   *   The called Backerymails entity entity.
   */
  public function setCreatedTime($timestamp);

}
