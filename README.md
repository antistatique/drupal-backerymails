# BACKERYMAILS

Save every going out mails.

|       Travis-CI        |        Style-CI         |        Downloads        |         Releases         |
|:----------------------:|:-----------------------:|:-----------------------:|:------------------------:|
| [![Build Status](https://github.com/antistatique/drupal-backerymails/actions/workflows/ci.yml/badge.svg)](https://github.com/antistatique/drupal-backerymails/actions/workflows/ci.yml) | [![Code styles](https://github.com/antistatique/drupal-backerymails/actions/workflows/styles.yml/badge.svg)](https://github.com/antistatique/drupal-backerymails/actions/workflows/styles.yml) | [![Downloads](https://img.shields.io/badge/downloads-8.x--1.x-green.svg?style=flat-square)](https://ftp.drupal.org/files/projects/backerymails-8.x-1.x-dev.tar.gz) | [![Latest Stable Version](https://img.shields.io/badge/release-v1.3.x--dev-blue.svg?style=flat-square)](https://www.drupal.org/project/backerymails/releases) |

Backerymails is awesome because it merges every must-have features about mails such as :

- Save every going out mails using the MailManagerInterface & provides a user interface to retrieve them
- Can intercepts all going out mails and reroutes them to some configurable email(s) address(es)
- Keep original recipient(s) into headers when rerouting
- Additionally you can immediately display the mail through devel dpm()

## You need Backerymails if

- You send mails using the default Drupal 8 integration - MailManagerInterface.
- You want to keep a trace of sent mails.
- You want to reroutes every going out mails for developments purpose.
- You need to test the mail functionality of other modules or the drupal core.
- You create statistics about sent mails.
- Your need to keed a backup of every sent mails to prevent any troubles with providers or sending methodology.
- You want to customize the backup/logging page using [Views](https://www.drupal.org/project/views).

Backerymails can do a lot more than that, but those are some of the obvious uses of Backerymails.

## Backerymails versions

The version `8.x-1.x` is not compatible with Drupal `8.8.x`.
Drupal `8.8.x` brings some breaking change with tests and so you
must upgrade to `8.x-2.x` version of **Backerymails**.

The version `8.x-3.x` is not compatible with Drupal `8.x` and will only support Drupal `9.x` Drupal `10.x`.

## Which version should I use?

|Drupal Core| Backerymails |
|:---------:|:------------:|
|8.7.x      |     1.x      |
|8.8.x      |     2.x      |
|9.x        |  2.x - 3.x   |

## Dependencies

The Drupal 8 & Drupal 9 version of Backerymails requires [Views](https://www.drupal.org/project/views) and [Mail System](https://www.drupal.org/project/mailsystem).

## Similar modules

- Redirection of mails only with [Reroute Email](https://www.drupal.org/project/reroute_email)
- Advanced redirection of mails only with [Advanced Mail Reroute](https://www.drupal.org/project/advanced_mail_reroute)
- Redirection of domain mail only with [Mail Redirect](https://www.drupal.org/project/mail_redirect)
- Logging or pure development with [Maillog/ Mail Developer](https://www.drupal.org/project/maillog)
- Pure logging is also done by [Mail Logger](https://www.drupal.org/project/mail_logger)

## Supporting organizations

This project is sponsored by Antistatique. We are a Swiss Web Agency,
Visit us at [www.antistatique.net](https://www.antistatique.net) or Contact us.
