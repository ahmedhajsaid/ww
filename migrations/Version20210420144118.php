<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210420144118 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE acceptation_reservation (id INT AUTO_INCREMENT NOT NULL, client INT DEFAULT NULL, reservation INT DEFAULT NULL, acceptee TINYINT(1) DEFAULT NULL, INDEX client (client), INDEX reservation (reservation), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE acceptation_reservation ADD CONSTRAINT FK_B1460E66C7440455 FOREIGN KEY (client) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE acceptation_reservation ADD CONSTRAINT FK_B1460E6642C84955 FOREIGN KEY (reservation) REFERENCES reservation (id)');
        $this->addSql('ALTER TABLE utilisateur ADD is_verified TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE acceptation_reservation');
        $this->addSql('ALTER TABLE utilisateur DROP is_verified');
    }
}
