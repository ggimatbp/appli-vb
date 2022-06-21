<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211210133326 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_catalog_customer_bp ADD archive TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE ap_catalog_files_bp ADD archive TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE ap_catalog_model_bp ADD archive TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_catalog_customer_bp DROP archive');
        $this->addSql('ALTER TABLE ap_catalog_files_bp DROP archive');
        $this->addSql('ALTER TABLE ap_catalog_model_bp DROP archive');
    }
}
