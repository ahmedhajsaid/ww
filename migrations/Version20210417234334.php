<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210417234334 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, equipe_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, raison_sociale VARCHAR(255) NOT NULL, matricule_fiscale VARCHAR(255) NOT NULL, verifie TINYINT(1) NOT NULL, solde_point INT NOT NULL, position VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, position_equipe INT NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3E7927C74 (email), INDEX IDX_1D1C63B3BCF5E72D (categorie_id), INDEX IDX_1D1C63B36D861B89 (equipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B36D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE acceptation_reservation DROP FOREIGN KEY FK_B1460E66C7440455');
        $this->addSql('ALTER TABLE competition DROP FOREIGN KEY FK_B50A2CB1EED29F2F');
        $this->addSql('ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA153AFA2DF0');
        $this->addSql('ALTER TABLE invitation DROP FOREIGN KEY FK_F11D61A21D1C63B3');
        $this->addSql('ALTER TABLE penalite DROP FOREIGN KEY FK_C62D8C5DEED29F2F');
        $this->addSql('ALTER TABLE penalite_joueur DROP FOREIGN KEY FK_454548FD20B2E66E');
        $this->addSql('ALTER TABLE penalite_joueur DROP FOREIGN KEY FK_454548FDFD71A9C5');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955C7440455');
        $this->addSql('ALTER TABLE terrain DROP FOREIGN KEY FK_C87653B1EED29F2F');
        $this->addSql('DROP TABLE utilisateur');
    }
}
