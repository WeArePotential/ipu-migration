<?php

/**
 * Configure modules.
 * We are going to import from config_dev when we're in dev or local
 */
$config_directory = '';
if (defined('PANTHEON_ENVIRONMENT')) {

    switch (PANTHEON_ENVIRONMENT) {
        case 'live':
        case 'test':
            $config_directory = 'sites/default/config';
        case 'dev':
            $config_directory = 'sites/default/config_dev';
    }
} else {
    $config_directory = 'sites/default/config_dev';
}

/*
 if (defined('PANTHEON_ENVIRONMENT')) {

  switch(PANTHEON_ENVIRONMENT) {
    case 'live':
    case 'test':
    case 'dev':
      $config_directory = dirname(__FILE__) . '/config/' . PANTHEON_ENVIRONMENT;
      break;
    default:
      //This will be multidev instances - use dev settings
      $config_file = dirname(__FILE__) . '/config/multidev/config.inc';
      break;
  }
}
*/


if (!empty($config_directory)) {
  passthru("drush cim --partial --source=$config_directory --yes");
    //passthru('drush cset "system.site" uuid "e68855ce-257f-41af-9a61-51f6fc1116ef"');
    //passthru('drush cim  --yes');
}

// Confirmation for Terminus.
echo('Configuration imported.' . "\n");
