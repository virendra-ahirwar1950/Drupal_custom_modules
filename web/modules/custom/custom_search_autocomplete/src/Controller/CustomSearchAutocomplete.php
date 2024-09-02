<?php

namespace Drupal\custom_search_autocomplete\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller for autocomplete search functionality.
 */
class CustomSearchAutocompleteController extends ControllerBase {

  /**
   * Autocomplete callback for custom search.
   */
  public function autocomplete(Request $request) {
    $query = $request->query->get('q');

    // Perform database query to get matching node titles.
    $matches = $this->getMatchingNodeTitles($query);

    // Format results as needed.
    $matches = array_map(function($match) {
      return ['value' => $match->getTitle()]; // Adjust according to your node field.
    }, $matches);

    return new JsonResponse($matches);
  }

  /**
   * Helper function to fetch matching node titles from database.
   */
  private function getMatchingNodeTitles($query) {
    $entityTypeManager = \Drupal::entityTypeManager();
    $node_storage = $entityTypeManager->getStorage('node');

    // Query nodes that match the search term.
    $query = $node_storage->getQuery()
      ->condition('status', 1) // Published nodes only.
      ->condition('title', '%' . $query . '%', 'LIKE')
      ->range(0, 10) // Limit to 10 results.
      ->sort('title');

    $nids = $query->execute();
    $nodes = $node_storage->loadMultiple($nids);

    return $nodes;
  }

}
