<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240205103256 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sub_category_product (sub_category_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_BF59C2FAF7BFE87C (sub_category_id), INDEX IDX_BF59C2FA4584665A (product_id), PRIMARY KEY(sub_category_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sub_category_product ADD CONSTRAINT FK_BF59C2FAF7BFE87C FOREIGN KEY (sub_category_id) REFERENCES sub_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sub_category_product ADD CONSTRAINT FK_BF59C2FA4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sub_category DROP FOREIGN KEY FK_BCE3F7984584665A');
        $this->addSql('DROP INDEX IDX_BCE3F7984584665A ON sub_category');
        $this->addSql('ALTER TABLE sub_category DROP product_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sub_category_product DROP FOREIGN KEY FK_BF59C2FAF7BFE87C');
        $this->addSql('ALTER TABLE sub_category_product DROP FOREIGN KEY FK_BF59C2FA4584665A');
        $this->addSql('DROP TABLE sub_category_product');
        $this->addSql('ALTER TABLE sub_category ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sub_category ADD CONSTRAINT FK_BCE3F7984584665A FOREIGN KEY (product_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_BCE3F7984584665A ON sub_category (product_id)');
    }
}
