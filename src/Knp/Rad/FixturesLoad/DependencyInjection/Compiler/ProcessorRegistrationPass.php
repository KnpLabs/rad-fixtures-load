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
        $alias      = $container->getAlias('knp_rad_fixtures_load.fixtures_factory');
        $factory    = $container->getDefinition($alias);

        foreach ($processors as $id => $tags) {
            $factory
                ->addMethodCall('addProcessor', [new Reference($id)])
            ;
        }
    }
}
