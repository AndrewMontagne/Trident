<?php
/**
 * Copyright 2016 Andrew O'Rourke
 */

require 'vendor/autoload.php';

if(preg_match('/^git\/.*$/', $_SERVER['HTTP_USER_AGENT'])) { //Git client
    Flight::route('/git/*', function($route) {
        $git = new \Trident\GitCgi('/' . $route->splat);
        $git->handleCgi();
    }, true);
} else { //Web browser
    Flight::route('(/)/rest/api/1.0/projects', function() {
        header('Content-Type:application/json;charset=UTF-8');
        echo '{"isLastPage":true,"values":[{"key":"PROJ","id":1,"name":"Project","description":"Project Time","public":false,"type":"NORMAL","links":{"self":[{"href":"http://localhost:7990/projects/PROJ"}]}}],"start":0}';
    });
    Flight::route('(/)/rest/api/1.0/projects/PROJ/repos', function() {
        header('Content-Type:application/json;charset=UTF-8');
        echo '{"isLastPage":true,"values":[{"name":"PROJECT REPO","public": false,"links": {"clone":[{"href": "http://andrew@localhost:7990/scm/proj/test-repo.git","name": "http"}]}}]}';
    });
    Flight::route('(/)/rest/api/1.0/users/@user/repos', function($user) {
        header('Content-Type:application/json;charset=UTF-8');
        echo '{"isLastPage":true,"values":[{"slug":"repo","id":2,"name":"repo","scmId":"git","state":"AVAILABLE","statusMessage":"Available","forkable":true,"project":{"key":"~ANDREW","id":2,"name":"andrew","type":"PERSONAL","owner":{"name":"andrew","emailAddress":"andrewmontagne@gmail.com","id":1,"displayName":"andrew","active":true,"slug":"andrew","type":"NORMAL","links":{"self":[{"href":"http://localhost:7990/users/andrew"}]}},"links":{"self":[{"href":"http://localhost:7990/users/andrew"}]}},"public":false,"links":{"clone":[{"href":"http://andrew@localhost:7990/scm/~andrew/repo.git","name":"http"}],"self":[{"href":"http://localhost:7990/users/andrew/repos/repo/browse"}]}}],"start":0}';
    });
    Flight::route('/', function() {
        if(!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER'] != 'andrew') {
            header('WWW-Authenticate: Basic realm="My Realm"');
            Flight::app()->stop(401);
        } else {
            require(ROOT_DIR . '/src/views/index.phtml');
        }
    });
}

define('ROOT_DIR', $_SERVER['DOCUMENT_ROOT']);

Flight::start();
