<?php

/**
 * Enable modules.
 */

$config_file = '';
$config = array();

// Get lists of enabled modules.
$module_list = shell_exec("drush pm-list --type=module --status=enabled --pipe 2>&1");
$enabled_modules = explode("\n", $module_list);

if (defined('PANTHEON_ENVIRONMENT')) {

  switch(PANTHEON_ENVIRONMENT) {
    case 'live':
    case 'test':
    case 'dev':
      $config_file = dirname(__FILE__) . '/config/' . PANTHEON_ENVIRONMENT . '/config.inc';
      break;
    default:
      //This will be multidev instances - use dev settings.
      $config_file = dirname(__FILE__) . '/config/multidev/config.inc';
      break;
  }
}

// Get config settings as $config.
if (!empty($config_file)) {
  include $config_file;
}

// Finish if there are no config settings.
if (empty($config)) {
  return;
}

// Enable modules.
$report = array();

foreach($config as $module) {

  if (!in_array($module, $enabled_modules)) {
    passthru("drush pm-enable -y $module");
    $report[] = $module;
  }
}

echo('Enabled modules: ' . implode(', ', $report) . "\n");

