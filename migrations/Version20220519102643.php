<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220519102643 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ap_catalog_vb_bulk_image (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, case_is_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, archive TINYINT(1) NOT NULL, file_name VARCHAR(255) NOT NULL, file_size INT NOT NULL, file_type VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_DB27941EA76ED395 (user_id), INDEX IDX_DB27941EE0630B9D (case_is_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ap_catalog_vb_bulk_image ADD CONSTRAINT FK_DB27941EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ap_catalog_vb_bulk_image ADD CONSTRAINT FK_DB27941EE0630B9D FOREIGN KEY (case_is_id) REFERENCES ap_catalog_case_vb (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ap_catalog_vb_bulk_image');
    }
}
