<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211210082421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_catalog_files_bp_history DROP FOREIGN KEY FK_C37614AD93CB796C');
        $this->addSql('ALTER TABLE ap_catalog_files_bp_history DROP FOREIGN KEY FK_C37614ADA76ED395');
        $this->addSql('DROP INDEX IDX_C37614AD93CB796C ON ap_catalog_files_bp_history');
        $this->addSql('DROP INDEX IDX_C37614ADA76ED395 ON ap_catalog_files_bp_history');
        $this->addSql('ALTER TABLE ap_catalog_files_bp_history ADD user INT NOT NULL, ADD file INT NOT NULL, DROP user_id, DROP file_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_catalog_files_bp_history ADD user_id INT DEFAULT NULL, ADD file_id INT DEFAULT NULL, DROP user, DROP file');
        $this->addSql('ALTER TABLE ap_catalog_files_bp_history ADD CONSTRAINT FK_C37614AD93CB796C FOREIGN KEY (file_id) REFERENCES ap_catalog_files_bp (id)');
        $this->addSql('ALTER TABLE ap_catalog_files_bp_history ADD CONSTRAINT FK_C37614ADA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C37614AD93CB796C ON ap_catalog_files_bp_history (file_id)');
        $this->addSql('CREATE INDEX IDX_C37614ADA76ED395 ON ap_catalog_files_bp_history (user_id)');
    }
}
