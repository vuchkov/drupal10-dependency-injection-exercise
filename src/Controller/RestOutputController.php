<?php

namespace Drupal\dependency_injection_exercise\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\dependency_injection_exercise\RestOutputService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides the rest output.
 */
class RestOutputController extends ControllerBase {

  /**
   * RestOutputService object.
   *
   * @var array
   */
  private $rest_output;

  /**
   * RestOutputController constructor.
   *
   * @param \Drupal\dependency_injection_exercise\RestOutputService $rest_output
   *   RestOutputService service.
   * @throws \Exception
   */
  public function __construct(RestOutputService $rest_output) {
    $this->rest_output = $rest_output->load();
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('dependency_injection_exercise.rest_output')
    );
  }

  /**
   * Displays the photos.
   *
   * @return array
   *   A renderable array representing the photos.
   */
  public function showPhotos(): array {
    return $this->rest_output;
  }

}
