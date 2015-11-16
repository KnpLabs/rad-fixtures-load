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
        $alias     = $container->getAlias('knp_rad_fixtures_load.fixtures_factory');
        $factory   = $container->getDefinition($alias);

        foreach ($providers as $id => $tags) {
            $factory
                ->addMethodCall('addProvider', [new Reference($id)])
            ;
        }
    }
}
