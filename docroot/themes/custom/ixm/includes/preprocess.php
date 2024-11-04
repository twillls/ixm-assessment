<?php

/**
 * @file
 * Preprocess hook implementations.
 */

use Drupal\block\Entity\Block;

/**
 * Implements hook_preprocess_HOOK() for html templates.
 */
function ixm_preprocess_html(array &$variables): void {
  /** @var \Drupal\Core\Extension\ThemeExtensionList $themeExtensionList */
  $themeExtensionList = \Drupal::service('extension.list.theme');
  $icons = file_get_contents($themeExtensionList->getPath('ixm') . '/public/assets/icons.svg');
  $variables['page_bottom']['icons'] = [
    '#type' => 'inline_template',
    '#template' => '<span class="d-none icons-sprite">' . $icons . '</span>',
  ];
}

/**
 * Implements hook_preprocess_HOOK() for image templates.
 */
function ixm_preprocess_image(array &$variables): void {
  $variables['attributes']['class'][] = 'img-fluid';
}

/**
 * Implements hook_preprocess_HOOK() for table templates.
 */
function ixm_preprocess_table(array &$variables): void {
  $variables['attributes']['class'][] = 'table';
}

/**
 * Implements hook_preprocess_HOOK() for views_view_table templates.
 */
function ixm_preprocess_views_view_table(array &$variables): void {
  $variables['attributes']['class'][] = 'table';
  $variables['attributes']['class'][] = 'table-striped';
}

/**
 * Implements hook_preprocess_HOOK() for input templates.
 */
function ixm_preprocess_input(array &$variables): void {
  if ($variables['element']['#type'] === 'submit') {
    if ($variables['element']['#value'] === 'Preview') {
      $variables['attributes']['class'][] = 'btn-secondary';
    }
    if (!in_array('btn', $variables['attributes']['class'])) {
      $variables['attributes']['class'][] = 'btn';
    }

    if (empty(array_intersect([
      'btn-primary',
      'btn-primary-lighter',
      'btn-secondary',
      'btn-success',
      'btn-warning',
      'btn-danger',
      'btn-link',
      'btn-info',
    ], $variables['attributes']['class']))) {
      $variables['attributes']['class'][] = 'btn-secondary';
    }
  }
}

/**
 * Implements hook_preprocess_HOOK() for block templates.
 */
function ixm_preprocess_block(array &$variables): void {
  if (isset($variables['elements']['#id'])) {
    $region = Block::load($variables['elements']['#id'])->getRegion();
    if (!empty($region)) {
      $variables['content']['#attributes']['data-block']['region'] = $region;
    }
  }
}
