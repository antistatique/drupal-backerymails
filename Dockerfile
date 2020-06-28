ARG BASE_IMAGE_TAG=8.9
FROM wengerk/drupal-for-contrib:${BASE_IMAGE_TAG}

ENV COMPOSER_MEMORY_LIMIT=-1

RUN composer require drupal/mailsystem:~4.3
