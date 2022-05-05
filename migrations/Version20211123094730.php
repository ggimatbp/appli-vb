<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211123094730 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_catalog_files_bp DROP FOREIGN KEY FK_A73F4BCDA76ED395');
        $this->addSql('DROP INDEX IDX_A73F4BCDA76ED395 ON ap_catalog_files_bp');
        $this->addSql('ALTER TABLE ap_catalog_files_bp ADD file_name VARCHAR(255) NOT NULL, ADD file_size INT NOT NULL, ADD file_type VARCHAR(10) NOT NULL, CHANGE user_id model_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ap_catalog_files_bp ADD CONSTRAINT FK_A73F4BCD7975B7E7 FOREIGN KEY (model_id) REFERENCES ap_catalog_model_bp (id)');
        $this->addSql('CREATE INDEX IDX_A73F4BCD7975B7E7 ON ap_catalog_files_bp (model_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_catalog_files_bp DROP FOREIGN KEY FK_A73F4BCD7975B7E7');
        $this->addSql('DROP INDEX IDX_A73F4BCD7975B7E7 ON ap_catalog_files_bp');
        $this->addSql('ALTER TABLE ap_catalog_files_bp DROP file_name, DROP file_size, DROP file_type, CHANGE model_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ap_catalog_files_bp ADD CONSTRAINT FK_A73F4BCDA76ED395 FOREIGN KEY (user_id) REFERENCES ap_catalog_model_bp (id)');
        $this->addSql('CREATE INDEX IDX_A73F4BCDA76ED395 ON ap_catalog_files_bp (user_id)');
    }
}
