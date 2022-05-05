<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210908125206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_tab ADD ap_tab_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ap_tab ADD CONSTRAINT FK_94741879E812BB07 FOREIGN KEY (ap_tab_id) REFERENCES ap_tab (id)');
        $this->addSql('CREATE INDEX IDX_94741879E812BB07 ON ap_tab (ap_tab_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_tab DROP FOREIGN KEY FK_94741879E812BB07');
        $this->addSql('DROP INDEX IDX_94741879E812BB07 ON ap_tab');
        $this->addSql('ALTER TABLE ap_tab DROP ap_tab_id');
    }
}
