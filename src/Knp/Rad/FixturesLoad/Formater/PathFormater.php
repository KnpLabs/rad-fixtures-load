<?php

namespace Knp\Rad\FixturesLoad\Formater;

use Knp\Rad\FixturesLoad\Event;
use Knp\Rad\FixturesLoad\Formater;
use Symfony\Component\Console\Output\OutputInterface;

class PathFormater implements Formater
{
    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * {@inheritdoc}
     */
    public function setOutput(OutputInterface $output)
    {
        $this->output = $output;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getVerbosity()
    {
        return self::VERBOSITY_NORMAL;
    }

    /**
     * {@inheritdoc}
     */
    public function preLoad(Event $event)
    {
        $this->output->writeln(sprintf('<fg=black;bg=green>#Path > %s </fg=black;bg=green>', $event->getPath()));
    }

    /**
     * {@inheritdoc}
     */
    public function postLoad(Event $event)
    {
        return;
    }
}
