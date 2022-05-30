<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220513101703 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_information_parapher DROP FOREIGN KEY FK_F37BB7D89D86650F');
        $this->addSql('DROP INDEX UNIQ_F37BB7D89D86650F ON ap_information_parapher');
        $this->addSql('ALTER TABLE ap_information_parapher CHANGE user_id_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ap_information_parapher ADD CONSTRAINT FK_F37BB7D8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_F37BB7D8A76ED395 ON ap_information_parapher (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_information_parapher DROP FOREIGN KEY FK_F37BB7D8A76ED395');
        $this->addSql('DROP INDEX IDX_F37BB7D8A76ED395 ON ap_information_parapher');
        $this->addSql('ALTER TABLE ap_information_parapher CHANGE user_id user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ap_information_parapher ADD CONSTRAINT FK_F37BB7D89D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F37BB7D89D86650F ON ap_information_parapher (user_id_id)');
    }
}
