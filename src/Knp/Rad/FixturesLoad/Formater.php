<?php

declare(strict_types=1);

namespace Knp\Rad\FixturesLoad;

use Symfony\Component\Console\Output\OutputInterface;

interface Formater
{
    const VERBOSITY_NORMAL = false;

    const VERBOSITY_EXTRA = true;

    public function setOutput(OutputInterface $output);

    public function getVerbosity(): bool;

    public function preLoad(Event $event);

    public function postLoad(Event $event);
}
