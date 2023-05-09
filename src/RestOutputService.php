<?php

namespace Drupal\dependency_injection_exercise;

use Drupal\Component\Serialization\Json;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class RestOutputService for get data from third party API service.
 * @package Drupal\dependency_injection_exercise\Service.
 */
class RestOutputService {
  use StringTranslationTrait;

  /**
   * @return array[]
   * @throws \Exception
   */
  public function load(): array {
    $build = [
      '#cache' => [
        'max-age' => 60,
        'contexts' => [
          'url',
        ],
      ],
    ];

    // Try to obtain the photo data via the external API.
    try {
      $response = \Drupal::httpClient()->request('GET', sprintf('https://jsonplaceholder.typicode.com/albums/%s/photos', random_int(1, 20)));
      $raw_data = $response->getBody()->getContents();
      $data = Json::decode($raw_data);
    }
    catch (GuzzleException $e) {
      $build['error'] = [
        '#type' => 'html_tag',
        '#tag' => 'p',
        '#value' => t('No photos available.'),
      ];
      return $build;
    }

    // Build a listing of photos from the photo data.
    $build['photos'] = array_map(static function ($item) {
      return [
        '#theme' => 'image',
        '#uri' => $item['thumbnailUrl'],
        '#alt' => $item['title'],
        '#title' => $item['title'],
      ];
    }, $data);

    return $build;
  }

}
