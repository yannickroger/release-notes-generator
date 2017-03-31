# Release note generator

This is a tool to help generating the list of dependencies of a composer based project.

## Install
Have [Composer](https://getcomposer.org/) installed.

```
composer install
```


## Usage
```
php bin/release-notes-generator.php composer-1.8.0.lock composer-1.8.1-rc.lock
```


## Run tests
```
./bin/phpspec run
```
