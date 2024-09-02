<?php

namespace Drupal\custom_service\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\custom_service\CustomService;

class CustomController extends ControllerBase {

  protected $customService;

  public function __construct(CustomService $customService) {
    $this->customService = $customService;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('custom_service.my_custom_service')
    );
  }

  public function content() {
    $output = $this->customService->doSomething();
    return [
      '#markup' => $output,
    ];
  }

}
