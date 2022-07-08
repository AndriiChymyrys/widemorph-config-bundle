<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace ?>;

<?= $useStatements ?><?= PHP_EOL ?>

class <?= $className ?> extends <?= $baseClassName ?><?= PHP_EOL ?>
{
    public function __construct(<?= $arguments ?>)
    {
        parent::__construct(<?= $parentArguments ?>, <?= $entityName ?>::class);
    }
}
