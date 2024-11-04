<?php

/**
 * @file
 * Alter hook implementations.
 */

/**
 * Implements hook_library_info_alter().
 */
function ixm_library_info_alter(&$libraries, $extension): void {
  // Removes component source js from libs.
  if ($extension === 'cl_components') {
    foreach ($libraries as $key => $library) {
      if (isset($library['js'])) {
        foreach ($library['js'] as $path => $options) {
          if (strpos($path, 'assets/js') !== FALSE) {
            unset($libraries[$key]['js'][$path]);
          }
        }
      }
    }
  }
}
