<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210901121847 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ap_access (id INT AUTO_INCREMENT NOT NULL, id_tab_id INT NOT NULL, id_role_id INT NOT NULL, _view TINYINT(1) NOT NULL, _add TINYINT(1) NOT NULL, _edit TINYINT(1) NOT NULL, INDEX IDX_63770370AB3B26CE (id_tab_id), INDEX IDX_6377037089E8BDC (id_role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ap_access ADD CONSTRAINT FK_63770370AB3B26CE FOREIGN KEY (id_tab_id) REFERENCES ap_tab (id)');
        $this->addSql('ALTER TABLE ap_access ADD CONSTRAINT FK_6377037089E8BDC FOREIGN KEY (id_role_id) REFERENCES ap_role (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ap_access');
    }
}
