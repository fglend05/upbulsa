<?php

spl_autoload_register(function ($classname) {
    require $filename = "../app/models/" . ucfirst($classname) . ".php";
});

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET,');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Check if it's a preflight OPTIONS request (sent by browsers before some CORS requests)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Respond to the preflight request with a 200 OK status
    header('HTTP/1.1 200 OK');
    exit();
}


require 'config.php';
require 'Controller.php';
require 'Database.php';
require 'functions.php';
require 'Model.php';
require 'App.php';
