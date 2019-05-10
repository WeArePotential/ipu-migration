# Clear Cache #

This script clears the Drupal cache.

## Instructions ##

- Copy the `clear_cache` directory into the private/scripts directory of your code repository.
- Add a Quicksilver operation to your pantheon.yml to fire the script.
- Add a config.inc file to the directory of the environment to clear the cache on.
  E.g. private/scripts/clear_cache/config/live/config.inc
- In the config.inc file(s) set the cache to be cleared. Example:

  <?php

  $clear_cache = TRUE;

### Example `pantheon.yml` ###

Here's an example of what your `pantheon.yml` would look like if this were the only Quicksilver operation you wanted to use:

```yaml
api_version: 1

workflows:
  clone_database:
    after:
      - type: webphp
        description: Clear cache
        script: private/scripts/clear_cache/clear_cache.php
```
