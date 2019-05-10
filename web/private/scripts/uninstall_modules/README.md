# Uninstall Modules #

This script uninstalls Drupal modules.

## Instructions ##

- Copy the `uninstall_modules` directory into the private/scripts directory of your code repository.
- Add a Quicksilver operation to your pantheon.yml to fire the script.
- Add a config.inc file to the directory of the environment modules should be uninstalled from.
  E.g. private/scripts/unistall_modules/config/live/config.inc
- In the config.inc file(s) set what modules should be uninstalled. Example:

  <?php

  $config = array(
    'devel',
    'kint'
  );

### Example `pantheon.yml` ###

Here's an example of what your `pantheon.yml` would look like if this were the only Quicksilver operation you wanted to use:

api_version: 1

workflows:
  clone_database:
    after:
      - type: webphp
        description: Uninstall modules
        script: private/scripts/uninstall_modules/uninstall_modules.php
```
