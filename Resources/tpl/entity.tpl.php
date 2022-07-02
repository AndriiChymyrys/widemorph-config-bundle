<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace ?>;

<?= $useStatements ?><?= PHP_EOL ?>

/**
<?php if ($repositoryClass) : ?>
 * @ORM\Entity(repositoryClass="<?= $repositoryClass ?>")
<?php else: ?>
 * @ORM\Entity()
<?php endif; ?>
 * @ORM\Table(name="<?= $tableName ?>")
 */
class <?= $className ?> extends <?= $baseClassName ?><?= PHP_EOL ?>
{
}
