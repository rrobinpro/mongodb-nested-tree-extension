# Doctrine MongoDB Nested Tree Extension

## About

This package contains Doctrine MongoDB Nested set Strategy extension for [DoctrineExtensions](https://github.com/Atlantic18/DoctrineExtensions/blob/v2.4.x/doc/tree.md).

## 1. Installation

Add the `alitvinenko/mongodb-nested-tree-extension` package to your `require` section in the `composer.json` file.

``` bash
$ composer require alitvinenko/mongodb-nested-tree-extension
```

## 2. Configuration

### 2.1. Configuration StofDoctrineExtensionsBundle

Configure [StofDoctrineExtensionsBundle](http://symfony.com/doc/current/bundles/StofDoctrineExtensionsBundle/index.html).

### 2.2. Set overriding Listener for Tree extension

``` yaml
# app/config/config.yml

...
stof_doctrine_extensions:
    mongodb:
        default:
            tree: true # enable tree extension
    class:
        tree: NestedTreeExtension\Listener\TreeListener # and set listener
...
```