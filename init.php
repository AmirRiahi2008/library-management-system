<?php
include __DIR__ . "/vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
include __DIR__ . "/helper.php";
include __DIR__ . "/db.php";
