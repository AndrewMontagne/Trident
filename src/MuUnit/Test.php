<?php
/**
 * Copyright 2016 Andrew O'Rourke
 */

namespace MuUnit;

abstract class Test
{
    const STATE_PASSED = 0;
    const STATE_FAILED = 1;
    const STATE_ERROR = 2;
    const STATE_EXCEPTION = 4;
    const STATE_THROWABLE = 8;

    private $__state;
    private $__statistics;

    public function __hasPassed()
    {
        return $this->__state == self::STATE_PASSED;
    }

    public function __getState()
    {
        return $this->__state;
    }

    public function __resetState()
    {
        $this->__state = self::STATE_PASSED;
        return $this;
    }

    public function __runTests()
    {
        $this->__statistics = new \stdClass();
        $this->__statistics->testsRun = 0;
        $this->__statistics->passes = 0;
        $this->__statistics->fails = 0;
        $this->__statistics->assertions = 0;

        $methods = get_class_methods($this);

        foreach ($methods as $method)
        {
            if('test' === substr($method,0,4))
            {
                $testData = null;
                $testName = substr($method, 4);
                if(method_exists($this, 'datasource' . $testName))
                {
                    $testDataSource = 'datasource' . $testName;
                    $testData = $this->$testDataSource();
                }

                do
                {
                    $this->__resetState();

                    $methodVar = is_null($testData) ? null : array_shift($testData);
                    ob_start();
                    $this->__statistics->testsRun++;
                    try
                    {
                        $this->$method($methodVar);
                    }
                    catch(\Exception $e)
                    {
                        $this->__state |= self::STATE_EXCEPTION;
                    }
                    catch(\Error $e)
                    {
                        $this->__state |= self::STATE_ERROR;
                    }
                    catch(\Throwable $e)
                    {
                        $this->__state |= self::STATE_THROWABLE;
                    }
                    ob_end_clean();
                    if($this->__hasPassed())
                    {
                        echo '.';
                        $this->__statistics->passes++;
                    }
                    else
                    {
                        echo 'F';
                        $this->__statistics->fails++;
                    }
                }
                while(count($testData) > 0);
            }
        }

        return $this->__statistics;;
    }

    public function assert($condition)
    {
        $this->__statistics->assertions++;
        if(!$condition) {
            $this->__state |= self::STATE_FAILED;
        }
    }
}