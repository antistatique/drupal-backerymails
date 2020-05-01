<?php

namespace Drupal\backerymails\Controller;

use Drupal\backerymails\Entity\BackerymailsEntityInterface;

class viewController
{
  /**
   * {@inheritdoc}
   */
  public function build(BackerymailsEntityInterface $backerymails_entity) {
    return [
        '#theme'     => 'backerymails_view',
        '#variables' => $backerymails_entity,
    ];
  }
}