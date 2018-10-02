<?php

declare(strict_types=1);

namespace spec\Knp\Rad\FixturesLoad\FixturesFactory;

use Doctrine\Common\Persistence\ObjectManager;
use PhpSpec\ObjectBehavior;

class LegacyFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Rad\FixturesLoad\FixturesFactory');
    }

    function it_returns_a_fixtures_instance(ObjectManager $om)
    {
        if (true === interface_exists('Nelmio\Alice\PersisterInterface')) {
            return;
        }

        $this->create($om)->shouldHaveType('Nelmio\Alice\Fixtures');
        $this->create($om, 'fr')->shouldHaveType('Nelmio\Alice\Fixtures');
    }
}
