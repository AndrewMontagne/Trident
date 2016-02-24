<?php
require 'vendor/autoload.php';

if(preg_match('/^git\/\d+\.\d+\.\d+$/', $_SERVER['HTTP_USER_AGENT'])) { //Git client
    Flight::route('/git/@repo/', function($repo) {
        $git = new \Trident\GitCgi($repo);
        $git->handle();
    });
} else { //Web browser
    Flight::route('/', function() {
        require($_SERVER['DOCUMENT_ROOT'] . '/src/views/index.phtml');
    });
}
Flight::start();