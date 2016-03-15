<?php
/**
 * Copyright 2016 Andrew O'Rourke
 */

namespace Trident\Tests;

use \MuUnit\Test;


class IndexTest extends Test
{
    public function datasourceTest()
    {
        return [1,2,4,8,16,32];
    }

    public function testTest($var)
    {
        usleep(rand(0,200000));

        echo $var . PHP_EOL;

        $this->assert($var !== 0);
        $this->assert(true);
    }
}