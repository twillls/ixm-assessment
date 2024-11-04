<?php

/**
 * @file
 * Theme hook suggestions implementations.
 */

/**
 * Implements hook_theme_suggestions_menu_alter().
 */
function ixm_theme_suggestions_menu_alter(array &$suggestions, array $variables): void {
  if (isset($variables['attributes']['data-block']['region'])) {
    $region = $variables['attributes']['data-block']['region'];
    $suggestions[] = $variables['theme_hook_original'] . '__' . $region;
    $suggestions[] = 'menu__' . $region;
  }
}

/**
 * Implements hook_theme_suggestions_page_alter().
 */
function ixm_theme_suggestions_page_alter(array &$suggestions, array $variables): void {
  $routeMatch = \Drupal::routeMatch();

  // Add node bundle type suggestions (view/edit pages).
  if (($node = $routeMatch->getParameter('node')) ||
    ($node = $routeMatch->getParameter('node_preview'))) {
    array_splice($suggestions, 1, 0, 'page__bundle__' . $node->getType());
  }

  // Default "Manage Layout" display, discard changes pages.
  if ($type = $routeMatch->getParameter('node_type')) {
    array_splice($suggestions, 1, 0, 'page__bundle__' . $type);
  }
}
