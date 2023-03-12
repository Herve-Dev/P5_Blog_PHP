<?php

use App\Core\Main;
use Dotenv\Dotenv;

// On definit une constante contenant le dossier racine du projet
define('ROOT', dirname(__DIR__));

require_once '../vendor/autoload.php';

$dotenv = Dotenv::createUnsafeImmutable(ROOT, '.env');
$dotenv->load();

//On instancie Main (notre routeur) 
$app = new Main;

//On démarre l'application
$app->start();