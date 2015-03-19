<?php

namespace Knp\Rad\FixturesLoad\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class LoaderPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('doctrine')) {
            $container->removeDefinition('knp_rad_fixtures_load.orm_loader');
        }

        if (!$container->hasDefinition('doctrine_mongodb')) {
            $container->removeDefinition('knp_rad_fixtures_load.odm_loader');
        }
    }
}
