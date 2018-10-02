<?php

declare(strict_types=1);

namespace Knp\Rad\FixturesLoad;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Exception;
use Nelmio\Alice\Fixtures;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class Loader
{
    /**
     * @var Fixtures
     */
    private $fixtures;

    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @var FixturesFactory
     */
    private $factory;

    public function __construct(
        ManagerRegistry $doctrine,
        FixturesFactory $factory,
        EventDispatcherInterface $dispatcher
    ) {
        $this->doctrine   = $doctrine;
        $this->factory    = $factory;
        $this->dispatcher = $dispatcher;
    }

    private function getFixtures(string $connection, string $locale = null): Fixtures
    {
        if (null !== $this->fixtures) {
            return $this->fixtures;
        }

        $om = $this->getObjectManager($connection);

        return $this->fixtures = $this->factory->create($om, $locale);
    }

    /**
     * @param string[] $filters
     */
    public function loadFixtures(
        Bundle $bundle,
        array $filters,
        string $connection,
        string $locale = null
    ) {
        if (false === is_dir(sprintf('%s/Resources/fixtures/orm', $bundle->getPath()))) {
            return;
        }

        $files = (new Finder())
            ->files()
            ->in(sprintf('%s/Resources/fixtures/orm', $bundle->getPath()))
            ->sortByName()
        ;

        foreach ($filters as $filter) {
            $files->name($filter);
        }

        foreach ($files as $file) {
            $event = new Event($bundle, $file->getPathname());
            $this->dispatcher->dispatch(Events::PRE_LOAD, $event);
            $event->setObjects($this->getFixtures($connection, $locale)->loadFiles($file));
            $this->dispatcher->dispatch(Events::POST_LOAD, $event);
        }
    }

    /**
     * @throws Exception
     */
    private function getObjectManager(string $name): ObjectManager
    {
        $objectManager = $this->doctrine->getManager($name);

        if (null === $objectManager) {
            throw new Exception(sprintf('Can\'t find doctrine object manager named "%s".', $name));
        }

        return $objectManager;
    }
}
