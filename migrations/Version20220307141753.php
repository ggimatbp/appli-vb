<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220307141753 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ps_adress ADD id_address INT NOT NULL');
        $this->addSql('ALTER TABLE ps_full_customer ADD id_customer INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ps_group_lang ADD id_group INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ps_order ADD id_order INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ps_adress DROP id_address');
        $this->addSql('ALTER TABLE ps_full_customer DROP id_customer');
        $this->addSql('ALTER TABLE ps_group_lang DROP id_group');
        $this->addSql('ALTER TABLE ps_order DROP id_order');
    }
}
