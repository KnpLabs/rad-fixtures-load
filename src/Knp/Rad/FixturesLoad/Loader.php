<?php

namespace Knp\Rad\FixturesLoad;

use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class Loader
{
    /**
     * @var \Nelmio\Alice\Fixtures
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

    /**
     * @var string
     */
    private $path;

    /**
     * @param ManagerRegistry          $doctrine
     * @param FixturesFactory          $factory
     * @param EventDispatcherInterface $dispatcher
     * @param string                   $path
     */
    public function __construct(
        ManagerRegistry $doctrine,
        FixturesFactory $factory,
        EventDispatcherInterface $dispatcher,
        $path
    ) {
        $this->doctrine   = $doctrine;
        $this->factory    = $factory;
        $this->dispatcher = $dispatcher;
        $this->path       = $path;
    }

    /**
     * @param Bundle      $bundle
     * @param string[]    $filters
     * @param string      $connection
     * @param string|null $locale
     */
    public function loadFixtures(Bundle $bundle, array $filters, $connection, $locale = null)
    {
        if (!file_exists($path = sprintf('%s/%s', $bundle->getPath(), $this->path))) {
            return;
        }

        $files = (new Finder())
            ->files()
            ->in($path)
            ->sortByName()
        ;

        foreach ($filters as $filter) {
            $files->name($filter);
        }

        foreach ($files as $file) {
            $event = new Event($bundle, $file);
            $this->dispatcher->dispatch(Events::PRE_LOAD, $event);
            $event->setObjects($this->getFixtures($connection, $locale)->loadFiles($file));
            $this->dispatcher->dispatch(Events::POST_LOAD, $event);
        }
    }

    /**
     * @param string $name
     *
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    private function getObjectManager($name)
    {
        if (null === $manager = $this->doctrine->getManager($name)) {
            throw new \Exception(sprintf('Can\'t find doctrine manager named "%s"'), $name);
        }

        return $manager;
    }

    /**
     * @param string      $connection
     * @param string|null $locale
     *
     * @return \Nelmio\Alice\Fixtures
     */
    private function getFixtures($connection, $locale = null)
    {
        if (null !== $this->fixtures) {
            return $this->fixtures;
        }

        $om = $this->getObjectManager($connection);

        return $this->fixtures = $this->factory->create($om, $locale);
    }
}
