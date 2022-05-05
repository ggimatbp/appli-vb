<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211210102000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_catalog_files_bp DROP FOREIGN KEY FK_A73F4BCD7975B7E7');
        $this->addSql('ALTER TABLE ap_catalog_files_bp ADD CONSTRAINT FK_A73F4BCD7975B7E7 FOREIGN KEY (model_id) REFERENCES ap_catalog_model_bp (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_catalog_files_bp DROP FOREIGN KEY FK_A73F4BCD7975B7E7');
        $this->addSql('ALTER TABLE ap_catalog_files_bp ADD CONSTRAINT FK_A73F4BCD7975B7E7 FOREIGN KEY (model_id) REFERENCES ap_catalog_model_bp (id)');
    }
}
