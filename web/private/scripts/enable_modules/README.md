# Enable Modules #

This script enables Drupal modules.

## Instructions ##

- Copy the `enable_modules` directory into the private/scripts directory of your code repository.
- Add a Quicksilver operation to your pantheon.yml to fire the script.
- Add a config.inc file to the directory of the environment modules should be enabled on.
  E.g. private/scripts/enable_modules/config/dev/config.inc
- In the config.inc file(s) set what modules should be enabled. Example:

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
        description: Enable modules
        script: private/scripts/enable_modules/enable_modules.php
```
