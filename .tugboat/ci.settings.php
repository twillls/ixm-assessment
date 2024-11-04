<?php
// phpcs:ignoreFile
/**
 * @file
 * Tugboat CI settings.
 */

// DB.
$databases['default']['default'] = [
  'database' => 'tugboat',
  'username' => 'tugboat',
  'password' => 'tugboat',
  'prefix' => '',
  'host' => 'mysql',
  'port' => '3306',
  'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
  'driver' => 'mysql',
];

// Drush memory issues.
if (PHP_SAPI === 'cli') {
  ini_set('memory_limit', '-1');
}

// Use the TUGBOAT_REPO_ID to generate a hash salt for Tugboat sites.
$settings['hash_salt'] = hash('sha256', getenv('TUGBOAT_REPO_ID'));

// Configure Error messages to display.
$config['system.logging']['error_level'] = 'verbose';

// files.
$settings['file_private_path'] = "/var/lib/tugboat/docroot/sites/default/files-private";
$config['system.file']['path']['temporary'] = '/tmp';

// Config split to dev.
$config['config_split.config_split.dev']['status'] = TRUE;

// Set stage_file_proxy origin if you're using it.
// $config['stage_file_proxy.settings']['origin'] = 'https://www.example.org/';

// Enable sheield and set an password.
// $config['shield.settings']['shield_enable'] = TRUE;
// $config['shield.settings']['credentials']['shield']['user'] = 'example';
// $config['shield.settings']['credentials']['shield']['pass'] = 'example';

// Disable Shield for visual diffs/tests.
if (getenv('TUGBOAT_TOKEN') && preg_match('/(headlesschrome|chrome-lighthouse|electron)/i', $_SERVER['HTTP_USER_AGENT'])) {
  $config['shield.settings']['shield_enable'] = FALSE;
}

// Ensure tugboat is in the trusted_host_patterns.
$settings['trusted_host_patterns'][] = '^.+\.tugboatqa\.com$';

// Override the solr server host. replace {server_name} with your server name.
//$config['search_api.server.{server_name}']['backend_config']['connector_config']['host'] = 'solr';
//$config['search_api.server.{server_name}']['backend_config']['connector_config']['core'] = 'drupal';

