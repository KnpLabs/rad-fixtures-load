<?php

declare(strict_types=1);

namespace Knp\Rad\FixturesLoad\FixturesFactory;

use Doctrine\Common\Persistence\ObjectManager;
use Knp\Rad\FixturesLoad\FixturesFactory;
use Nelmio\Alice\Fixtures;
use Nelmio\Alice\ProcessorInterface;

class LegacyFactory implements FixturesFactory
{
    /**
     * @var ProcessorInterface[]
     */
    protected $processors = [];

    /**
     * @var object[]
     */
    protected $providers = [];

    /**
     * {@inheritdoc}
     */
    public function addProcessor(ProcessorInterface $processor)
    {
        $this->processors[] = $processor;
    }

    /**
     * {@inheritdoc}
     */
    public function addProvider($provider)
    {
        $this->providers[] = $provider;
    }

    /**
     * {@inheritdoc}
     */
    public function create(ObjectManager $manager, $locale = null): Fixtures
    {
        $options = [
            'providers' => $this->providers,
        ];

        if (null !== $locale) {
            $options['locale'] = $locale;
        }

        return new Fixtures($manager, $options, $this->processors);
    }
}
