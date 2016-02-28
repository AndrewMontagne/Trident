<?php
/**
 * Created by IntelliJ IDEA.
 * User: Andrew
 * Date: 24/02/2016
 * Time: 23:11
 */

namespace Trident;

//Refer to: http://www.tcl.tk/man/aolserver3.0/cgi-ch4.htm

class GitCgi
{
    const PIPE_STDIN = 0;
    const PIPE_STDOUT = 1;
    const PIPE_STDERR = 2;

    const GIT_HTTP_BACKEND = 'git http-backend';
    const GIT_CORE = '/usr/lib/git-core/';

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

    /**
     * Handles the invocation of the Git CGI interface
     *
     * Adapted from http://nerds-central.blogspot.co.uk/2007/08/php-cgi-handler-using-procopen.html
     * Many thanks to Alexander Turner
     */
    public function handleCgi()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $pipes = [];
        $environmentVariables = [
            'GIT_PROJECT_ROOT' => '/media/sf_Development',
            'REQUEST_METHOD' => $method,
            'PATH_INFO' =>  strtok($this->repoName, '?'),
            'GIT_HTTP_EXPORT_ALL' => '1',
            'QUERY_STRING' => $_SERVER['QUERY_STRING'],
            'REMOTE_USER' => 'andrew',
            'REMOTE_ADDR' => '127.0.0.1',
            'GIT_COMMITTER_EMAIL' => 'andrewmontagne@gmail.com',
            'GIT_COMMITTER_NAME' => 'Andrew Montagne',
            'GIT_HTTP_MAX_REQUEST_BUFFER' => '1k',
        ];

        if($method == 'POST') {
            $environmentVariables["CONTENT_TYPE"] = $_SERVER["CONTENT_TYPE"];
            $environmentVariables["CONTENT_LENGTH"] = $_SERVER["CONTENT_LENGTH"];
        }

        $otherOptions = [
            'bypass_shell' => true,
        ];

        $descriptorSpec = [
            self::PIPE_STDIN => ['pipe', 'r'],
            self::PIPE_STDOUT => ['pipe', 'w'],
        ];

        $git = proc_open(
            self::GIT_HTTP_BACKEND,
            $descriptorSpec,
            $pipes,
            self::GIT_CORE,
            $environmentVariables,
            $otherOptions);

        if($git && $method == 'POST') {
            $postData = fopen('php://input', 'r');
            while(!feof($postData)) {
                fwrite($pipes[self::PIPE_STDIN], fread($postData, 1));
            }
            fflush($pipes[self::PIPE_STDIN]);
            fclose($postData);
        } else if(!$git) {
            header("HTTP/1.1 503 Service Unavailable");
            exit(1);
        }

        fclose($pipes[self::PIPE_STDIN]);

        $headersDone = false;
        while (!feof($pipes[self::PIPE_STDOUT]) && !$headersDone)
        {
            $header = fgets($pipes[self::PIPE_STDOUT], 10000000);
            $header = trim($header);

            if(!$headersDone) {
                if(trim($header) == '') {
                    $headersDone = true;
                } else {
                    header($header);
                }
            }
        }

        while(!feof($pipes[self::PIPE_STDOUT])) {
            $response = fread($pipes[self::PIPE_STDOUT], 1);
            file_put_contents('/tmp/trident.log', $response, FILE_APPEND);
            echo $response;
        }

        fclose($pipes[self::PIPE_STDOUT]);

        exit(0);
    }
}