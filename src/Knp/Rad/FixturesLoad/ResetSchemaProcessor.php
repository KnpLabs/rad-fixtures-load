<?php

declare(strict_types=1);

namespace Knp\Rad\FixturesLoad;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\SchemaTool;

class ResetSchemaProcessor
{
    /**
     * @var \Doctrine\Common\Persistence\ManagerRegistry
     */
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param string|null $managerName
     *
     * @throws \Doctrine\ORM\Tools\ToolsException
     */
    public function resetDoctrineSchema($managerName = null)
    {
        $manager    = $this->doctrine->getManager($managerName);
        $metadata   = $manager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($manager);

        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);
    }
}
