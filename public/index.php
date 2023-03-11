<?php

use Dotenv\Dotenv;

// On definit une constante contenant le dossier racine du projet
define('ROOT', dirname(__DIR__));

require_once '../vendor/autoload.php';

$dotenv = Dotenv::createUnsafeImmutable(ROOT, '.env');
$dotenv->load();

