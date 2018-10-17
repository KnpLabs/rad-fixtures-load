Rapid Application Development : Fixtures Load
=============================================
A command to load them all

[![Build Status](https://travis-ci.org/KnpLabs/rad-fixtures-load.svg?branch=master)](https://travis-ci.org/KnpLabs/rad-fixtures-load)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/KnpLabs/rad-fixtures-load/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/KnpLabs/rad-fixtures-load/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/knplabs/rad-fixtures-load/v/stable)](https://packagist.org/packages/knplabs/rad-fixtures-load) [![Total Downloads](https://poser.pugx.org/knplabs/rad-fixtures-load/downloads)](https://packagist.org/packages/knplabs/rad-fixtures-load) [![Latest Unstable Version](https://poser.pugx.org/knplabs/rad-fixtures-load/v/unstable)](https://packagist.org/packages/knplabs/rad-fixtures-load) [![License](https://poser.pugx.org/knplabs/rad-fixtures-load/license)](https://packagist.org/packages/knplabs/rad-fixtures-load)

This library uses the awesome [nelmio/alice](https://github.com/nelmio/alice) library.

# Official maintainers:

* [@lcouellan](https://github.com/lcouellan)
* [@AntoineLelaisant](https://github.com/AntoineLelaisant)

# Installation

```bash
composer require --dev knplabs/rad-fixtures-load:~1.0
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

# Usages

Inside your bundle, you have to store your Alice fixtures files into `Resources/fixtures/orm`.

## Load fixtures of all bundles

Just run the command

```bash
app/console rad:fixtures:load
```

Or if you need both resetting your schema, just add -r option
```bash
app/console rad:fixtures:load -r
```

## Load fixtures of specific bundles

I've got two bundles, `App` and `Api`.

```bash
app/console rad:fixtures:load -b App -b Api
```

The order is important. Fixtures will be loaded following this order.

## Use file filtering

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

## Use Alice provider or Alice processor

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
