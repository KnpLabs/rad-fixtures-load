<?php

namespace Knp\Rad\FixturesLoad\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ProcessorRegistrationPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $processors = $container->findTaggedServiceIds('knp_rad_fixtures_load.processor');
        $listener   = $container->getDefinition('knp_rad_fixtures_load.fixtures_factory');

        foreach ($processors as $id => $tags) {
            $listener
                ->addMethodCall('addProcessor', [new Reference($id)])
            ;
        }
    }
}
