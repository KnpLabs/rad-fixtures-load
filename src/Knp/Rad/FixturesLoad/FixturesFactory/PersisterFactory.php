<?php

declare(strict_types=1);

namespace Knp\Rad\FixturesLoad\FixturesFactory;

use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;
use Nelmio\Alice\Persister\Doctrine;

class PersisterFactory extends LegacyFactory
{
    /**
     * {@inheritdoc}
     */
    public function create(ObjectManager $om, $locale = null): Fixtures
    {
        $options = [
            'providers' => $this->providers,
        ];

        if (null !== $locale) {
            $options['locale'] = $locale;
        }

        $doctrinePersister = new Doctrine($om);

        return new Fixtures($doctrinePersister, $options, $this->processors);
    }
}
