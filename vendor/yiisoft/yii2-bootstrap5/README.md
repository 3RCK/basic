<p align="center">
    <a href="https://getbootstrap.com/" target="_blank" rel="external">
        <img src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo.svg" height="80px">
    </a>
    <h1 align="center">Twitter Bootstrap 5 Extension for Yii 2</h1>
    <br>
</p>

This is the Twitter Bootstrap extension for [Yii framework 2.0](https://www.yiiframework.com). It encapsulates [Bootstrap 5](https://getbootstrap.com/) components
and plugins in terms of Yii widgets, and thus makes using Bootstrap components/plugins
in Yii applications extremely easy.

For license information check the [LICENSE](LICENSE.md)-file.

Documentation is at [docs/guide/README.md](docs/guide/README.md).

[![Latest Stable Version](https://poser.pugx.org/yiisoft/yii2-bootstrap5/v/stable.png)](https://packagist.org/packages/yiisoft/yii2-bootstrap5)
[![Total Downloads](https://poser.pugx.org/yiisoft/yii2-bootstrap5/downloads.png)](https://packagist.org/packages/yiisoft/yii2-bootstrap5)
[![Build Status](https://github.com/yiisoft/yii2-bootstrap5/workflows/build/badge.svg)](https://github.com/yiisoft/yii2-bootstrap5/actions/workflows/build.yml)
[![ECS Status](https://github.com/yiisoft/yii2-bootstrap5/workflows/ecs/badge.svg)](https://github.com/yiisoft/yii2-bootstrap5/actions/workflows/ecs.yml)


Installation
------------

The preferred way to install this extension is through [composer](https://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yiisoft/yii2-bootstrap5
```

or add

```
"yiisoft/yii2-bootstrap5": "*"
```

to the require section of your `composer.json` file.

Translations
----

The i18n configuration will be automatically added to your application configuration via bootstrapping process.

Usage
----

For example, the following
single line of code in a view file would render a Bootstrap Progress plugin:

```php
<?= yii\bootstrap5\Progress::widget(['percent' => 60, 'label' => 'test']) ?>
```
