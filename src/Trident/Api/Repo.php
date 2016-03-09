<?php
/**
 * Copyright 2016 Andrew O'Rourke
 */

namespace Trident\Api;


class Repo
{
    static public function getProjects()
    {
        header('Content-Type:application/json;charset=UTF-8');
        require(ROOT_DIR . 'src/views/api/list_projects.json.php');
    }

    static public function getProjectRepos()
    {
        header('Content-Type:application/json;charset=UTF-8');
        require(ROOT_DIR . 'src/views/api/list_project_repos.json.php');
    }

    static public function getUserRepos()
    {
        header('Content-Type:application/json;charset=UTF-8');
        require(ROOT_DIR . 'src/views/api/list_user_repos.json.php');
    }
}