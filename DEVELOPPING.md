# Developing on BACKERYMAILS

* Issues should be filed at
https://www.drupal.org/project/backerymails
* Pull requests can be made against
https://github.com/antistatique/drupal-backerymails/pulls

## 🔧 Prerequisites

First of all, you need to have the following tools installed globally on your environment:

  * composer
  * drush
  * Latest dev release of Drupal 8.x.

## 🏆 Tests

  Template Whisperer use BrowserTestBase to test
  web-based behaviors and interactions.

  ```bash
    $ ../vendor/bin/phpunit --group backerymails_ui
  ```

## 🚔 Check Drupal coding standards & Drupal best practices

You need to run composer before using PHPCS. Then register the Drupal and DrupalPractice Standard with PHPCS: `./vendor/bin/phpcs --config-set installed_paths [absolute-path-to-vendor]/drupal/coder/coder_sniffer`

### Command Line Usage

Check Drupal coding standards:

  ```
  $ ./vendor/bin/phpcs --standard=Drupal --colors --extensions=php,module,inc,install,test,profile,theme,css,info ./
  ```

Check Drupal best practices:

  ```
  $ ./vendor/bin/phpcs --standard=DrupalPractice --colors --extensions=php,module,inc,install,test,profile,theme,css,info ./
  ```

### Enforce code standards with git hooks

Maintaining code quality by adding the custom post-commit hook to yours.

  ```
  $ cat ./scripts/hooks/post-commit >> ./.git/hooks/post-commit
  ```
