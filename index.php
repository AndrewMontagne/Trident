<?php
require 'vendor/autoload.php';


if(preg_match('/^git\/\d+\.\d+\.\d+$/', $_SERVER['HTTP_USER_AGENT'])) { //Git client
    Flight::route('/git/*', function($route) {
        $git = new \Trident\GitCgi($route->splat);
        $git->handleCgi();
    }, true);
} else { //Web browser
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    Flight::route('/', function() {
        require(ROOT_DIR . '/src/views/index.phtml');
    });
}

define('ROOT_DIR', $_SERVER['DOCUMENT_ROOT']);

Flight::start();
