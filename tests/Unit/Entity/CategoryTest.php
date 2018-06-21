<?php

namespace oat\OneRoster\Tests\Unit\Entity;

use oat\OneRoster\Entity\Category;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function testGetType()
    {
        $this->assertEquals('categories', Category::getType());
    }
}
