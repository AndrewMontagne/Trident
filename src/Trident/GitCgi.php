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
        $this->repoName = '/' . $repo;
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
            'PATH_INFO' => $this->repoName,
            'REMOTE_USER' => 'andrew',
            'REMOTE_ADDR' => 'git.local',
            'QUERY_STRING' => $_SERVER['QUERY_STRING'],
            'GIT_HTTP_EXPORT_ALL' => 'TRUE',
            'REQUEST_METHOD' => $method,
        ];
        $otherOptions = [
            'suppress_errors' => true,
            'bypass_shell' => true,
        ];

        $descriptorSpec = [];
        if($method == 'POST') {
            $descriptorSpec[self::PIPE_STDIN] = ['pipe', 'r'];
            $descriptorSpec[self::PIPE_STDOUT] = ['pipe', 'w'];
            $descriptorSpec[self::PIPE_STDERR] = ['pipe', 'w'];
        } else {
            $descriptorSpec[self::PIPE_STDOUT] = ['pipe', 'w'];
        }

        $git = proc_open(
            'git http-backend',
            $descriptorSpec,
            $pipes,
            ROOT_DIR,
            $environmentVariables,
            $otherOptions);

        if($git && $method == 'POST') {
            $readbuffer = fopen('php://input', 'r');
            $toWrite = '';
            while (true) {
                if ($toWrite == '') {
                    if (feof($readbuffer)) break;
                    $toWrite = fread($readbuffer, 4096);
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

        error_log($totalResponse);

        exit(0);
    }
}