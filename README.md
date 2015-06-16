Rapid Application Development : Fixtures Load
=============================================
A command to load them all

[![Build Status](https://travis-ci.org/KnpLabs/rad-fixtures-load.svg?branch=master)](https://travis-ci.org/KnpLabs/rad-fixtures-load)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/KnpLabs/rad-fixtures-load/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/KnpLabs/rad-fixtures-load/?branch=master)

This library uses the awesome [nelmio/alice](https://github.com/nelmio/alice) library.

#Installation

```bash
composer require knplabs/rad-fixtures-load ~1.0
```

```php
class AppKernel
{
    function registerBundles()
    {
        $bundles = array(
            //...
            new Knp\Rad\FixturesLoad\Bundle\FixturesLoadBundle(),
            //...
        );

        //...

        return $bundles;
    }
}
```

#Usages

Inside your bundle, you have to store your Alice fixtures files into `Resources/fixtures/orm`.

##Load fixtures of all bundles

Just run the command

```bash
app/console rad:fixtures:load
```

##Load fixtures of specific bundles

I've got two bundles, `App` and `Api`.

```bash
app/console rad:fixtures:load -b App -b Api
```

The order is important. Fixtures will be loaded following this order.

##Use file filtering

If I run this command

```bash
app/console rad:fixtures:load -f dev
```

All files finishing with `.dev.yml` will be loaded. And just those files.

You can also chain filters.

```bash
app/console rad:fixtures:load -f dev -f test
```

In this case, order doesn't have any importance.

##Use Alice provider or Alice processor

You just have to tag your service with `knp_rad_fixtures_load.provider` or `knp_rad_fixtures_load.processor`.

```yml
my_bundle.my_provider:
    class: My\Provider
    tags:
        - { name: knp_rad_fixtures_load.provider }

my_bundle.my_processor:
    class: My\Processor # implements Nelmio\Alice\ProcessorInterface
    tags:
        - { name: knp_rad_fixtures_load.processor }
```
