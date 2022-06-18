# MorphConfigBundle

Use for config project to publish entity, repositories etc.

## Publish files

### Publish all files

`console morph:config:publish`

### Publish specific files `--type`

To publish only specific files type use `--type` option

`console morph:config:publish --type=entity`

## Publish entity config

By default, entity table name will be generated from entity name.

You can specify table name or table prefix for entity in symfony compiler pass. You can use
`WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\ExternalBundleConfig` service, 
to set table name or prefix for one entity or for folder of entities you need to add method call to service definition.

```php
$definition = $container->getDefinition('WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\ExternalBundleConfig');
$definition->addMethodCall(
    'set',
    [
        'WideMorph\Ims\Bundle\ImsProductBundle\Infrastructure\Entity',
        [ExternalBundleConfigInterface::DB_PREFIX_SETTING_NAME => 'ims']
    ]
);
```
`ExternalBundleConfigInterface::set(string $key, array $config)` where `$key` is name space of entity or folder, and `$config` array of config.

See more fields which you can pass in configs array in `ExternalBundleConfigInterface`

Note: `$key` with entity namespace has high priority on folder namespace and will override folder namespace configs.
