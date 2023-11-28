<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231122084552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonceinvestissement (idAnnonce INT AUTO_INCREMENT NOT NULL, titre VARCHAR(200) NOT NULL, montant DOUBLE PRECISION NOT NULL, datePublication DATE NOT NULL, localisation VARCHAR(100) NOT NULL, description VARCHAR(400) NOT NULL, photo VARCHAR(500) NOT NULL, iduser INT NOT NULL, PRIMARY KEY(idAnnonce)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE annoncerecrutement (idRecurt INT AUTO_INCREMENT NOT NULL, posteDemande VARCHAR(255) NOT NULL, salairePropose DOUBLE PRECISION NOT NULL, typeContrat VARCHAR(255) NOT NULL, datePub DATE NOT NULL, localisation VARCHAR(255) NOT NULL, dateEmbauche DATE NOT NULL, nbPosteRecherche INT NOT NULL, idCandidature INT DEFAULT NULL, PRIMARY KEY(idRecurt)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE betail (id INT AUTO_INCREMENT NOT NULL, numero VARCHAR(11) NOT NULL, categbetail VARCHAR(255) NOT NULL, race VARCHAR(255) NOT NULL, genre VARCHAR(255) NOT NULL, poids DOUBLE PRECISION NOT NULL, dateDeNaissance DATE NOT NULL, userId INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bilancomptable (idBilanC INT AUTO_INCREMENT NOT NULL, idUser INT NOT NULL, annee DATE NOT NULL, resultatNet DOUBLE PRECISION NOT NULL, valeurTerrain DOUBLE PRECISION NOT NULL, materiels DOUBLE PRECISION NOT NULL, autresImmobilisations DOUBLE PRECISION NOT NULL, stocksProduits DOUBLE PRECISION NOT NULL, creanceClient DOUBLE PRECISION NOT NULL, tresorie DOUBLE PRECISION NOT NULL, capitalSocial DOUBLE PRECISION NOT NULL, reserves DOUBLE PRECISION NOT NULL, emprunts DOUBLE PRECISION NOT NULL, dettesCT DOUBLE PRECISION NOT NULL, dettesIT DOUBLE PRECISION NOT NULL, fournisseurs DOUBLE PRECISION NOT NULL, PRIMARY KEY(idBilanC)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bilanresultat (idBilanR INT AUTO_INCREMENT NOT NULL, anneeR DATE NOT NULL, idUser INT NOT NULL, autreRevenus DOUBLE PRECISION NOT NULL, subvention DOUBLE PRECISION NOT NULL, revenuesCultures DOUBLE PRECISION NOT NULL, semences DOUBLE PRECISION NOT NULL, coutMainOeuvre DOUBLE PRECISION NOT NULL, coutInterventionMedicale DOUBLE PRECISION NOT NULL, coutsPlantations DOUBLE PRECISION NOT NULL, chargesElectricite DOUBLE PRECISION NOT NULL, chargeEntretien DOUBLE PRECISION NOT NULL, chargeAdministratives DOUBLE PRECISION NOT NULL, PRIMARY KEY(idBilanR)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candidature (idCandidature INT AUTO_INCREMENT NOT NULL, ExperienceProfessionnelle VARCHAR(5000) DEFAULT NULL, Formation VARCHAR(5000) DEFAULT NULL, CompetencesTechniques VARCHAR(5000) DEFAULT NULL, CertifForma VARCHAR(200) DEFAULT NULL, messageMotivation VARCHAR(255) NOT NULL, statusCandidature TINYINT(1) DEFAULT NULL, dateCandidature DATE NOT NULL, PRIMARY KEY(idCandidature)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(200) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, id_user INT NOT NULL, prodid INT NOT NULL, Nomprod VARCHAR(20) NOT NULL, prix DOUBLE PRECISION NOT NULL, dateajout DATE NOT NULL, qte DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entretien (id INT AUTO_INCREMENT NOT NULL, userId INT NOT NULL, libelleTerrain INT NOT NULL, typeEntretien VARCHAR(50) NOT NULL, dateEntretien VARCHAR(50) NOT NULL, statusEntretien VARCHAR(255) NOT NULL, descriptionEntretient VARCHAR(200) NOT NULL, chargeEntretient DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipe (idEquipe INT AUTO_INCREMENT NOT NULL, tacheAttribut VARCHAR(200) NOT NULL, libelleTerrain INT NOT NULL, dateDebut DATE NOT NULL, duree VARCHAR(200) NOT NULL, userId INT DEFAULT NULL, NomEquipee VARCHAR(2000) NOT NULL, PRIMARY KEY(idEquipe)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marche (id INT AUTO_INCREMENT NOT NULL, Nomprod VARCHAR(30) NOT NULL, cat VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, qte DOUBLE PRECISION NOT NULL, `desc` VARCHAR(200) NOT NULL, dateajout DATE NOT NULL, status VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, user_id INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE negociation (id INT AUTO_INCREMENT NOT NULL, montantPropose DOUBLE PRECISION NOT NULL, message VARCHAR(255) NOT NULL, etatNego VARCHAR(255) NOT NULL, dateNegociation DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ouvrier (idOuvrier INT AUTO_INCREMENT NOT NULL, cinOuvrier VARCHAR(200) NOT NULL, nomOuvrier VARCHAR(200) NOT NULL, prenomOuvrier VARCHAR(200) NOT NULL, dateNaissance DATE NOT NULL, genre VARCHAR(255) NOT NULL, dateEmbauche DATE NOT NULL, email VARCHAR(200) NOT NULL, adresse VARCHAR(200) NOT NULL, phone VARCHAR(200) NOT NULL, poste VARCHAR(255) NOT NULL, userId INT DEFAULT NULL, NomEquipe VARCHAR(200) NOT NULL, photo VARCHAR(200) NOT NULL, PRIMARY KEY(idOuvrier)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, Nomprod VARCHAR(30) NOT NULL, cat VARCHAR(30) NOT NULL, prix DOUBLE PRECISION NOT NULL, qte DOUBLE PRECISION NOT NULL, `desc` DATE NOT NULL, status TINYINT(1) NOT NULL, image VARCHAR(255) DEFAULT NULL, user_id INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE terrain (id INT AUTO_INCREMENT NOT NULL, userId INT NOT NULL, libelleTerrain INT NOT NULL, superficie DOUBLE PRECISION NOT NULL, etatSol VARCHAR(255) NOT NULL, idCategory INT NOT NULL, localisation VARCHAR(200) NOT NULL, photo VARCHAR(500) NOT NULL, descriptionTerrain VARCHAR(200) NOT NULL, valeurTerrain DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, cin VARCHAR(255) NOT NULL, nom VARCHAR(20) NOT NULL, prenom VARCHAR(20) NOT NULL, mdp VARCHAR(200) NOT NULL, mail VARCHAR(30) NOT NULL, adresse VARCHAR(50) NOT NULL, numtel INT NOT NULL, role VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE annonceinvestissement');
        $this->addSql('DROP TABLE annoncerecrutement');
        $this->addSql('DROP TABLE betail');
        $this->addSql('DROP TABLE bilancomptable');
        $this->addSql('DROP TABLE bilanresultat');
        $this->addSql('DROP TABLE candidature');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE entretien');
        $this->addSql('DROP TABLE equipe');
        $this->addSql('DROP TABLE marche');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('DROP TABLE negociation');
        $this->addSql('DROP TABLE ouvrier');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE terrain');
        $this->addSql('DROP TABLE user');
    }
}
