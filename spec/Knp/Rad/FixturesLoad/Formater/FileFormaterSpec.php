<?php

declare(strict_types=1);

namespace spec\Knp\Rad\FixturesLoad\Formater;

use Knp\Rad\FixturesLoad\Event;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Console\Output\OutputInterface;

class FileFormaterSpec extends ObjectBehavior
{
    function let(Event $event, OutputInterface $output)
    {
        $this->setOutput($output);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Rad\FixturesLoad\Formater\FileFormater');
    }

    function it_display_file_path($event, $output)
    {
        $event->getFile()->willReturn('/tmp/myfile.yml');
        $output->writeln('    /tmp/myfile.yml')->shouldBeCalled();

        $this->preLoad($event);
    }
}
