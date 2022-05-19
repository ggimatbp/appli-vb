<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220329141615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_catalog_files_bp DROP FOREIGN KEY FK_A73F4BCD65EFA242');
        $this->addSql('DROP INDEX IDX_A73F4BCD65EFA242 ON ap_catalog_files_bp');
        $this->addSql('ALTER TABLE ap_catalog_files_bp DROP son_id, DROP status');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_catalog_files_bp ADD son_id INT DEFAULT NULL, ADD status INT NOT NULL');
        $this->addSql('ALTER TABLE ap_catalog_files_bp ADD CONSTRAINT FK_A73F4BCD65EFA242 FOREIGN KEY (son_id) REFERENCES ap_catalog_files_bp (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_A73F4BCD65EFA242 ON ap_catalog_files_bp (son_id)');
    }
}
