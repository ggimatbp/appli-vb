<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210901133200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_employee ADD role_id INT NOT NULL');
        $this->addSql('ALTER TABLE ap_employee ADD CONSTRAINT FK_99C259E3D60322AC FOREIGN KEY (role_id) REFERENCES ap_role (id)');
        $this->addSql('CREATE INDEX IDX_99C259E3D60322AC ON ap_employee (role_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_employee DROP FOREIGN KEY FK_99C259E3D60322AC');
        $this->addSql('DROP INDEX IDX_99C259E3D60322AC ON ap_employee');
        $this->addSql('ALTER TABLE ap_employee DROP role_id');
    }
}
