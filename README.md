<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="web/images/logo.png" height="100px">
    </a>
    <h1 align="center">
        The music review system with user experience at it's centre stage
    </h1>
    <br>
</p>

[Limelight](http://www.limelight.uogs.co.uk) is a review application that changes the mould by being able to leave reviews for Artists and Venues separately. This allows for more detailed reviews, combined with our machine learning systems Limelight sets out to create the best experience for regular users.

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      components/         contains logic related to APIs
      config/             contains application configurations
      controllers/        contains Web controller classes
      core/               contains inherited files from Yii
      helpers/            contains basic function helper classes
      mail/               contains view files for e-mails
      migrations/         contains incremental database update files
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources
      widgets/            contains custom made widgets


## Prerequisites
------------

To use this application in a development environment there are a few pieces of software that you must have installed first, these are:
1. **Vagrant:** Configuration software for running and maintaining a local development environment. This will be used to communicate with your virtual machine
2. **Composer:** PHP dependency manager, this will be used to download all of the assets from `composer.json`
3. **npm/yarn:** JavaScript package manager, this will be used to download all of the JS dependencies

## Rough installation guide
This is a simple guide to get up and running with Limelight in a development environment.

1. Clone the repository down from GitHub - https://github.com/uniglos/advanced-group-project-limelight
2. `Vagrant up` in the console
3. `Vagrant ssh` in the console
4. `cd /vagrant` in the console
5. `composer install` & `yarn` or `npm` `install`
6. `php yii migrate` in the console
6. The site should be up and running, some reasons for it not working would be setting the document root or database problems
7. You can install test data by typing `php yii fixture/load "*"` in the console

## Running the Limelight test suite

```
# run all available tests
vendor/bin/codecept run

# run acceptance tests
vendor/bin/codecept run acceptance

# run only unit and functional tests
vendor/bin/codecept run unit, functional
```
