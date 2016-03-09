<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

/**
 * Copyright 2016 Andrew O'Rourke
 */

define('ROOT_DIR', $_SERVER['DOCUMENT_ROOT']);

require 'vendor/autoload.php';

if(preg_match('/^git\/.*$/', $_SERVER['HTTP_USER_AGENT'])) { //Git client
    Flight::route('/git/*', function($route) {
        $git = new \Trident\GitCgi('/' . $route->splat);
        $git->handleCgi();
    }, true);
} else { //Web browser
    Flight::route('(/)/rest/api/1.0/projects', ['\\Trident\\Api\\Repo', 'getProjects']);
    Flight::route('(/)/rest/api/1.0/projects/PROJ/repos', ['\\Trident\\Api\\Repo', 'getProjectRepos']);
    Flight::route('(/)/rest/api/1.0/users/@user/repos', ['\\Trident\\Api\\Repo', 'getUserRepos']);
    Flight::route('/', function() {
        if(!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER'] != 'andrew') {
            header('WWW-Authenticate: Basic realm="My Realm"');
            Flight::app()->stop(401);
        } else {
            require(ROOT_DIR . '/src/views/index.phtml');
        }
    });
}

Flight::start();
