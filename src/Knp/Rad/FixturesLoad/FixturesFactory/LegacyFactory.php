<?php

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

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addProvider($provider)
    {
        $this->providers[] = $provider;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function create(ObjectManager $manager, $locale = null)
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
