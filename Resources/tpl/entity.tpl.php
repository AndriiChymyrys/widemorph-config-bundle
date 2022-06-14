<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace ?>;

<?= $useStatements ?><?= PHP_EOL ?>

/**
 * @ORM\Entity
 * @ORM\Table(name="<?= $tableName ?>")
 */
class <?= $className ?> extends <?= $baseClassName ?><?= PHP_EOL ?>
{
}
