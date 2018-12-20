<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Migrations\AbortMigrationException;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181220183656 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        try {
            $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        } catch (DBALException $e) {
        } catch (AbortMigrationException $e) {
        }

        $this->addSql('CREATE TABLE `group` (`id` INT AUTO_INCREMENT NOT NULL, `name` VARCHAR(64) NOT NULL, `created_at` DATETIME NOT NULL, UNIQUE INDEX UNIQ_6DC044C55E237E06 (`name`), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET `utf8mb4` COLLATE `utf8mb4_unicode_ci` ENGINE = `InnoDB`');
    }

    public function down(Schema $schema): void
    {
        try {
            $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        } catch (DBALException $e) {
        } catch (AbortMigrationException $e) {
        }

        $this->addSql('DROP TABLE `group`');
    }
}
