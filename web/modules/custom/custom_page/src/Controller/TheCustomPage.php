<?php
namespace Drupal\custom_page\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

class TheCustomPage extends ControllerBase
{

  public function new_page()
  {
    $limit = 5;
    $query = \Drupal::entityQuery('node')
      ->condition('status', 1)
      ->accessCheck(true)
      ->sort('nid', 'ASC')  // FOR ASCENDING ORDER
      // ->sort('nid', 'DESC') //FOR DESCENDING ORDER 
      ->pager($limit);
    $nids = $query->execute();
    foreach ($nids as $node) {
      $node = Node::load($node);
      $rows[] = [
        'id' => $node->id(),
        'title' => $node->getTitle(),
      ];
    }
    $pager = [
      '#type' => 'pager',
      '#element' => 0,
    ];
    $head = [
      ['data' => $this->t('ID')],
      ['data' => $this->t('Title')],
    ];
    return [
      'table' => [
        '#type' => 'table',
        '#header' => $head,
        '#rows' => $rows,
        '#empty' => $this->t('No content available.'),
      ],
      'pager' => $pager,
    ];
  }

}
