<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231108182626 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonceinvestissement (idAnnonce INT AUTO_INCREMENT NOT NULL, titre VARCHAR(200) NOT NULL, montant DOUBLE PRECISION NOT NULL, datePublication DATE NOT NULL, localisation VARCHAR(100) NOT NULL, description VARCHAR(400) NOT NULL, photo VARCHAR(500) NOT NULL, iduser INT NOT NULL, PRIMARY KEY(idAnnonce)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE annoncerecrutement (idRecurt INT AUTO_INCREMENT NOT NULL, posteDemande VARCHAR(255) NOT NULL, salairePropose DOUBLE PRECISION NOT NULL, typeContrat VARCHAR(255) NOT NULL, datePub DATE NOT NULL, localisation VARCHAR(255) NOT NULL, dateEmbauche DATE NOT NULL, nbPosteRecherche INT NOT NULL, PRIMARY KEY(idRecurt)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE betail (id INT AUTO_INCREMENT NOT NULL, numero VARCHAR(11) NOT NULL, categbetail VARCHAR(255) NOT NULL, race VARCHAR(255) NOT NULL, genre VARCHAR(255) NOT NULL, poids DOUBLE PRECISION NOT NULL, dateDeNaissance DATE NOT NULL, userId INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bilancomptable (idBilanC INT AUTO_INCREMENT NOT NULL, idUser INT NOT NULL, annee DATE NOT NULL, resultatNet DOUBLE PRECISION NOT NULL, valeurTerrain DOUBLE PRECISION NOT NULL, materiels DOUBLE PRECISION NOT NULL, autresImmobilisations DOUBLE PRECISION NOT NULL, stocksProduits DOUBLE PRECISION NOT NULL, creanceClient DOUBLE PRECISION NOT NULL, tresorie DOUBLE PRECISION NOT NULL, capitalSocial DOUBLE PRECISION NOT NULL, reserves DOUBLE PRECISION NOT NULL, emprunts DOUBLE PRECISION NOT NULL, dettesCT DOUBLE PRECISION NOT NULL, dettesIT DOUBLE PRECISION NOT NULL, fournisseurs DOUBLE PRECISION NOT NULL, PRIMARY KEY(idBilanC)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bilanresultat (idBilanR INT AUTO_INCREMENT NOT NULL, anneeR DATE NOT NULL, idUser INT NOT NULL, autreRevenus DOUBLE PRECISION NOT NULL, subvention DOUBLE PRECISION NOT NULL, revenuesCultures DOUBLE PRECISION NOT NULL, semences DOUBLE PRECISION NOT NULL, coutMainOeuvre DOUBLE PRECISION NOT NULL, coutInterventionMedicale DOUBLE PRECISION NOT NULL, coutsPlantations DOUBLE PRECISION NOT NULL, chargesElectricite DOUBLE PRECISION NOT NULL, chargeEntretien DOUBLE PRECISION NOT NULL, chargeAdministratives DOUBLE PRECISION NOT NULL, PRIMARY KEY(idBilanR)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candidature (idCandidature INT AUTO_INCREMENT NOT NULL, messageMotivation VARCHAR(255) NOT NULL, statusCandidature VARCHAR(255) NOT NULL, dateCandidature DATE NOT NULL, PRIMARY KEY(idCandidature)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(200) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE culture (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, libelle VARCHAR(200) NOT NULL, datePlantation DATE NOT NULL, dateRecolte DATE NOT NULL, categoryType VARCHAR(40) NOT NULL, revenuesCultures DOUBLE PRECISION NOT NULL, coutsPlantations DOUBLE PRECISION NOT NULL, INDEX fk_category_id (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entretien (id INT AUTO_INCREMENT NOT NULL, userId INT NOT NULL, libelleTerrain INT NOT NULL, typeEntretien VARCHAR(50) NOT NULL, dateEntretien VARCHAR(50) NOT NULL, statusEntretien VARCHAR(255) NOT NULL, descriptionEntretient VARCHAR(200) NOT NULL, chargeEntretient DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipe (idEquipe INT AUTO_INCREMENT NOT NULL, tacheAttribut VARCHAR(200) NOT NULL, libelleTerrain INT NOT NULL, dateDebut DATE NOT NULL, duree VARCHAR(200) NOT NULL, userId INT DEFAULT NULL, NomEquipee VARCHAR(2000) NOT NULL, PRIMARY KEY(idEquipe)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE negociation (id INT AUTO_INCREMENT NOT NULL, montantPropose DOUBLE PRECISION NOT NULL, message VARCHAR(255) NOT NULL, etatNego VARCHAR(255) NOT NULL, dateNegociation DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ouvrier (idOuvrier INT AUTO_INCREMENT NOT NULL, cinOuvrier VARCHAR(200) NOT NULL, nomOuvrier VARCHAR(200) NOT NULL, prenomOuvrier VARCHAR(200) NOT NULL, dateNaissance DATE NOT NULL, genre VARCHAR(255) NOT NULL, dateEmbauche DATE NOT NULL, email VARCHAR(200) NOT NULL, adresse VARCHAR(200) NOT NULL, phone VARCHAR(200) NOT NULL, poste VARCHAR(255) NOT NULL, userId INT DEFAULT NULL, NomEquipe VARCHAR(200) NOT NULL, photo VARCHAR(200) NOT NULL, PRIMARY KEY(idOuvrier)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE terrain (id INT AUTO_INCREMENT NOT NULL, userId INT NOT NULL, libelleTerrain INT NOT NULL, superficie DOUBLE PRECISION NOT NULL, etatSol VARCHAR(255) NOT NULL, idCategory INT NOT NULL, localisation VARCHAR(200) NOT NULL, photo VARCHAR(500) NOT NULL, descriptionTerrain VARCHAR(200) NOT NULL, valeurTerrain DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE traitementmedicale (id INT AUTO_INCREMENT NOT NULL, numero VARCHAR(11) NOT NULL, etatDeSante VARCHAR(255) NOT NULL, typeIntervMed VARCHAR(255) NOT NULL, dateIntervMed DATE NOT NULL, veterinaire VARCHAR(200) NOT NULL, coutInterv DOUBLE PRECISION NOT NULL, medicament VARCHAR(200) NOT NULL, dureeTraitement VARCHAR(200) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE culture ADD CONSTRAINT FK_B6A99CEB12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE user CHANGE cin cin VARCHAR(255) NOT NULL, CHANGE nom nom VARCHAR(20) NOT NULL, CHANGE prenom prenom VARCHAR(20) NOT NULL, CHANGE mdp mdp VARCHAR(200) NOT NULL, CHANGE mail mail VARCHAR(30) NOT NULL, CHANGE adresse adresse VARCHAR(50) NOT NULL, CHANGE numtel numtel INT NOT NULL, CHANGE role role VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE culture DROP FOREIGN KEY FK_B6A99CEB12469DE2');
        $this->addSql('DROP TABLE annonceinvestissement');
        $this->addSql('DROP TABLE annoncerecrutement');
        $this->addSql('DROP TABLE betail');
        $this->addSql('DROP TABLE bilancomptable');
        $this->addSql('DROP TABLE bilanresultat');
        $this->addSql('DROP TABLE candidature');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE culture');
        $this->addSql('DROP TABLE entretien');
        $this->addSql('DROP TABLE equipe');
        $this->addSql('DROP TABLE negociation');
        $this->addSql('DROP TABLE ouvrier');
        $this->addSql('DROP TABLE terrain');
        $this->addSql('DROP TABLE traitementmedicale');
        $this->addSql('ALTER TABLE user CHANGE cin cin VARCHAR(255) DEFAULT NULL, CHANGE nom nom VARCHAR(20) DEFAULT NULL, CHANGE prenom prenom VARCHAR(20) DEFAULT NULL, CHANGE mdp mdp VARCHAR(200) DEFAULT NULL, CHANGE mail mail VARCHAR(30) DEFAULT NULL, CHANGE adresse adresse VARCHAR(50) DEFAULT NULL, CHANGE numtel numtel INT DEFAULT NULL, CHANGE role role VARCHAR(255) DEFAULT NULL');
    }
}
