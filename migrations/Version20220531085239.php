<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220531085239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ap_information_signature (id INT AUTO_INCREMENT NOT NULL, file_id INT DEFAULT NULL, user_id INT DEFAULT NULL, date_time DATETIME DEFAULT NULL, state TINYINT(1) NOT NULL, INDEX IDX_129088A293CB796C (file_id), INDEX IDX_129088A2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ap_information_signature ADD CONSTRAINT FK_129088A293CB796C FOREIGN KEY (file_id) REFERENCES ap_information_files (id)');
        $this->addSql('ALTER TABLE ap_information_signature ADD CONSTRAINT FK_129088A2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ap_information_signature');
    }
}
