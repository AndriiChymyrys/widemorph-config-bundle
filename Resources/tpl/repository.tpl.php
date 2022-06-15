<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace ?>;

use Doctrine\Persistence\ManagerRegistry;
<?= $useStatements ?><?= PHP_EOL ?>

class <?= $className ?> extends <?= $baseClassName ?><?= PHP_EOL ?>
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, <?= $entityName ?>::class);
    }
}
