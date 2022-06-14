<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services;

/**
 * Class ExternalBundleConfig
 *
 * @package WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services
 */
class ExternalBundleConfig implements ExternalBundleConfigInterface
{
    /**
     * @var array
     */
    protected array $configs;

    /**
     * {@inheritDoc}
     */
    public function set(string $key, array $config): void
    {
        $this->configs[$key] = $config;
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $key, mixed $configKey = null): mixed
    {
        $config = $this->configs[$key] ?? null;

        if ($config && $configKey) {
            return $config[$configKey] ?? null;
        }

        return $config;
    }
}
