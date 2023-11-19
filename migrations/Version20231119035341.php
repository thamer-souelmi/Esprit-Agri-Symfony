<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231119035341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit ADD cat VARCHAR(255) NOT NULL, CHANGE Nomprod nomprod VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE cin cin VARCHAR(255) NOT NULL, CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE prenom prenom VARCHAR(255) NOT NULL, CHANGE mdp mdp VARCHAR(255) NOT NULL, CHANGE mail mail VARCHAR(255) NOT NULL, CHANGE adresse adresse INT NOT NULL, CHANGE role role VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `produit` DROP cat, CHANGE nomprod Nomprod VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE `user` CHANGE cin cin VARCHAR(20) NOT NULL, CHANGE nom nom VARCHAR(20) NOT NULL, CHANGE prenom prenom VARCHAR(20) NOT NULL, CHANGE mdp mdp VARCHAR(200) NOT NULL, CHANGE mail mail VARCHAR(30) NOT NULL, CHANGE adresse adresse VARCHAR(50) NOT NULL, CHANGE role role VARCHAR(50) NOT NULL');
    }
}
