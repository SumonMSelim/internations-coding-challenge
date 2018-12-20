<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Migrations\AbortMigrationException;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20181220183001 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        try {
            $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        } catch (DBALException $e) {
        } catch (AbortMigrationException $e) {
        }

        $this->addSql('CREATE TABLE `user` (`id` INT AUTO_INCREMENT NOT NULL, `username` VARCHAR(64) NOT NULL, `roles` JSON NOT NULL, `password` VARCHAR(128) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (`username`), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET `utf8mb4` COLLATE `utf8mb4_unicode_ci` ENGINE = `InnoDB`');
    }

    public function down(Schema $schema): void
    {
        try {
            $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        } catch (DBALException $e) {
        } catch (AbortMigrationException $e) {
        }

        $this->addSql('DROP TABLE `user`');
    }
}
