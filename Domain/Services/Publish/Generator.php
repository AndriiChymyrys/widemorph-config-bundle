<?php

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish;

class Generator implements GeneratorInterface
{
    public function __construct(protected FileManagerInterface $fileManager)
    {
    }

    public function simpleCopy(string $publishBundlePath, string $publishToPath): void
    {
        $toPath = $this->fileManager->getPublishToPath($publishToPath);
        $files = $this->fileManager->scanDir($publishBundlePath);

        foreach ($files as $fileName) {
            $filePathFrom = $publishBundlePath . '/' . $fileName;
            $filePathTo = $toPath . '/' . $fileName;

            $this->fileManager->copyIfNotExists($filePathFrom, $filePathTo);
        }
    }

    public function generateFile(string $fileName, string $publishToPath, array $vars, string $templateName): void
    {
        $templatePath = $this->fileManager->getTemplateFolder() . $templateName;

        $fileContent = $this->getFileContent($vars, $templatePath);

        $toPath = $this->fileManager->getPublishToPath($publishToPath) . '/' . $fileName;

        $this->fileManager->dumpFile($toPath, $fileContent);
    }

    protected function getFileContent(array $vars, string $templatePath): string
    {
        ob_start();

        extract($vars, \EXTR_SKIP);

        include $templatePath;

        return ob_get_clean();
    }
}
