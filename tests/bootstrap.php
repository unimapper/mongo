<?php

$loader = @include __DIR__ . '/../vendor/autoload.php';
if (!$loader) {
    echo 'Install Nette Tester using `composer update --dev`';
    exit(1);
}

// @todo
//$loader->addPsr4("UniMapper\Tests\Fixtures\\", __DIR__ . "/fixtures");

require __DIR__ . "/fixtures/Entity.php";

Tester\Environment::setup();

date_default_timezone_set('Europe/Prague');