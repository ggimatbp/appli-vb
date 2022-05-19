<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220304134953 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ps_customer (id INT AUTO_INCREMENT NOT NULL, id_customer INT NOT NULL, alias VARCHAR(255) DEFAULT NULL, company VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, firstname VARCHAR(255) DEFAULT NULL, address1 VARCHAR(255) DEFAULT NULL, address2 VARCHAR(255) DEFAULT NULL, postcode INT NOT NULL, city VARCHAR(255) DEFAULT NULL, other VARCHAR(255) DEFAULT NULL, phone INT DEFAULT NULL, phone_mobile INT DEFAULT NULL, vat_number VARCHAR(255) DEFAULT NULL, dni VARCHAR(255) DEFAULT NULL, date_add DATETIME DEFAULT NULL, date_upd DATETIME DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ap_catalog_files_vb CHANGE created_at created_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ps_customer');
        $this->addSql('ALTER TABLE ap_catalog_files_vb CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
