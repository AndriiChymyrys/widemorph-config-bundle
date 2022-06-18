<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services;

/**
 * Class ExternalBundleConfigInterface
 *
 * @package WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services
 */
interface ExternalBundleConfigInterface
{
    /** @var string */
    public const DB_PREFIX_SETTING_NAME = 'db_table_prefix';

    /** @var string */
    public const DB_TABLE_SETTING_NAME = 'table_name';

    /**
     * @param string $key Class namespace or class full name
     * @param array $config
     *
     * @return void
     */
    public function set(string $key, array $config): void;

    /**
     * @param string $key Class namespace or class full name
     * @param mixed|null $configKey
     *
     * @return mixed
     */
    public function get(string $key, mixed $configKey = null): mixed;
}
