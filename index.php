<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

/**
 * Copyright 2016 Andrew O'Rourke
 */

require 'vendor/autoload.php';

define('ROOT_DIR', $_SERVER['DOCUMENT_ROOT']);

Flight::set('flight.views.path', ROOT_DIR . 'src/views');

if(preg_match('/^git\/.*$/', $_SERVER['HTTP_USER_AGENT'])) { //Git client
    Flight::route('/git/*', function($route) {
        $git = new \Trident\GitCgi('/' . $route->splat);
        $git->handleCgi();
    }, true);
} else { //Web browser
    Flight::route('(/)/rest/api/1.0/projects', ['\\Trident\\Api\\Repo', 'getProjects']);
    Flight::route('(/)/rest/api/1.0/projects/PROJ/repos', ['\\Trident\\Api\\Repo', 'getProjectRepos']);
    Flight::route('(/)/rest/api/1.0/users/@user/repos', ['\\Trident\\Api\\Repo', 'getUserRepos']);
    Flight::route('/', ['\\Trident\\Front\\Index', 'indexAction']);
}

Flight::start();
