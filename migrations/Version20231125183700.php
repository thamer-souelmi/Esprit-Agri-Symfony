<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231125183700 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annoncerecrutement (idRecrut INT AUTO_INCREMENT NOT NULL, poste_demande VARCHAR(255) NOT NULL, salaire_propose DOUBLE PRECISION NOT NULL, type_contrat VARCHAR(255) NOT NULL, date_pub DATE NOT NULL, localisation VARCHAR(25) NOT NULL, date_embauche DATE NOT NULL, nb_poste_recherche INT NOT NULL, PRIMARY KEY(idRecrut)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candidature (idCandidature INT AUTO_INCREMENT NOT NULL, experienceprofessionnelle VARCHAR(5000) NOT NULL, formation VARCHAR(5000) NOT NULL, competencestechniques VARCHAR(5000) NOT NULL, certifforma VARCHAR(200) NOT NULL, messagemotivation VARCHAR(255) NOT NULL, datecandidature DATE NOT NULL, statuscandidature TINYINT(1) NOT NULL, PRIMARY KEY(idCandidature)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ouvrier DROP cinOuvrier, DROP nomOuvrier, DROP prenomOuvrier, DROP dateNaissance, DROP genre, DROP email, DROP adresse, DROP phone, DROP userId, DROP photo');
        $this->addSql('ALTER TABLE produit ADD descr VARCHAR(255) NOT NULL, DROP `desc`, CHANGE Nomprod nomprod VARCHAR(255) NOT NULL, CHANGE cat cat VARCHAR(255) NOT NULL, CHANGE image image VARCHAR(255) NOT NULL, CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27A76ED395 ON produit (user_id)');
        $this->addSql('ALTER TABLE traitementmedicale ADD idvet INT DEFAULT NULL, DROP etatDeSante, CHANGE typeIntervMed typeintervmed VARCHAR(200) NOT NULL, CHANGE veterinaire description VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE traitementmedicale ADD CONSTRAINT FK_A207FE66F9DABC50 FOREIGN KEY (idvet) REFERENCES veterinaire (idvet)');
        $this->addSql('CREATE INDEX IDX_A207FE66F9DABC50 ON traitementmedicale (idvet)');
        $this->addSql('ALTER TABLE user ADD is_banned TINYINT(1) DEFAULT NULL, ADD ban_expires_at VARCHAR(255) DEFAULT NULL, ADD is_verified TINYINT(1) NOT NULL, CHANGE cin cin VARCHAR(255) NOT NULL, CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE prenom prenom VARCHAR(255) NOT NULL, CHANGE mdp mdp VARCHAR(255) NOT NULL, CHANGE mail mail VARCHAR(255) NOT NULL, CHANGE adresse adresse VARCHAR(255) NOT NULL, CHANGE image image VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE annoncerecrutement');
        $this->addSql('DROP TABLE candidature');
        $this->addSql('ALTER TABLE ouvrier ADD cinOuvrier VARCHAR(200) NOT NULL, ADD nomOuvrier VARCHAR(200) NOT NULL, ADD prenomOuvrier VARCHAR(200) NOT NULL, ADD dateNaissance DATE NOT NULL, ADD genre VARCHAR(255) NOT NULL, ADD email VARCHAR(200) NOT NULL, ADD adresse VARCHAR(200) NOT NULL, ADD phone VARCHAR(200) NOT NULL, ADD userId INT DEFAULT NULL, ADD photo VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE `produit` DROP FOREIGN KEY FK_29A5EC27A76ED395');
        $this->addSql('DROP INDEX IDX_29A5EC27A76ED395 ON `produit`');
        $this->addSql('ALTER TABLE `produit` ADD `desc` DATE NOT NULL, DROP descr, CHANGE user_id user_id INT DEFAULT NULL, CHANGE nomprod Nomprod VARCHAR(30) NOT NULL, CHANGE cat cat VARCHAR(30) NOT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE traitementmedicale DROP FOREIGN KEY FK_A207FE66F9DABC50');
        $this->addSql('DROP INDEX IDX_A207FE66F9DABC50 ON traitementmedicale');
        $this->addSql('ALTER TABLE traitementmedicale ADD etatDeSante VARCHAR(255) NOT NULL, DROP idvet, CHANGE typeintervmed typeIntervMed VARCHAR(255) NOT NULL, CHANGE description veterinaire VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE `user` DROP is_banned, DROP ban_expires_at, DROP is_verified, CHANGE cin cin INT NOT NULL, CHANGE nom nom VARCHAR(20) NOT NULL, CHANGE prenom prenom VARCHAR(20) NOT NULL, CHANGE mdp mdp VARCHAR(200) NOT NULL, CHANGE mail mail VARCHAR(30) NOT NULL, CHANGE adresse adresse VARCHAR(50) NOT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL');
    }
}
