<?php

namespace spec\Knp\Rad\FixturesLoad\Formater;

use Knp\Rad\FixturesLoad\Event;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Prophecy\Doubler\Doubler;
use Symfony\Component\Console\Output\OutputInterface;

class ObjectsFormaterSpec extends ObjectBehavior
{
    function let(Event $event, OutputInterface $output)
    {
        $this->setOutput($output);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Rad\FixturesLoad\Formater\ObjectsFormater');
    }

    function it_display_entities($event, $output)
    {
        $event->getObjects()->willReturn([new Doubler(), new Argument(), new Doubler()]);
        $output->writeln('        <comment>Prophecy\Doubler\Doubler</comment>: 2')->shouldBeCalled();
        $output->writeln('        <comment>Prophecy\Argument</comment>: 1')->shouldBeCalled();

        $this->postLoad($event);
    }
}
