<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220512121030 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ap_information_parapher (id INT AUTO_INCREMENT NOT NULL, file_id_id INT DEFAULT NULL, user_id_id INT DEFAULT NULL, date_time DATETIME DEFAULT NULL, state TINYINT(1) NOT NULL, INDEX IDX_F37BB7D8D5C72E60 (file_id_id), UNIQUE INDEX UNIQ_F37BB7D89D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ap_information_parapher ADD CONSTRAINT FK_F37BB7D8D5C72E60 FOREIGN KEY (file_id_id) REFERENCES ap_information_files (id)');
        $this->addSql('ALTER TABLE ap_information_parapher ADD CONSTRAINT FK_F37BB7D89D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ap_information_parapher');
    }
}
