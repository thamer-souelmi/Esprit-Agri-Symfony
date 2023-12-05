<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231202184806 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE culture (id INT AUTO_INCREMENT NOT NULL, categorys_id INT DEFAULT NULL, libelle VARCHAR(200) NOT NULL, dateplantation DATE NOT NULL, daterecolte DATE NOT NULL, categorytype VARCHAR(150) NOT NULL, revenuescultures DOUBLE PRECISION NOT NULL, coutsplantations DOUBLE PRECISION NOT NULL, INDEX IDX_B6A99CEBA96778EC (categorys_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE culture ADD CONSTRAINT FK_B6A99CEBA96778EC FOREIGN KEY (categorys_id) REFERENCES category (id)');
        $this->addSql('DROP TABLE annonceinvestissement');
        $this->addSql('DROP TABLE betail');
        $this->addSql('DROP TABLE bilancomptable');
        $this->addSql('DROP TABLE bilanresultat');
        $this->addSql('DROP TABLE entretien');
        $this->addSql('DROP TABLE equipe');
        $this->addSql('DROP TABLE marche');
        $this->addSql('DROP TABLE negociation');
        $this->addSql('DROP TABLE terrain');
        $this->addSql('ALTER TABLE annoncerecrutement ADD user_id INT DEFAULT NULL, ADD archived TINYINT(1) NOT NULL, CHANGE date_pub date_pub DATE NOT NULL');
        $this->addSql('ALTER TABLE annoncerecrutement ADD CONSTRAINT FK_58D406E2A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_58D406E2A76ED395 ON annoncerecrutement (user_id)');
        $this->addSql('ALTER TABLE candidature ADD idannrecru_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL, ADD archived TINYINT(1) NOT NULL, CHANGE ExperienceProfessionnelle experienceprofessionnelle VARCHAR(5000) NOT NULL, CHANGE Formation formation VARCHAR(5000) NOT NULL, CHANGE CompetencesTechniques competencestechniques VARCHAR(5000) NOT NULL, CHANGE CertifForma certifforma VARCHAR(200) NOT NULL, CHANGE statusCandidature statuscandidature TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B898FB9136 FOREIGN KEY (idannrecru_id) REFERENCES annoncerecrutement (idRecrut)');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B8A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_E33BD3B898FB9136 ON candidature (idannrecru_id)');
        $this->addSql('CREATE INDEX IDX_E33BD3B8A76ED395 ON candidature (user_id)');
        $this->addSql('ALTER TABLE category CHANGE type type VARCHAR(150) NOT NULL');
        $this->addSql('ALTER TABLE client ADD image VARCHAR(150) NOT NULL, CHANGE Nomprod nomprod VARCHAR(150) NOT NULL');
        $this->addSql('ALTER TABLE ouvrier DROP cinOuvrier, DROP nomOuvrier, DROP prenomOuvrier, DROP dateNaissance, DROP genre, DROP email, DROP adresse, DROP phone, DROP userId, DROP photo');
        $this->addSql('ALTER TABLE produit ADD descr VARCHAR(255) NOT NULL, ADD dateajout DATETIME NOT NULL, ADD datemodif DATETIME NOT NULL, DROP `desc`, CHANGE Nomprod nomprod VARCHAR(255) NOT NULL, CHANGE cat cat VARCHAR(255) NOT NULL, CHANGE image image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27A76ED395 ON produit (user_id)');
        $this->addSql('ALTER TABLE reclamation ADD user_id INT DEFAULT NULL, ADD datemodif DATETIME NOT NULL, CHANGE dateajout dateajout DATETIME NOT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_CE606404A76ED395 ON reclamation (user_id)');
        $this->addSql('ALTER TABLE user ADD google_authenticator_secret VARCHAR(255) DEFAULT NULL, ADD is_banned TINYINT(1) DEFAULT NULL, ADD ban_expires_at VARCHAR(255) DEFAULT NULL, ADD is_verified TINYINT(1) NOT NULL, ADD google_id VARCHAR(255) DEFAULT NULL, ADD reset_token VARCHAR(100) DEFAULT NULL, CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE prenom prenom VARCHAR(255) NOT NULL, CHANGE mdp mdp VARCHAR(255) NOT NULL, CHANGE mail mail VARCHAR(255) NOT NULL, CHANGE adresse adresse VARCHAR(255) NOT NULL, CHANGE image image VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonceinvestissement (idAnnonce INT AUTO_INCREMENT NOT NULL, titre VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, montant DOUBLE PRECISION NOT NULL, datePublication DATE NOT NULL, localisation VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(400) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo VARCHAR(500) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, iduser INT NOT NULL, PRIMARY KEY(idAnnonce)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE betail (id INT AUTO_INCREMENT NOT NULL, numero VARCHAR(11) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, categbetail VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, race VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, genre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, poids DOUBLE PRECISION NOT NULL, dateDeNaissance DATE NOT NULL, userId INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bilancomptable (idBilanC INT AUTO_INCREMENT NOT NULL, idUser INT NOT NULL, annee DATE NOT NULL, resultatNet DOUBLE PRECISION NOT NULL, valeurTerrain DOUBLE PRECISION NOT NULL, materiels DOUBLE PRECISION NOT NULL, autresImmobilisations DOUBLE PRECISION NOT NULL, stocksProduits DOUBLE PRECISION NOT NULL, creanceClient DOUBLE PRECISION NOT NULL, tresorie DOUBLE PRECISION NOT NULL, capitalSocial DOUBLE PRECISION NOT NULL, reserves DOUBLE PRECISION NOT NULL, emprunts DOUBLE PRECISION NOT NULL, dettesCT DOUBLE PRECISION NOT NULL, dettesIT DOUBLE PRECISION NOT NULL, fournisseurs DOUBLE PRECISION NOT NULL, PRIMARY KEY(idBilanC)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bilanresultat (idBilanR INT AUTO_INCREMENT NOT NULL, anneeR DATE NOT NULL, idUser INT NOT NULL, autreRevenus DOUBLE PRECISION NOT NULL, subvention DOUBLE PRECISION NOT NULL, revenuesCultures DOUBLE PRECISION NOT NULL, semences DOUBLE PRECISION NOT NULL, coutMainOeuvre DOUBLE PRECISION NOT NULL, coutInterventionMedicale DOUBLE PRECISION NOT NULL, coutsPlantations DOUBLE PRECISION NOT NULL, chargesElectricite DOUBLE PRECISION NOT NULL, chargeEntretien DOUBLE PRECISION NOT NULL, chargeAdministratives DOUBLE PRECISION NOT NULL, PRIMARY KEY(idBilanR)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE entretien (id INT AUTO_INCREMENT NOT NULL, userId INT NOT NULL, libelleTerrain INT NOT NULL, typeEntretien VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, dateEntretien VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, statusEntretien VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, descriptionEntretient VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, chargeEntretient DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE equipe (idEquipe INT AUTO_INCREMENT NOT NULL, tacheAttribut VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, libelleTerrain INT NOT NULL, dateDebut DATE NOT NULL, duree VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, userId INT DEFAULT NULL, NomEquipee VARCHAR(2000) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(idEquipe)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE marche (id INT AUTO_INCREMENT NOT NULL, Nomprod VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, cat VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prix DOUBLE PRECISION NOT NULL, qte DOUBLE PRECISION NOT NULL, `desc` VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, dateajout DATE NOT NULL, status VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, image VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, user_id INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE negociation (id INT AUTO_INCREMENT NOT NULL, montantPropose DOUBLE PRECISION NOT NULL, message VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, etatNego VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, dateNegociation DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE terrain (id INT AUTO_INCREMENT NOT NULL, userId INT NOT NULL, libelleTerrain INT NOT NULL, superficie DOUBLE PRECISION NOT NULL, etatSol VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, idCategory INT NOT NULL, localisation VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo VARCHAR(500) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, descriptionTerrain VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, valeurTerrain DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE culture DROP FOREIGN KEY FK_B6A99CEBA96778EC');
        $this->addSql('DROP TABLE culture');
        $this->addSql('ALTER TABLE annoncerecrutement DROP FOREIGN KEY FK_58D406E2A76ED395');
        $this->addSql('DROP INDEX IDX_58D406E2A76ED395 ON annoncerecrutement');
        $this->addSql('ALTER TABLE annoncerecrutement DROP user_id, DROP archived, CHANGE date_pub date_pub VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B898FB9136');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B8A76ED395');
        $this->addSql('DROP INDEX IDX_E33BD3B898FB9136 ON candidature');
        $this->addSql('DROP INDEX IDX_E33BD3B8A76ED395 ON candidature');
        $this->addSql('ALTER TABLE candidature DROP idannrecru_id, DROP user_id, DROP archived, CHANGE experienceprofessionnelle ExperienceProfessionnelle VARCHAR(5000) DEFAULT NULL, CHANGE formation Formation VARCHAR(5000) DEFAULT NULL, CHANGE competencestechniques CompetencesTechniques VARCHAR(5000) DEFAULT NULL, CHANGE certifforma CertifForma VARCHAR(200) DEFAULT NULL, CHANGE statuscandidature statusCandidature TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE category CHANGE type type VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE client DROP image, CHANGE nomprod Nomprod VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE ouvrier ADD cinOuvrier VARCHAR(200) NOT NULL, ADD nomOuvrier VARCHAR(200) NOT NULL, ADD prenomOuvrier VARCHAR(200) NOT NULL, ADD dateNaissance DATE NOT NULL, ADD genre VARCHAR(255) NOT NULL, ADD email VARCHAR(200) NOT NULL, ADD adresse VARCHAR(200) NOT NULL, ADD phone VARCHAR(200) NOT NULL, ADD userId INT DEFAULT NULL, ADD photo VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE `produit` DROP FOREIGN KEY FK_29A5EC27A76ED395');
        $this->addSql('DROP INDEX IDX_29A5EC27A76ED395 ON `produit`');
        $this->addSql('ALTER TABLE `produit` ADD `desc` DATE NOT NULL, DROP descr, DROP dateajout, DROP datemodif, CHANGE nomprod Nomprod VARCHAR(30) NOT NULL, CHANGE cat cat VARCHAR(30) NOT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404A76ED395');
        $this->addSql('DROP INDEX IDX_CE606404A76ED395 ON reclamation');
        $this->addSql('ALTER TABLE reclamation DROP user_id, DROP datemodif, CHANGE dateajout dateajout DATE NOT NULL');
        $this->addSql('ALTER TABLE `user` DROP google_authenticator_secret, DROP is_banned, DROP ban_expires_at, DROP is_verified, DROP google_id, DROP reset_token, CHANGE nom nom VARCHAR(20) NOT NULL, CHANGE prenom prenom VARCHAR(20) NOT NULL, CHANGE mdp mdp VARCHAR(200) NOT NULL, CHANGE mail mail VARCHAR(30) NOT NULL, CHANGE adresse adresse VARCHAR(50) NOT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL');
    }
}
