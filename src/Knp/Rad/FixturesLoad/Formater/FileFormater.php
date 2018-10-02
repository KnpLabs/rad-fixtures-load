<?php

declare(strict_types=1);

namespace Knp\Rad\FixturesLoad\Formater;

use Knp\Rad\FixturesLoad\Event;
use Knp\Rad\FixturesLoad\Formater;
use Symfony\Component\Console\Output\OutputInterface;

class FileFormater implements Formater
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
    }

    /**
     * {@inheritdoc}
     */
    public function getVerbosity(): bool
    {
        return self::VERBOSITY_EXTRA;
    }

    /**
     * {@inheritdoc}
     */
    public function preLoad(Event $event)
    {
        $this->output->writeln(sprintf('    %s', $event->getFile()));
    }

    /**
     * {@inheritdoc}
     */
    public function postLoad(Event $event)
    {
        return;
    }
}
