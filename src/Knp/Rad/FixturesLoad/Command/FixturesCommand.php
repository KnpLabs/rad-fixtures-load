<?php

namespace Knp\Rad\FixturesLoad\Command;

use Knp\Rad\FixturesLoad\Events;
use Knp\Rad\FixturesLoad\Formater\BundleFormater;
use Knp\Rad\FixturesLoad\Formater\FileFormater;
use Knp\Rad\FixturesLoad\Formater\ObjectsFormater;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class FixturesCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('rad:fixtures:load')
            ->setDescription('Automaticly load alice fixtures files.')
            ->addOption(
                'bundle',
                'b',
                InputOption::VALUE_OPTIONAL|InputOption::VALUE_IS_ARRAY,
                'Bundles where fixtures shouls be loaded'
            )
            ->addOption(
                'filter',
                'f',
                InputOption::VALUE_OPTIONAL|InputOption::VALUE_IS_ARRAY,
                'Filter importable files via name suffix (dev => *.dev.yml).'
            )
            ->addOption(
                'connection',
                'c',
                InputOption::VALUE_OPTIONAL,
                'Doctrine connection to use',
                'default'
            )
            ->addOption(
                'locale',
                'l',
                InputOption::VALUE_OPTIONAL,
                'Locale for faked fixtures',
                'en_US'
            )
            ->addOption(
                'reset-schema',
                'r',
                InputOption::VALUE_OPTIONAL,
                'Reset DB schema before loading fixtures'
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $application = $this->getApplication();
        $bundles     = [];

        if (false === $application instanceof Application) {
            throw new \RuntimeException('Only Symfony\Bundle\FrameworkBundle\Console\Application supported.');
        }

        $resetSchemaOption = $input->getOption('reset-schema');

        if (!empty($resetSchemaOption)) {
            $output->writeln('Resetting schema ...');
            $this->getResetSchemaProcessor()->resetDoctrineSchema();
        }

        if (true === $input->hasOption('bundle')) {
            $bundles = $input->getOption('bundle');
        }

        if (true === empty($bundles)) {
            $bundles = array_keys($application->getKernel()->getBundles());
        }

        $bundles = $this->resolveBundles($bundles);
        $filters = [];

        if (true === $input->hasOption('filter')) {
            $filters = array_map(function ($e) { return sprintf('*.%s.yml', $e); }, $input->getOption('filter'));
        }

        if (true === empty($filters)) {
            $filters = ['*.yml'];
        }

        $formaters  = $this->getFormaters($output, $input->getOption('verbose'));
        $dispatcher = $this->getContainer()->get('event_dispatcher');

        foreach ($formaters as $formater) {
            $dispatcher->addListener(Events::PRE_LOAD,   [$formater,  'preLoad']);
            $dispatcher->addListener(Events::POST_LOAD,  [$formater,  'postLoad']);
        }

        foreach ($bundles as $bundle) {
            $this->getLoader()->loadFixtures(
                $bundle,
                $filters,
                $input->getOption('connection'),
                $input->getOption('locale')
            );
        }
    }

    /**
     * @param string[] $names
     *
     * @return Symfony\Component\HttpKernel\Bundle\Bundle[]
     */
    private function resolveBundles(array $names)
    {
        $bundles = $this->getApplication()->getKernel()->getBundles();
        $result  = [];

        foreach ($names as $name) {
            if (false === array_key_exists($name, $bundles)) {
                throw new \RuntimeException(sprintf(
                    'Bundle named "%s" not found. "%s", available.',
                    $name,
                    implode('", "', array_keys($bundles))
                ));
            }

            $result[$name] = $bundles[$name];
        }

        return $result;
    }

    /**
     * @return Knp\Rad\FixturesLoad\Loader
     */
    private function getLoader()
    {
        return $this->getContainer()->get('knp_rad_fixtures_load.loader');
    }

    /**
     * @return Knp\Rad\FixturesLoad\ResetDatabaseSchema
     */
    private function getResetSchemaProcessor()
    {
        return $this->getContainer()->get('knp_rad_fixtures_load.reset_schema_processor');
    }

    /**
     * @param OutputInterface $output
     * @param boolean         $verbosity
     *
     * @return Formater[]
     */
    private function getFormaters(OutputInterface $output, $verbosity)
    {
        $formaters = [
            new BundleFormater(),
            new FileFormater(),
            new ObjectsFormater(),
        ];

        foreach ($formaters as $formater) {
            $formater->setOutput($output);
        }

        return array_filter($formaters, function ($e) use ($verbosity) {
            return false === $verbosity ? $verbosity === $e->getVerbosity() : true;
        });
    }
}
