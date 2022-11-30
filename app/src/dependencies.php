<?php

use Slim\Views\PhpRenderer;

/**
 * @var $app \Slim\App
 */
$container = $app->getContainer();

// Register PHP View helper
$container['phpview'] = function ($c) {
    $settings = $c->get('settings')['phpview'];
    return new PhpRenderer  ($settings['template_path']);
};

// Monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\RotatingFileHandler($settings['path'], $settings['maxFiles'], $settings['level']));
    return $logger;
};

$container['notFoundHandler'] = function ($app) {
    return function ($request, $response) use ($app) {
        return $app->phpview->render($response, '/404/index.php', []);
    };
};