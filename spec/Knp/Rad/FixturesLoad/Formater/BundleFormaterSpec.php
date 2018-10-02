<?php

declare(strict_types=1);

namespace spec\Knp\Rad\FixturesLoad\Formater;

use Knp\Rad\FixturesLoad\Event;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class BundleFormaterSpec extends ObjectBehavior
{
    function let(Bundle $bundle, Event $event, OutputInterface $output)
    {
        $this->setOutput($output);

        $event->getBundle()->willReturn($bundle);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Rad\FixturesLoad\Formater\BundleFormater');
    }

    function it_writes_bundle_name_once($event, $output)
    {
        $output->writeln(Argument::type('string'))->shouldBeCalledTimes(1);

        $this->preLoad($event);
    }

    function it_writes_bundle_name_just_once_for_the_same_bundle($event, $output)
    {
        $output->writeln(Argument::type('string'))->shouldBeCalledTimes(1);

        $this->preLoad($event);
        $this->preLoad($event);
    }

    function it_write_bundles_names(
        $event,
        Event $event2,
        Bundle $bundle2,
        $output
    ) {
        $event2->getBundle()->willReturn($bundle2);
        $output->writeln(Argument::type('string'))->shouldBeCalledTimes(2);

        $this->preLoad($event);
        $this->preLoad($event2);
    }
}
