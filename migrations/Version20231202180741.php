<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231202180741 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, id_user INT NOT NULL, prodid INT NOT NULL, nomprod VARCHAR(150) NOT NULL, prix DOUBLE PRECISION NOT NULL, dateajout DATE NOT NULL, qte DOUBLE PRECISION NOT NULL, image VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE culture (id INT AUTO_INCREMENT NOT NULL, categorys_id INT DEFAULT NULL, libelle VARCHAR(200) NOT NULL, dateplantation DATE NOT NULL, daterecolte DATE NOT NULL, categorytype VARCHAR(150) NOT NULL, revenuescultures DOUBLE PRECISION NOT NULL, coutsplantations DOUBLE PRECISION NOT NULL, INDEX IDX_B6A99CEBA96778EC (categorys_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE culture ADD CONSTRAINT FK_B6A99CEBA96778EC FOREIGN KEY (categorys_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE annoncerecrutement CHANGE filter1 filter1 VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE produit ADD dateajout DATETIME NOT NULL, ADD datemodif DATETIME NOT NULL, CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reclamation ADD user_id INT DEFAULT NULL, ADD datemodif DATETIME NOT NULL, CHANGE dateajout dateajout DATETIME NOT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_CE606404A76ED395 ON reclamation (user_id)');
        $this->addSql('ALTER TABLE user ADD google_id VARCHAR(255) DEFAULT NULL, ADD reset_token VARCHAR(100) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE culture DROP FOREIGN KEY FK_B6A99CEBA96778EC');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE culture');
        $this->addSql('ALTER TABLE annoncerecrutement CHANGE filter1 filter1 VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE `produit` DROP dateajout, DROP datemodif, CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404A76ED395');
        $this->addSql('DROP INDEX IDX_CE606404A76ED395 ON reclamation');
        $this->addSql('ALTER TABLE reclamation DROP user_id, DROP datemodif, CHANGE dateajout dateajout DATE NOT NULL');
        $this->addSql('ALTER TABLE `user` DROP google_id, DROP reset_token');
    }
}
