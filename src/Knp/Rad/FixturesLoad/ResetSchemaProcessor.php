<?php

namespace Knp\Rad\FixturesLoad;

use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\EntityManager;

class ResetSchemaProcessor
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $manager;

    /**
     * @var \Doctrine\ORM\Tools\SchemaTool
     */
    private $schemaTool;

    /**
     * @param EntityManager $manager
     * @param SchemaTool $schemaTool
     */
    function __construct(EntityManager $manager, SchemaTool $schemaTool)
    {
        $this->manager    = $manager;
        $this->schemaTool = $schemaTool;
    }

    public function resetDoctrineSchema()
    {
        $metadata = $this->manager->getMetadataFactory()->getAllMetadata();

        $this->schemaTool->dropSchema($metadata);
        $this->schemaTool->createSchema($metadata);
    }
}
