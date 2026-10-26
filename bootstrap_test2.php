<?php
require 'vendor/autoload.php';
use Illuminate\Foundation\Application;

$app = new Application(__DIR__);
$app->instance('config', new Illuminate\Config\Repository());
$app->instance('request', Illuminate\Http\Request::create('/', 'GET', [], [], [], array('HTTP_HOST' => 'localhost')));
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$app->bootstrapWith(array(
    Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables::class,
    Illuminate\Foundation\Bootstrap\RegisterProviders::class,
    Illuminate\Foundation\Bootstrap\BootProviders::class,
));
echo 'bootstrap done';