<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish;

/**
 * Class DocBlockParser
 *
 * @package WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish
 */
class DocBlockParser implements DocBlockParserInterface
{
    /**
     * {@inheritDoc}
     */
    public function getMetaByName(string $doc, string $name): null|string|bool
    {
        $items = $this->parse($doc);

        return $items[$name] ?? null;
    }

    /**
     * @param string $doc
     *
     * @return array
     */
    protected function parse(string $doc): array
    {
        $docs = [];

        preg_match_all('/!!(\w+) ?([\\\A-Za-z]+)?/', $doc, $match, PREG_SET_ORDER);

        foreach ($match as $item) {
            $docs[$item[1]] = $item[2] ?? true;
        }

        return $docs;
    }
}
