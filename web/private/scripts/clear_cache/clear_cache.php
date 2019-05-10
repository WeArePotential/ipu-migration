<?php

/**
 * Clears the Drupal cache.
 */

$config_file = '';

if (!defined('PANTHEON_ENVIRONMENT')) {
  return;
}

switch(PANTHEON_ENVIRONMENT) {
  case 'live':
    $config_file = dirname(__FILE__) . '/config/' . PANTHEON_ENVIRONMENT . '/config.inc';
    break;
  case 'test':
    $config_file = dirname(__FILE__) . '/config/' . PANTHEON_ENVIRONMENT . '/config.inc';
    break;
  case 'dev':
    $config_file = dirname(__FILE__) . '/config/' . PANTHEON_ENVIRONMENT . '/config.inc';
    break;
  default:
    //This will be multidev instances.
    $config_file = dirname(__FILE__) . '/config/multidev/config.inc';
    break;
}

// Get config settings as $config.
if (!empty($config_file)) {
  include $config_file;
}

// Finish if there are no config settings.
if (empty($clear_cache)) {
  return;
}

passthru('drush cache-rebuild');
echo('Cache cleared' . "\n");



