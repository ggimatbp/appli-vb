<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211123095020 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_catalog_files_bp ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ap_catalog_files_bp ADD CONSTRAINT FK_A73F4BCDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_A73F4BCDA76ED395 ON ap_catalog_files_bp (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_catalog_files_bp DROP FOREIGN KEY FK_A73F4BCDA76ED395');
        $this->addSql('DROP INDEX IDX_A73F4BCDA76ED395 ON ap_catalog_files_bp');
        $this->addSql('ALTER TABLE ap_catalog_files_bp DROP user_id');
    }
}
