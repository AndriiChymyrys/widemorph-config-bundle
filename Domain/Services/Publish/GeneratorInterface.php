<?php

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish;

interface GeneratorInterface
{
    public function simpleCopy(string $publishBundlePath, string $publishToPath): void;

    public function generateFile(string $fileName, string $publishToPath, array $vars, string $templateName): void;
}
