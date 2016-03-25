<?php
/**
 * Copyright 2016 Andrew O'Rourke
 */

namespace Trident\Tests\Models;


use Trident\Models\BaseModel;

class BaseModelTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerateUuid()
    {
        $uuid = BaseModel::generateUuid();
        $this->assertRegExp('/^\S{8}-\S{4}-\S{4}-\S{4}-\S{12}$/', $uuid);
    }
}