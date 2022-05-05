<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210916132234 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_access DROP FOREIGN KEY FK_63770370D60322AC');
        $this->addSql('ALTER TABLE ap_access ADD CONSTRAINT FK_63770370D60322AC FOREIGN KEY (role_id) REFERENCES ap_role (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_access DROP FOREIGN KEY FK_63770370D60322AC');
        $this->addSql('ALTER TABLE ap_access ADD CONSTRAINT FK_63770370D60322AC FOREIGN KEY (role_id) REFERENCES ap_role (id)');
    }
}
