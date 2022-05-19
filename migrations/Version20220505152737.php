<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220505152737 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ap_information_files (id INT AUTO_INCREMENT NOT NULL, section_id INT NOT NULL, name VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_size INT NOT NULL, file_type VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, archive TINYINT(1) NOT NULL, INDEX IDX_F3D40CC4D823E37A (section_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ap_information_parent_section (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, state INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ap_information_section (id INT AUTO_INCREMENT NOT NULL, parent_section_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, state INT NOT NULL, INDEX IDX_96F676E29F60672A (parent_section_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ap_information_files ADD CONSTRAINT FK_F3D40CC4D823E37A FOREIGN KEY (section_id) REFERENCES ap_information_section (id)');
        $this->addSql('ALTER TABLE ap_information_section ADD CONSTRAINT FK_96F676E29F60672A FOREIGN KEY (parent_section_id) REFERENCES ap_information_parent_section (id)');
        $this->addSql('ALTER TABLE ps_adress DROP longitude');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_information_section DROP FOREIGN KEY FK_96F676E29F60672A');
        $this->addSql('ALTER TABLE ap_information_files DROP FOREIGN KEY FK_F3D40CC4D823E37A');
        $this->addSql('DROP TABLE ap_information_files');
        $this->addSql('DROP TABLE ap_information_parent_section');
        $this->addSql('DROP TABLE ap_information_section');
        $this->addSql('ALTER TABLE ps_adress ADD longitude DOUBLE PRECISION DEFAULT NULL');
    }
}
