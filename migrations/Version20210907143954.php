<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210907143954 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ap_access (id INT AUTO_INCREMENT NOT NULL, tab_id INT NOT NULL, role_id INT NOT NULL, _view TINYINT(1) NOT NULL, _add TINYINT(1) NOT NULL, _edit TINYINT(1) NOT NULL, _delete TINYINT(1) NOT NULL, INDEX IDX_637703708D0C9323 (tab_id), INDEX IDX_63770370D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ap_employee (id INT AUTO_INCREMENT NOT NULL, role_id INT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(80) NOT NULL, password VARCHAR(255) NOT NULL, notification TINYINT(1) NOT NULL, active TINYINT(1) NOT NULL, checkin TINYINT(1) NOT NULL, hour_count INT NOT NULL, weekly_hour INT NOT NULL, INDEX IDX_99C259E3D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ap_role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, json_role JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ap_tab (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, role_id_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D64988987678 (role_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ap_access ADD CONSTRAINT FK_637703708D0C9323 FOREIGN KEY (tab_id) REFERENCES ap_tab (id)');
        $this->addSql('ALTER TABLE ap_access ADD CONSTRAINT FK_63770370D60322AC FOREIGN KEY (role_id) REFERENCES ap_role (id)');
        $this->addSql('ALTER TABLE ap_employee ADD CONSTRAINT FK_99C259E3D60322AC FOREIGN KEY (role_id) REFERENCES ap_role (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64988987678 FOREIGN KEY (role_id_id) REFERENCES ap_role (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_access DROP FOREIGN KEY FK_63770370D60322AC');
        $this->addSql('ALTER TABLE ap_employee DROP FOREIGN KEY FK_99C259E3D60322AC');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64988987678');
        $this->addSql('ALTER TABLE ap_access DROP FOREIGN KEY FK_637703708D0C9323');
        $this->addSql('DROP TABLE ap_access');
        $this->addSql('DROP TABLE ap_employee');
        $this->addSql('DROP TABLE ap_role');
        $this->addSql('DROP TABLE ap_tab');
        $this->addSql('DROP TABLE user');
    }
}
