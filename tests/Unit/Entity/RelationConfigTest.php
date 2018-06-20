<?php

namespace oat\OneRoster\Tests\Unit\Entity;

use oat\OneRoster\Entity\RelationConfig;
use PHPUnit\Framework\TestCase;

class RelationConfigTest extends TestCase
{
    public function testGetConfig()
    {
        $relation = new RelationConfig([
           'orgs' => [
               'relations' => [
                   'enrollments' => [
                       'index' => 'schoolSourcedId'
                   ],
                   'courses' => [
                       'index' => 'orgSourcedId'
                   ]
               ]
           ]
        ]);

        $this->assertEquals('orgSourcedId', $relation->getConfig('orgs.relations.courses.index'));
    }
}
