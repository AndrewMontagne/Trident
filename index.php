<?php
require 'vendor/autoload.php';

Flight::route('/', function() {
    require($_SERVER['DOCUMENT_ROOT'] . '/src/views/index.phtml');
});

Flight::start();