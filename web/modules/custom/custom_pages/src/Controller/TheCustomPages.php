<?php

namespace Drupal\custom_pages\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Controller\FieldStorageConfig;

class TheCustomPages extends ControllerBase
{

  public function new_pages()
  {
    $query = \Drupal::entityQuery('node')
      ->condition('status', 1)
      // ->condition('type', 'Article') // for articles
      ->accessCheck(true);
    $nids = $query->execute();
    $options = [];
    foreach ($nids as $nid) {
      $node = \Drupal\node\Entity\Node::load($nid);
      $options[$node->id()] = $node->getTitle();
    }
   
    $form['node_dropdown'] = [
      '#type' => 'select',
      '#title' => 'Select a node',
      '#options' => $options,
      // '#empty_option' => $this->t('- Select -'),
    ];

    return $form;
  

    
  }

}
