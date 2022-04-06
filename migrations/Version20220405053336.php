<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220405053336 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ap_catalog_files_bp_history (id INT AUTO_INCREMENT NOT NULL, user INT NOT NULL, file INT NOT NULL, update_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', action VARCHAR(255) NOT NULL, model_name VARCHAR(255) NOT NULL, doc_name VARCHAR(510) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ap_global_history (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, object_id INT NOT NULL, entity_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, action VARCHAR(255) NOT NULL, extra LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ps_adress (id INT AUTO_INCREMENT NOT NULL, id_country INT DEFAULT NULL, id_state INT DEFAULT NULL, id_customer INT DEFAULT NULL, id_manufacturer INT DEFAULT NULL, id_supplier INT DEFAULT NULL, id_warehouse INT DEFAULT NULL, alias VARCHAR(255) DEFAULT NULL, company VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, firstname VARCHAR(255) NOT NULL, address2 VARCHAR(255) DEFAULT NULL, postcode VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, other LONGTEXT DEFAULT NULL, phone VARCHAR(32) DEFAULT NULL, phone_mobile VARCHAR(255) DEFAULT NULL, vat_number VARCHAR(255) DEFAULT NULL, dni VARCHAR(16) DEFAULT NULL, date_add DATETIME DEFAULT NULL, date_upd DATETIME DEFAULT NULL, active TINYINT(1) DEFAULT NULL, deleted TINYINT(1) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, id_address INT NOT NULL, address1 VARCHAR(255) DEFAULT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ps_customer (id INT AUTO_INCREMENT NOT NULL, id_customer INT NOT NULL, alias VARCHAR(255) DEFAULT NULL, company VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, firstname VARCHAR(255) DEFAULT NULL, address1 VARCHAR(255) DEFAULT NULL, address2 VARCHAR(255) DEFAULT NULL, postcode VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, other VARCHAR(1020) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, phone_mobile VARCHAR(255) DEFAULT NULL, vat_number VARCHAR(255) DEFAULT NULL, dni VARCHAR(255) DEFAULT NULL, date_add DATETIME DEFAULT NULL, date_upd DATETIME DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ps_full_customer (id INT AUTO_INCREMENT NOT NULL, id_shop INT DEFAULT NULL, id_default_group INT DEFAULT NULL, company VARCHAR(510) DEFAULT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, date_add DATETIME DEFAULT NULL, date_upd DATETIME DEFAULT NULL, id_customer INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ps_group_lang (id INT AUTO_INCREMENT NOT NULL, id_lang INT NOT NULL, name VARCHAR(255) NOT NULL, id_group INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ps_order (id INT AUTO_INCREMENT NOT NULL, id_shop INT DEFAULT NULL, id_customer INT DEFAULT NULL, date_add DATETIME NOT NULL, date_upd DATETIME NOT NULL, id_order INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ap_catalog_files_bp_history');
        $this->addSql('DROP TABLE ap_global_history');
        $this->addSql('DROP TABLE ps_adress');
        $this->addSql('DROP TABLE ps_customer');
        $this->addSql('DROP TABLE ps_full_customer');
        $this->addSql('DROP TABLE ps_group_lang');
        $this->addSql('DROP TABLE ps_order');
    }
}
