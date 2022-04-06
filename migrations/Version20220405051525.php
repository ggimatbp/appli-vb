<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220405051525 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ap_access (id INT AUTO_INCREMENT NOT NULL, tab_id INT NOT NULL, role_id INT NOT NULL, _view TINYINT(1) NOT NULL, _add TINYINT(1) NOT NULL, _edit TINYINT(1) NOT NULL, _delete TINYINT(1) NOT NULL, INDEX IDX_637703708D0C9323 (tab_id), INDEX IDX_63770370D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ap_catalog_case_vb (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, archive TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ap_catalog_customer_bp (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, archive TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ap_catalog_files_bp (id INT AUTO_INCREMENT NOT NULL, model_id INT DEFAULT NULL, user_id INT DEFAULT NULL, relation_id INT DEFAULT NULL, file_name VARCHAR(255) NOT NULL, file_size INT NOT NULL, file_type VARCHAR(10) NOT NULL, created_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, archive TINYINT(1) NOT NULL, INDEX IDX_A73F4BCD7975B7E7 (model_id), INDEX IDX_A73F4BCDA76ED395 (user_id), INDEX IDX_A73F4BCD3256915B (relation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ap_catalog_files_vb (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, case_id_id INT DEFAULT NULL, sector_id INT NOT NULL, name VARCHAR(255) NOT NULL, archive TINYINT(1) NOT NULL, file_name VARCHAR(255) NOT NULL, file_size INT NOT NULL, file_type VARCHAR(10) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_7A28EDD0A76ED395 (user_id), INDEX IDX_7A28EDD02DAD64BB (case_id_id), INDEX IDX_7A28EDD0DE95C867 (sector_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ap_catalog_model_bp (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, name VARCHAR(255) NOT NULL, archive TINYINT(1) NOT NULL, INDEX IDX_7DACA7059395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ap_role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ap_sector_bp (id INT AUTO_INCREMENT NOT NULL, model_id INT NOT NULL, name VARCHAR(255) NOT NULL, archive TINYINT(1) NOT NULL, INDEX IDX_BFADB8417975B7E7 (model_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ap_sector_vb (id INT AUTO_INCREMENT NOT NULL, case_id_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, archive TINYINT(1) NOT NULL, INDEX IDX_62BA1E5C2DAD64BB (case_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ap_tab (id INT AUTO_INCREMENT NOT NULL, ap_tab_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, path VARCHAR(255) DEFAULT NULL, control_path VARCHAR(255) DEFAULT NULL, position INT DEFAULT NULL, INDEX IDX_94741879E812BB07 (ap_tab_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, role_id_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, theme INT DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D64988987678 (role_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ap_access ADD CONSTRAINT FK_637703708D0C9323 FOREIGN KEY (tab_id) REFERENCES ap_tab (id)');
        $this->addSql('ALTER TABLE ap_access ADD CONSTRAINT FK_63770370D60322AC FOREIGN KEY (role_id) REFERENCES ap_role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ap_catalog_files_bp ADD CONSTRAINT FK_A73F4BCD7975B7E7 FOREIGN KEY (model_id) REFERENCES ap_catalog_model_bp (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ap_catalog_files_bp ADD CONSTRAINT FK_A73F4BCDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ap_catalog_files_bp ADD CONSTRAINT FK_A73F4BCD3256915B FOREIGN KEY (relation_id) REFERENCES ap_sector_bp (id)');
        $this->addSql('ALTER TABLE ap_catalog_files_vb ADD CONSTRAINT FK_7A28EDD0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ap_catalog_files_vb ADD CONSTRAINT FK_7A28EDD02DAD64BB FOREIGN KEY (case_id_id) REFERENCES ap_catalog_case_vb (id)');
        $this->addSql('ALTER TABLE ap_catalog_files_vb ADD CONSTRAINT FK_7A28EDD0DE95C867 FOREIGN KEY (sector_id) REFERENCES ap_sector_vb (id)');
        $this->addSql('ALTER TABLE ap_catalog_model_bp ADD CONSTRAINT FK_7DACA7059395C3F3 FOREIGN KEY (customer_id) REFERENCES ap_catalog_customer_bp (id)');
        $this->addSql('ALTER TABLE ap_sector_bp ADD CONSTRAINT FK_BFADB8417975B7E7 FOREIGN KEY (model_id) REFERENCES ap_catalog_model_bp (id)');
        $this->addSql('ALTER TABLE ap_sector_vb ADD CONSTRAINT FK_62BA1E5C2DAD64BB FOREIGN KEY (case_id_id) REFERENCES ap_catalog_case_vb (id)');
        $this->addSql('ALTER TABLE ap_tab ADD CONSTRAINT FK_94741879E812BB07 FOREIGN KEY (ap_tab_id) REFERENCES ap_tab (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64988987678 FOREIGN KEY (role_id_id) REFERENCES ap_role (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_catalog_files_vb DROP FOREIGN KEY FK_7A28EDD02DAD64BB');
        $this->addSql('ALTER TABLE ap_sector_vb DROP FOREIGN KEY FK_62BA1E5C2DAD64BB');
        $this->addSql('ALTER TABLE ap_catalog_model_bp DROP FOREIGN KEY FK_7DACA7059395C3F3');
        $this->addSql('ALTER TABLE ap_catalog_files_bp DROP FOREIGN KEY FK_A73F4BCD7975B7E7');
        $this->addSql('ALTER TABLE ap_sector_bp DROP FOREIGN KEY FK_BFADB8417975B7E7');
        $this->addSql('ALTER TABLE ap_access DROP FOREIGN KEY FK_63770370D60322AC');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64988987678');
        $this->addSql('ALTER TABLE ap_catalog_files_bp DROP FOREIGN KEY FK_A73F4BCD3256915B');
        $this->addSql('ALTER TABLE ap_catalog_files_vb DROP FOREIGN KEY FK_7A28EDD0DE95C867');
        $this->addSql('ALTER TABLE ap_access DROP FOREIGN KEY FK_637703708D0C9323');
        $this->addSql('ALTER TABLE ap_tab DROP FOREIGN KEY FK_94741879E812BB07');
        $this->addSql('ALTER TABLE ap_catalog_files_bp DROP FOREIGN KEY FK_A73F4BCDA76ED395');
        $this->addSql('ALTER TABLE ap_catalog_files_vb DROP FOREIGN KEY FK_7A28EDD0A76ED395');
        $this->addSql('DROP TABLE ap_access');
        $this->addSql('DROP TABLE ap_catalog_case_vb');
        $this->addSql('DROP TABLE ap_catalog_customer_bp');
        $this->addSql('DROP TABLE ap_catalog_files_bp');
        $this->addSql('DROP TABLE ap_catalog_files_vb');
        $this->addSql('DROP TABLE ap_catalog_model_bp');
        $this->addSql('DROP TABLE ap_role');
        $this->addSql('DROP TABLE ap_sector_bp');
        $this->addSql('DROP TABLE ap_sector_vb');
        $this->addSql('DROP TABLE ap_tab');
        $this->addSql('DROP TABLE user');
    }
}
