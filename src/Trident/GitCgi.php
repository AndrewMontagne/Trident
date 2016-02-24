<?php
/**
 * Created by IntelliJ IDEA.
 * User: Andrew
 * Date: 24/02/2016
 * Time: 23:11
 */

namespace Trident;


class GitCgi
{
    /**
     * @var string
     */
    private $repoName;

    /**
     * GitCgi constructor.
     * @param string $repo
     */
    public function __construct($repo)
    {
        $this->repoName = $repo;
    }

    public function handle()
    {
        echo 'This will eventually execute <pre>git http-backend</pre>';
        exit(0);
    }
}