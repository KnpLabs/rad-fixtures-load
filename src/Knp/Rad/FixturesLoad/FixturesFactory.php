<?php

namespace Knp\Rad\FixturesLoad;

use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;
use Nelmio\Alice\ProcessorInterface;

class FixturesFactory
{
    /**
     * @var ProcessorInterface[]
     */
    private $processors = [];

    /**
     * @var object[]
     */
    private $providers = [];

    /**
     * @param ProcessorInterface $processor
     *
     * @return FixturesFactory
     */
    public function addProcessor(ProcessorInterface $processor)
    {
        $this->processors[] = $processor;

        return $this;
    }

    /**
     * @param object $provider
     *
     * @return FixturesFactory
     */
    public function addProvider($provider)
    {
        $this->providers[] = $provider;

        return $this;
    }

    /**
     * @param ObjectManager $om
     * @param string|null   $locale
     *
     * @return Fixtures
     */
    public function create(ObjectManager $om, $locale = null)
    {
        $options = [
            'providers' => $this->providers,
        ];

        if (null !== $locale) {
            $options['locale'] = $locale;
        }

        return new Fixtures($om, $options, $this->processors);
    }
}
