<?php

use Dotenv\Dotenv;

require_once '../vendor/autoload.php';

$dotenv = Dotenv::createUnsafeImmutable(__DIR__, '../.env');
$dotenv->load();

