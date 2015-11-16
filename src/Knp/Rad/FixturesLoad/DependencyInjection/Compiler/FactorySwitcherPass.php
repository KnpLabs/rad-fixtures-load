<?php

namespace Knp\Rad\FixturesLoad\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FactorySwitcherPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $alias = new Alias('knp_rad_fixtures_load.fixtures_factory.legacy_factory');

        if (true === interface_exists('Nelmio\Alice\PersisterInterface')) {
            $alias = new Alias('knp_rad_fixtures_load.fixtures_factory.persister_factory');
        }

        $container->setAlias('knp_rad_fixtures_load.fixtures_factory', $alias);
    }
}
