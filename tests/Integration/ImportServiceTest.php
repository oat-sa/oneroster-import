<?php

namespace oat\OneRoster\Tests\Integration\Service;

use Doctrine\Common\Collections\ArrayCollection;
use oat\OneRoster\Entity\ClassRoom;
use oat\OneRoster\Entity\Enrollment;
use oat\OneRoster\Entity\EntityRepository;
use oat\OneRoster\Entity\Factory\RelationConfigFactory;
use oat\OneRoster\Entity\Organisation;
use oat\OneRoster\Entity\User;
use oat\OneRoster\File\FileHandler;
use oat\OneRoster\Service\ImportService;
use oat\OneRoster\Storage\InMemoryStorage;
use PHPUnit\Framework\TestCase;

class ImportServiceTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testImport()
    {
        $fileHandler = new FileHandler();
        $importService = new ImportService($fileHandler);
        $results = $importService->importMultiple(__DIR__ . '/../../data/samples/OneRosterv1p1BaseCSV/');

        $entityRepo    = $this->buildEntityRepository($results, $fileHandler);
        $organisations = $entityRepo->getAll(Organisation::class);
        $this->assertOrganisationCollection($organisations);

        /** @var Organisation $oneOrg */
        $oneOrg = $entityRepo->get('12345', Organisation::class);
        $this->assertInstanceOf(Organisation::class, $oneOrg);
        $this->assertSame('12345', $oneOrg->getId());
        $this->assertInternalType('array', $oneOrg->getData());

        $this->assertCount(2, $oneOrg->getEnrollments());
        $this->assertCount(2, $oneOrg->getClasses());
        $this->assertCount(1, $oneOrg->getUsers());

        /** @var ClassRoom $class */
        $class = $oneOrg->getClasses()->first();
        $this->assertSame('class1', $class->getId());
        $this->assertInstanceOf(Organisation::class, $class->getOrg());
        $this->assertCount(1, $class->getEnrollments());

        /** @var User $user */
        $user = $oneOrg->getUsers()->first();
        $this->assertSame('user1', $user->getId());
        $this->assertCount(1, $user->getOrgs());
        $this->assertCount(2, $user->getEnrollments());

        /** @var Enrollment $enroll */
        $enroll = $oneOrg->getEnrollments()->first();
        $this->assertSame('enrol1', $enroll->getId());
        $this->assertInstanceOf(User::class, $enroll->getUser());
        $this->assertInstanceOf(ClassRoom::class, $enroll->getClass());
        $this->assertInstanceOf(Organisation::class, $enroll->getOrg());
    }

    protected function assertOrganisationCollection($organisations)
    {
        $this->assertInstanceOf(ArrayCollection::class, $organisations);

        foreach ($organisations as $organisation){
            $this->assertInstanceOf(Organisation::class, $organisation);
        }
    }

    protected function buildEntityRepository($results, $fileHandler)
    {
        $storage          = new InMemoryStorage($results);
        $relationConfig   = (new RelationConfigFactory($fileHandler))->create();
        $entityRepository = new EntityRepository($storage, $relationConfig);

        return $entityRepository;
    }
}