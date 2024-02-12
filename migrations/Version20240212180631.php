<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240212180631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD addresses_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993985713BC80 FOREIGN KEY (addresses_id) REFERENCES addresses (id)');
        $this->addSql('CREATE INDEX IDX_F52993985713BC80 ON `order` (addresses_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993985713BC80');
        $this->addSql('DROP INDEX IDX_F52993985713BC80 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP addresses_id');
    }
}
