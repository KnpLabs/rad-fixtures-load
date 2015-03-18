<?php

namespace spec\Knp\Rad\FixturesLoad;

use Doctrine\Common\Persistence\ObjectManager;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FixturesFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Rad\FixturesLoad\FixturesFactory');
    }

    function it_returns_a_fixtures_instance(ObjectManager $om)
    {
        $this->create($om)->shouldHaveType('Nelmio\Alice\Fixtures');
        $this->create($om, 'fr')->shouldHaveType('Nelmio\Alice\Fixtures');
    }
}
