<?php

namespace Knp\Rad\FixturesLoad\Bundle;

use Knp\Rad\FixturesLoad\DependencyInjection\Compiler\FactorySwitcherPass;
use Knp\Rad\FixturesLoad\DependencyInjection\Compiler\ProcessorRegistrationPass;
use Knp\Rad\FixturesLoad\DependencyInjection\Compiler\ProviderRegistrationPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FixturesLoadBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new FactorySwitcherPass());
        $container->addCompilerPass(new ProcessorRegistrationPass());
        $container->addCompilerPass(new ProviderRegistrationPass());
    }

    /**
     * {@inheritdoc}
     */
    public function getNamespace()
    {
        $namespace = parent::getNamespace();

        return substr($namespace, 0, strrpos($namespace, '\\'));
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return dirname(parent::getPath());
    }

    /**
     * {@inheritdoc}
     */
    public function getContainerExtensionClass()
    {
        return 'Knp\Rad\FixturesLoad\DependencyInjection\FixturesLoadExtension';
    }
}
