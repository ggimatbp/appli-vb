<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220428155433 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_information_section ADD parent_section_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ap_information_section ADD CONSTRAINT FK_96F676E29F60672A FOREIGN KEY (parent_section_id) REFERENCES ap_information_parent_section (id)');
        $this->addSql('CREATE INDEX IDX_96F676E29F60672A ON ap_information_section (parent_section_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_information_section DROP FOREIGN KEY FK_96F676E29F60672A');
        $this->addSql('DROP INDEX IDX_96F676E29F60672A ON ap_information_section');
        $this->addSql('ALTER TABLE ap_information_section DROP parent_section_id');
    }
}
