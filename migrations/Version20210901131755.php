<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210901131755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_access DROP FOREIGN KEY FK_6377037089E8BDC');
        $this->addSql('ALTER TABLE ap_access DROP FOREIGN KEY FK_63770370AB3B26CE');
        $this->addSql('DROP INDEX IDX_6377037089E8BDC ON ap_access');
        $this->addSql('DROP INDEX IDX_63770370AB3B26CE ON ap_access');
        $this->addSql('ALTER TABLE ap_access ADD tab_id INT NOT NULL, ADD role_id INT NOT NULL, DROP id_tab_id, DROP id_role_id');
        $this->addSql('ALTER TABLE ap_access ADD CONSTRAINT FK_637703708D0C9323 FOREIGN KEY (tab_id) REFERENCES ap_tab (id)');
        $this->addSql('ALTER TABLE ap_access ADD CONSTRAINT FK_63770370D60322AC FOREIGN KEY (role_id) REFERENCES ap_role (id)');
        $this->addSql('CREATE INDEX IDX_637703708D0C9323 ON ap_access (tab_id)');
        $this->addSql('CREATE INDEX IDX_63770370D60322AC ON ap_access (role_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_access DROP FOREIGN KEY FK_637703708D0C9323');
        $this->addSql('ALTER TABLE ap_access DROP FOREIGN KEY FK_63770370D60322AC');
        $this->addSql('DROP INDEX IDX_637703708D0C9323 ON ap_access');
        $this->addSql('DROP INDEX IDX_63770370D60322AC ON ap_access');
        $this->addSql('ALTER TABLE ap_access ADD id_tab_id INT NOT NULL, ADD id_role_id INT NOT NULL, DROP tab_id, DROP role_id');
        $this->addSql('ALTER TABLE ap_access ADD CONSTRAINT FK_6377037089E8BDC FOREIGN KEY (id_role_id) REFERENCES ap_role (id)');
        $this->addSql('ALTER TABLE ap_access ADD CONSTRAINT FK_63770370AB3B26CE FOREIGN KEY (id_tab_id) REFERENCES ap_tab (id)');
        $this->addSql('CREATE INDEX IDX_6377037089E8BDC ON ap_access (id_role_id)');
        $this->addSql('CREATE INDEX IDX_63770370AB3B26CE ON ap_access (id_tab_id)');
    }
}
