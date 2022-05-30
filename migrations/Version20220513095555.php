<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220513095555 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_information_parapher DROP FOREIGN KEY FK_F37BB7D8D5C72E60');
        $this->addSql('ALTER TABLE ap_information_parapher ADD CONSTRAINT FK_F37BB7D8D5C72E60 FOREIGN KEY (file_id_id) REFERENCES ap_information_files (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_information_parapher DROP FOREIGN KEY FK_F37BB7D8D5C72E60');
        $this->addSql('ALTER TABLE ap_information_parapher ADD CONSTRAINT FK_F37BB7D8D5C72E60 FOREIGN KEY (file_id_id) REFERENCES ap_information_files (id)');
    }
}
