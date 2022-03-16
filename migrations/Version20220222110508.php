<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220222110508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ap_sector_bp (id INT AUTO_INCREMENT NOT NULL, model_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_BFADB8417975B7E7 (model_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ap_sector_bp ADD CONSTRAINT FK_BFADB8417975B7E7 FOREIGN KEY (model_id) REFERENCES ap_catalog_model_bp (id)');
        $this->addSql('ALTER TABLE ap_catalog_files_bp ADD relation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ap_catalog_files_bp ADD CONSTRAINT FK_A73F4BCD3256915B FOREIGN KEY (relation_id) REFERENCES ap_sector_bp (id)');
        $this->addSql('CREATE INDEX IDX_A73F4BCD3256915B ON ap_catalog_files_bp (relation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_catalog_files_bp DROP FOREIGN KEY FK_A73F4BCD3256915B');
        $this->addSql('DROP TABLE ap_sector_bp');
        $this->addSql('DROP INDEX IDX_A73F4BCD3256915B ON ap_catalog_files_bp');
        $this->addSql('ALTER TABLE ap_catalog_files_bp DROP relation_id');
    }
}
