<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish;

/**
 * Class DocBlockParserInterface
 *
 * @package WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish
 */
interface DocBlockParserInterface
{
    /**
     * @param string $doc
     * @param string $name
     *
     * @return null|string|bool
     */
    public function getMetaByName(string $doc, string $name): null|string|bool;
}