<?php

namespace Knp\Rad\FixturesLoad;

use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;
use Nelmio\Alice\ProcessorInterface;

interface FixturesFactory
{
    /**
     * @param ProcessorInterface $processor
     *
     * @return FixturesFactory
     */
    public function addProcessor(ProcessorInterface $processor);

    /**
     * @param object $provider
     *
     * @return FixturesFactory
     */
    public function addProvider($provider);

    /**
     * @param ObjectManager $om
     * @param string|null   $locale
     *
     * @return Fixtures
     */
    public function create(ObjectManager $om, $locale = null);
}
