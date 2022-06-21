<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220620092136 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_information_signature DROP FOREIGN KEY FK_129088A293CB796C');
        $this->addSql('ALTER TABLE ap_information_signature ADD CONSTRAINT FK_129088A293CB796C FOREIGN KEY (file_id) REFERENCES ap_information_files (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ap_information_viewed DROP FOREIGN KEY FK_79C317B193CB796C');
        $this->addSql('ALTER TABLE ap_information_viewed ADD CONSTRAINT FK_79C317B193CB796C FOREIGN KEY (file_id) REFERENCES ap_information_files (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ap_information_signature DROP FOREIGN KEY FK_129088A293CB796C');
        $this->addSql('ALTER TABLE ap_information_signature ADD CONSTRAINT FK_129088A293CB796C FOREIGN KEY (file_id) REFERENCES ap_information_files (id)');
        $this->addSql('ALTER TABLE ap_information_viewed DROP FOREIGN KEY FK_79C317B193CB796C');
        $this->addSql('ALTER TABLE ap_information_viewed ADD CONSTRAINT FK_79C317B193CB796C FOREIGN KEY (file_id) REFERENCES ap_information_files (id)');
    }
}
