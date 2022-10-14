# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]
### Added
- add coverage for Drupal 9.3, 9.4 & 9.5
- add upgrade-status check

### Changed
- update changelog form to follow keep-a-changelog format
- disable deprecation notice PHPUnit
- drop support of drupal 8.8 & 8.9

### Fixed
- fix phpcs null coalesce operator instead of ternary operator
- fixed docker test on CI race-condition database note ready

### Removed
- remove satackey/action-docker-layer-caching on Github Actions
- remove trigger github actions on every pull-request, keep only push

## [2.1.0] - 2021-08-13
### Fixed
- fix Issue #3168259 by wengerk, Aerzas: Excluded sensitive e-mails are not sent

## [2.0.0] - (2020-06-28)
### Added
- add travis integration
- add styleci integration
- replace drupal_ti by wengerk/drupal-for-contrib

### Fixed
- fix email authors - Main Support
- fix Issue #3035541 by chipway: Wrong Dependency prefix in .info.yml
- fix Issue #3038518 by wengerk: \[8.6.x] - Cleanup deprecation notice
- fix Issue #3044923 by wengerk: Composer require failure - Drupal 8.7.x+
- fix Issue #3079686: Add support to reroute Cc and Bcc headers
- fix Issue #3090759: fix Travis tests and Mailsystem - deprecation notices
- fix Issue #3090766: Drupal 9 Readiness

## [1.3.0] - (2018-02-09)
### Added
- add custom HEADER to store original recipient when rerouted

### Fixed
- fix #2938562 - First install throw error `Route "backerymails.settings" does not exist.`
- fix #2925147 by gido, Nachini, wengerk: I cannot "Delete all"
- fix typo 'sended' -> 'sent'
- fix issue that prevent sensitives mails to be rerouted

## [1.2.0] - (2017-01-11)
### Added
- add BrowserTest
- add Configuration Schema file

### Fixed
- fix the install issue (missing URL)

## [1.1.0] - (2017-03-10)
### Added
- customs module.key exclusions
- entity action to clear all entries

## [1.0.0] - (2017-03-10)
### Added
- release

[Unreleased]: https://github.com/antistatique/drupal-backerymails/compare/8.x-2.1...HEAD
[2.1.0]: https://github.com/antistatique/drupal-backerymails/compare/8.x-2.0...8.x-2.1
[2.0.0]: https://github.com/antistatique/drupal-backerymails/compare/8.x-1.3...8.x-2.0
[1.3.0]: https://github.com/antistatique/drupal-backerymails/compare/8.x-1.2...8.x-1.3
[1.2.0]: https://github.com/antistatique/drupal-backerymails/compare/8.x-1.1...8.x-1.2
[1.1.0]: https://github.com/antistatique/drupal-backerymails/compare/8.x-1.0...8.x-1.1
[1.0.0]: https://github.com/antistatique/drupal-backerymails/releases/tag/8.x-1.0
