<?php

namespace Knp\Rad\FixturesLoad\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ProviderRegistrationPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $providers = $container->findTaggedServiceIds('knp_rad_fixtures_load.provider');
        $listener  = $container->getDefinition('knp_rad_fixtures_load.fixtures_factory');

        foreach ($providers as $id => $tags) {
            $listener
                ->addMethodCall('addProvider', [new Reference($id)])
            ;
        }
    }
}
