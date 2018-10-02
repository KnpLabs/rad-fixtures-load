<?php

declare(strict_types=1);

namespace Knp\Rad\FixturesLoad;

use Symfony\Component\EventDispatcher\Event as BaseEvent;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class Event extends BaseEvent
{
    /**
     * @var Bundle
     */
    private $bundle;

    /**
     * @var string
     */
    private $file;

    /**
     * @var object[]
     */
    private $objects;

    /**
     * @param string $file
     */
    public function __construct(Bundle $bundle, $file)
    {
        $this->bundle = $bundle;
        $this->file   = $file;
    }

    public function getBundle(): Bundle
    {
        return $this->bundle;
    }

    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * @return object[]
     */
    public function getObjects(): array
    {
        return $this->objects;
    }

    /**
     * @param object[] $objects
     */
    public function setObjects(array $objects)
    {
        $this->objects = $objects;
    }
}
