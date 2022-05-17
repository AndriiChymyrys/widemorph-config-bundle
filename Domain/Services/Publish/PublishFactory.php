<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish;

use WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Exception\PublishServiceNotFoundException;
use WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\Type\PublishInterface;

/**
 * Class PublishFactory
 *
 * @package WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services
 */
class PublishFactory implements PublishFactoryInterface
{
    /**
     * @var PublishInterface[]
     */
    protected array $publish;

    /**
     * @param  PublishInterface  ...$publish
     */
    public function __construct(PublishInterface ...$publish)
    {
        $this->publish = $publish;
    }

    /**
     * {@inheritDoc}
     *
     * @throws PublishServiceNotFoundException
     */
    public function getServiceByType(string $type): PublishInterface
    {
        foreach ($this->publish as $publish) {
            if ($type === $publish->getType()) {
                return $publish;
            }
        }

        throw new PublishServiceNotFoundException();
    }

    /**
     * {@inheritDoc}
     */
    public function getAll(): array
    {
        return $this->publish;
    }
}
