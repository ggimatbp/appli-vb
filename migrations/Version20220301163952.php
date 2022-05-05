<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220301163952 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ap_catalog_files_vb (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, case_id_id INT DEFAULT NULL, sector_id INT NOT NULL, name VARCHAR(255) NOT NULL, archive TINYINT(1) NOT NULL, file_name VARCHAR(255) NOT NULL, file_size INT NOT NULL, file_type VARCHAR(10) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7A28EDD0A76ED395 (user_id), INDEX IDX_7A28EDD02DAD64BB (case_id_id), INDEX IDX_7A28EDD0DE95C867 (sector_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ap_catalog_files_vb ADD CONSTRAINT FK_7A28EDD0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ap_catalog_files_vb ADD CONSTRAINT FK_7A28EDD02DAD64BB FOREIGN KEY (case_id_id) REFERENCES ap_catalog_case_vb (id)');
        $this->addSql('ALTER TABLE ap_catalog_files_vb ADD CONSTRAINT FK_7A28EDD0DE95C867 FOREIGN KEY (sector_id) REFERENCES ap_sector_vb (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ap_catalog_files_vb');
    }
}
