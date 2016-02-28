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

    const GIT_HTTP_BACKEND = '/usr/lib/git-core/git-http-backend';
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
            'GIT_PROJECT_ROOT' => '/srv/git',
            'REQUEST_METHOD' => $method,
            'PATH_INFO' =>  strtok($this->repoName, '?'),
            'GIT_HTTP_EXPORT_ALL' => '1',
            'QUERY_STRING' => $_SERVER['QUERY_STRING'],
            'GIT_COMMITTER_EMAIL' => 'andrewmontagne@gmail.com',
            'GIT_COMMITTER_NAME' => 'Andrew Montagne',
            'GIT_HTTP_MAX_REQUEST_BUFFER' => '100M',
        ];
        if('POST' == $method) {
            $environmentVariables['CONTENT_TYPE'] = $_SERVER['CONTENT_TYPE'];
        }
        //$environmentVariables = $environmentVariables + $_SERVER; //Merge in the "CGI" variables

        $otherOptions = [
            'bypass_shell' => true,
        ];

        $descriptorSpec = [
            self::PIPE_STDIN => ['pipe', 'r'],
            self::PIPE_STDOUT => ['pipe', 'w'],
            self::PIPE_STDERR => ['pipe', 'w'],
        ];

        $git = proc_open(
            self::GIT_HTTP_BACKEND,
            $descriptorSpec,
            $pipes,
            self::GIT_CORE,
            $environmentVariables,
            $otherOptions);

        if($git && $method == 'POST') {
            $readbuffer = fopen('php://input', 'r');
            $toWrite = '';
            while (true) {
                if ($toWrite == '') {
                    if (feof($readbuffer)) break;
                    $toWrite = fread($readbuffer, 4096);
                    file_put_contents('/tmp/trident.log', $toWrite, FILE_APPEND);
                }
                $l = fwrite($pipes[self::PIPE_STDIN], $toWrite);
                if ($l === false) {
                    echo 'Error writing to process';
                } else {
                    if ($l == 0) {
                        echo "Empty </br>";
                        usleep(1000);
                    } else {
                        $toWrite = '';
                    }
                }
                fflush($pipes[self::PIPE_STDIN]);
            }
        } else if(!$git) {
            header("HTTP/1.0 500 Internal Server Error");
            echo "<h1>Could not open cgi process</h1>";
            exit(1);
        }

        $cgi_out = $pipes[self::PIPE_STDOUT];

        $totalResponse = '';

        $buffer = '';
        while(!feof($cgi_out)) {
            $char = fread($cgi_out, 1);
            $totalResponse .= $char;

            if("\n" == $char) {
                if(strlen($buffer) < 2) {
                    break;
                }
                header($buffer);
                if(strtok($buffer, ': ') == 'Status') {
                    header('HTTP/1.1 ' . strtok(null));
                }
                $buffer = '';
            } else {
                $buffer .= $char;
            }

            $lastChar = $char;
        }

        while(!feof($cgi_out)) {
            $data = fread($cgi_out, 8192);
            echo $data;
            $totalResponse .= $data;
        }

        file_put_contents('/tmp/trident.log', 'BEGIN DEBUG LOG' . PHP_EOL . PHP_EOL);
        file_put_contents('/tmp/trident.log', $totalResponse, FILE_APPEND);
        file_put_contents('/tmp/trident.log', fread($pipes[self::PIPE_STDERR], 8192), FILE_APPEND);
        file_put_contents('/tmp/trident.log', PHP_EOL . 'DEBUG:', FILE_APPEND);
        file_put_contents('/tmp/trident.log', json_encode($environmentVariables, JSON_PRETTY_PRINT), FILE_APPEND);
        file_put_contents('/tmp/trident.log', json_encode(getallheaders(), JSON_PRETTY_PRINT), FILE_APPEND);

        exit(0);
    }
}