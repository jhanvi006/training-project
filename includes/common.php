<?php
// session start
session_start();

// include config file
require_once __DIR__ . '/config.php';

// include DB class
require_once __DIR__ . '/database.php';

// include Twig class
require_once __DIR__ . '/../vendor/autoload.php';
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../views');
$twig = new \Twig\Environment($loader, [
    'debug' => true,
]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

// include any other common classes as needed
