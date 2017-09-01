# Release note generator

This is a tool to help generating the list of dependencies of a composer based project.

## Install
Have [Composer](https://getcomposer.org/) installed.

```
composer install
```

## Usage

### With default template
```
php bin/generate composer-1.8.0.lock composer-1.8.1-rc.lock
```

### Specifying a template
#### Available templates
- `standard` the default one
- `ez`

```
php bin/generate composer-1.8.0.lock composer-1.8.1-rc.lock ez
```

## Run tests
```
./bin/phpspec run
```
