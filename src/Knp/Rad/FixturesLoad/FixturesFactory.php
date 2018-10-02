<?php

declare(strict_types=1);

namespace Knp\Rad\FixturesLoad;

use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;
use Nelmio\Alice\ProcessorInterface;

interface FixturesFactory
{
    public function addProcessor(ProcessorInterface $processor);

    /**
     * @param object $provider
     */
    public function addProvider($provider);

    public function create(ObjectManager $om, string $locale = null): Fixtures;
}
