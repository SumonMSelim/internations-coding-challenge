<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Migrations\AbortMigrationException;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20181220184937 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        try {
            $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        } catch (DBALException $e) {
        } catch (AbortMigrationException $e) {
        }

        $this->addSql('CREATE TABLE `user_group` (`id` INT AUTO_INCREMENT NOT NULL, `user_id` INT NOT NULL, `group_id` INT NOT NULL, `added_on` DATETIME NOT NULL, INDEX IDX_8F02BF9DA76ED395 (`user_id`), INDEX IDX_8F02BF9DFE54D947 (`group_id`), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET `utf8mb4` COLLATE `utf8mb4_unicode_ci` ENGINE = `InnoDB`');
        $this->addSql('ALTER TABLE `user_group` ADD CONSTRAINT FK_8F02BF9DA76ED395 FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `user_group` ADD CONSTRAINT FK_8F02BF9DFE54D947 FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        try {
            $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        } catch (DBALException $e) {
        } catch (AbortMigrationException $e) {
        }

        $this->addSql('DROP TABLE `user_group`');
    }
}
