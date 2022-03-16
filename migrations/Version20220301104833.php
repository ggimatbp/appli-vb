<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220301104833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ap_sector_vb (id INT AUTO_INCREMENT NOT NULL, case_id_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, archive TINYINT(1) NOT NULL, INDEX IDX_62BA1E5C2DAD64BB (case_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ap_sector_vb ADD CONSTRAINT FK_62BA1E5C2DAD64BB FOREIGN KEY (case_id_id) REFERENCES ap_catalog_case_vb (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ap_sector_vb');
    }
}
