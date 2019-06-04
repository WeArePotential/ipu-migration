<?php

/**
 * Load services definition file.
 */
$settings['container_yamls'][] = __DIR__ . '/services.yml';

/**
 * Include the Pantheon-specific settings file.
 *
 * n.b. The settings.pantheon.php file makes some changes
 *      that affect all envrionments that this site
 *      exists in.  Always include this file, even in
 *      a local development environment, to insure that
 *      the site settings remain consistent.
 */
include __DIR__ . "/settings.pantheon.php";

// Config directory outside of the webroot.
$config_directories = [
    CONFIG_SYNC_DIRECTORY => dirname(DRUPAL_ROOT) . '/config/sync',
];

// Use development config in dev environments.
if ( isset($_ENV['PANTHEON_ENVIRONMENT']) ) {
    switch ($_ENV['PANTHEON_ENVIRONMENT']) {
        case 'live':
        case 'test':
            $config['config_split.config_split.config_dev']['status'] = FALSE;
            break;
        case 'dev':
            $config['config_split.config_split.config_dev']['status'] = TRUE;
    }
} else {
    $config['config_split.config_split.config_dev']['status'] = TRUE;
}
$config['config_split.config_split.config_dev']['status'] = FALSE;

$settings['hash_salt'] = '2vJjs9vhxIaCGZu8QEqDeKpdc53kEMojdReSKTNs0ttIp7IRAlpcTZgr1B1OPxDLdtbZHDcKSE';

// Configure Redis

if (defined('PANTHEON_ENVIRONMENT')) {
    // Include the Redis services.yml file. Adjust the path if you installed to a contrib or other subdirectory.
    $settings['container_yamls'][] = 'web/modules/contrib/redis/example.services.yml';

    //phpredis is built into the Pantheon application container.
    $settings['redis.connection']['interface'] = 'PhpRedis';
    // These are dynamic variables handled by Pantheon.
    $settings['redis.connection']['host']      = $_ENV['CACHE_HOST'];
    $settings['redis.connection']['port']      = $_ENV['CACHE_PORT'];
    $settings['redis.connection']['password']  = $_ENV['CACHE_PASSWORD'];

    $settings['cache']['default'] = 'cache.backend.redis'; // Use Redis as the default cache.
    $settings['cache_prefix']['default'] = 'pantheon-redis';

    // Set Redis to not get the cache_form (no performance difference).
    $settings['cache']['bins']['form']      = 'cache.backend.database';
}

/* Added by Rod Tatham, Sereno :: 11 Apr 2019. Needed for migration from D7 */
$settings['file_private_path'] = __DIR__ . '/files/private';

  /**
 * If there is a local settings file, then include it
 */
$local_settings = __DIR__ . "/settings.local.php";
if (file_exists($local_settings)) {
  include $local_settings;
}
