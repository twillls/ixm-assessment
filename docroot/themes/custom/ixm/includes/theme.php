<?php

/**
 * @file
 * Custom theme hook implementations.
 */

/**
 * Implements hook_theme().
 */
function ixm_theme($existing, $type, $theme, $path): array {
  /** @var \Drupal\Core\Extension\ThemeExtensionList $extensionList */
  $extensionList = \Drupal::service('extension.list.theme');
  $path = $extensionList->getPath('ixm') . '/templates';

  return [
    'icon' => [
      'variables' => [
        'name' => NULL,
        'classes' => [],
        'extra' => NULL,
      ],
      'path' => $path . '/components',
    ],
  ];
}
