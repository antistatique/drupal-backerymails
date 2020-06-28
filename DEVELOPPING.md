# Developing on BACKERYMAILS

* Issues should be filed at
https://www.drupal.org/project/backerymails
* Pull requests can be made against
https://github.com/antistatique/drupal-backerymails/pulls

## 📦 Repositories

Drupal repo
  ```
  git remote add drupal git@git.drupal.org:project/backerymails.git
  ```

Github repo
  ```
  git remote add github https://github.com/antistatique/drupal-backerymails.git
  ```

## 🔧 Prerequisites

First of all, you need to have the following tools installed globally
on your environment:

  * drush
  * Latest dev release of Drupal 8.x.
  * docker
  * docker-compose

### Project bootstrap

Once run, you will be able to access to your fresh installed Drupal on `localhost::8888`.

    docker-compose build --pull --build-arg BASE_IMAGE_TAG=8.9 drupal
    (get a coffee, this will take some time...)
    docker-compose up -d drupal
    docker-compose exec -u www-data drupal drush site-install standard --db-url="mysql://drupal:drupal@db/drupal" --site-name=Example -y
    
    # You may be interesed by reseting the admin passowrd of your Docker and install the module using those cmd.
    docker-compose exec drupal drush user:password admin admin
    docker-compose exec drupal drush en backerymails

## 🏆 Tests

We use the [Docker for Drupal Contrib images](https://hub.docker.com/r/wengerk/drupal-for-contrib) to run testing on our project.

Run testing by stopping at first failure using the following command:

    docker-compose exec -u www-data drupal phpunit --group=backerymails --no-coverage --stop-on-failure

### Command Line Usage

Check Drupal coding standards:

  ```bash
  ./vendor/bin/phpcs --standard=Drupal --colors \
  --extensions=php,module,inc,install,test,profile,theme,css,info,md \
  --ignore=*/vendor/*,*/node_modules/* ./
  ```

Check Drupal best practices:

  ```bash
  ./vendor/bin/phpcs --standard=DrupalPractice --colors \
  --extensions=php,module,inc,install,test,profile,theme,css,info,md \
  --ignore=*/vendor/*,*/node_modules/* ./
  ```

Automatically fix coding standards

  ```bash
  ./vendor/bin/phpcbf --standard=Drupal --colors \
  --extensions=php,module,inc,install,test,profile,theme,css,info \
  --ignore=*/vendor/*,*/node_modules/* ./
  ```

### Improve global code quality using PHPCPD & PHPMD

Add requirements if necessary using `composer`:

  ```bash
  composer require --dev 'phpmd/phpmd:^2.6' 'sebastian/phpcpd:^3.0'
  ```

Detect overcomplicated expressions & Unused parameters, methods, properties

  ```bash
  ./vendor/bin/phpmd ./web/modules/custom text ./phpmd.xml
  ```

Copy/Paste Detector

  ```bash
  ./vendor/bin/phpcpd ./web/modules/custom
  ```

### Enforce code standards with git hooks

Maintaining code quality by adding the custom post-commit hook to yours.

  ```bash
  cat ./scripts/hooks/post-commit >> ./.git/hooks/post-commit
  ```
