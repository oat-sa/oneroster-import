<?php

namespace oat\OneRoster\Tests\Unit\Entity;

use oat\OneRoster\Entity\AcademicSession;
use PHPUnit\Framework\TestCase;

class AcademicSessionTest extends TestCase
{
    public function testGetType()
    {
        $this->assertEquals('academicSessions', AcademicSession::getType());
    }
}
