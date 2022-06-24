<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish;

/**
 * Class Generator
 *
 * @package WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish
 */
class Generator implements GeneratorInterface
{
    /**
     * @param FileManagerInterface $fileManager
     */
    public function __construct(protected FileManagerInterface $fileManager)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function simpleCopy(string $publishBundlePath, string $publishToPath): void
    {
        $toPath = $this->fileManager->getPublishToPath($publishToPath);
        $files = $this->fileManager->scanDir($publishBundlePath);

        foreach ($files as $filePath) {
            $filePathFrom = $publishBundlePath . '/' . $filePath->getRelativePath();
            $filePathTo = $toPath . '/' . $filePath->getRelativePath();

            $this->fileManager->copyIfNotExists($filePathFrom, $filePathTo);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function generateFile(string $fileName, string $publishToPath, array $vars, string $templateName): void
    {
        $templatePath = $this->fileManager->getTemplateFolder() . $templateName;

        $fileContent = $this->getFileContent($vars, $templatePath);

        $toPath = $this->fileManager->getPublishToPath($publishToPath) . '/' . $fileName;

        $this->fileManager->dumpFile($toPath, $fileContent);
    }

    /**
     * @param array $vars
     * @param string $templatePath
     *
     * @return string
     */
    protected function getFileContent(array $vars, string $templatePath): string
    {
        ob_start();

        extract($vars, \EXTR_SKIP);

        include $templatePath;

        return ob_get_clean();
    }
}
