<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231107205651 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE culture DROP FOREIGN KEY FK_B6A99CEBA76ED395');
        $this->addSql('ALTER TABLE culture DROP FOREIGN KEY FK_B6A99CEB12469DE2');
        $this->addSql('DROP TABLE annonceinvestissement');
        $this->addSql('DROP TABLE betail');
        $this->addSql('DROP TABLE bilancomptable');
        $this->addSql('DROP TABLE bilanresultat');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE culture');
        $this->addSql('DROP TABLE entretien');
        $this->addSql('DROP TABLE equipe');
        $this->addSql('DROP TABLE installationbetail');
        $this->addSql('DROP TABLE ouvrier');
        $this->addSql('DROP TABLE terrain');
        $this->addSql('DROP TABLE traitementmedicale');
        $this->addSql('ALTER TABLE user CHANGE cin cin VARCHAR(255) NOT NULL, CHANGE mdp mdp VARCHAR(200) NOT NULL, CHANGE role role VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonceinvestissement (idAnnonce INT AUTO_INCREMENT NOT NULL, titre VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, montant DOUBLE PRECISION NOT NULL, datePublication DATE NOT NULL, localisation VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description VARCHAR(400) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, photo VARCHAR(500) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, iduser INT NOT NULL, PRIMARY KEY(idAnnonce)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE betail (id INT AUTO_INCREMENT NOT NULL, numero VARCHAR(11) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, categbetail VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, race VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, genre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, poids DOUBLE PRECISION NOT NULL, dateDeNaissance DATE NOT NULL, userId INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bilancomptable (idBilanC INT AUTO_INCREMENT NOT NULL, idUser INT NOT NULL, annee DATE NOT NULL, resultatNet DOUBLE PRECISION NOT NULL, valeurTerrain DOUBLE PRECISION NOT NULL, materiels DOUBLE PRECISION NOT NULL, autresImmobilisations DOUBLE PRECISION NOT NULL, stocksProduits DOUBLE PRECISION NOT NULL, creanceClient DOUBLE PRECISION NOT NULL, tresorie DOUBLE PRECISION NOT NULL, capitalSocial DOUBLE PRECISION NOT NULL, reserves DOUBLE PRECISION NOT NULL, emprunts DOUBLE PRECISION NOT NULL, dettesCT DOUBLE PRECISION NOT NULL, dettesIT DOUBLE PRECISION NOT NULL, fournisseurs DOUBLE PRECISION NOT NULL, PRIMARY KEY(idBilanC)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bilanresultat (idBilanR INT AUTO_INCREMENT NOT NULL, anneeR DATE NOT NULL, idUser INT NOT NULL, autreRevenus DOUBLE PRECISION NOT NULL, subvention DOUBLE PRECISION NOT NULL, revenuesCultures DOUBLE PRECISION NOT NULL, semences DOUBLE PRECISION NOT NULL, coutMainOeuvre DOUBLE PRECISION NOT NULL, coutInterventionMedicale DOUBLE PRECISION NOT NULL, coutsPlantations DOUBLE PRECISION NOT NULL, chargesElectricite DOUBLE PRECISION NOT NULL, chargeEntretien DOUBLE PRECISION NOT NULL, chargeAdministratives DOUBLE PRECISION NOT NULL, PRIMARY KEY(idBilanR)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE culture (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, user_id INT DEFAULT NULL, libelle VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, datePlantation DATE NOT NULL, dateRecolte DATE NOT NULL, revenuesCultures DOUBLE PRECISION NOT NULL, coutsPlantations DOUBLE PRECISION NOT NULL, INDEX fk_user_id (user_id), INDEX fk_category_id (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE entretien (id INT AUTO_INCREMENT NOT NULL, userId INT NOT NULL, libelleTerrain INT NOT NULL, typeEntretien VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, dateEntretien VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, statusEntretien VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, descriptionEntretient VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, chargeEntretient DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE equipe (idEquipe INT AUTO_INCREMENT NOT NULL, tacheAttribut VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, libelleTerrain INT NOT NULL, dateDebut DATE NOT NULL, duree VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, userId INT DEFAULT NULL, NomEquipee VARCHAR(2000) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(idEquipe)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE installationbetail (idInst INT AUTO_INCREMENT NOT NULL, typeInstallation VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, nomInsatallation VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, etatinstallation VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, localisation VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(idInst)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE ouvrier (idOuvrier INT AUTO_INCREMENT NOT NULL, cinOuvrier VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, nomOuvrier VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prenomOuvrier VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, dateNaissance DATE NOT NULL, genre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, dateEmbauche DATE NOT NULL, email VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, adresse VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, phone VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, poste VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, userId INT DEFAULT NULL, NomEquipe VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, photo VARCHAR(200) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(idOuvrier)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE terrain (id_t INT AUTO_INCREMENT NOT NULL, nom_t VARCHAR(11) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, user_id INT NOT NULL, surface INT NOT NULL, type_r VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, img VARCHAR(500) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, type_c VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prix INT NOT NULL, PRIMARY KEY(id_t)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE traitementmedicale (id INT AUTO_INCREMENT NOT NULL, numero VARCHAR(11) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, etatDeSante VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, typeIntervMed VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, dateIntervMed DATE NOT NULL, veterinaire VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, coutInterv DOUBLE PRECISION NOT NULL, medicament VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, dureeTraitement VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE culture ADD CONSTRAINT FK_B6A99CEBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE culture ADD CONSTRAINT FK_B6A99CEB12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE user CHANGE cin cin INT NOT NULL, CHANGE mdp mdp VARCHAR(200) DEFAULT NULL, CHANGE role role VARCHAR(255) DEFAULT NULL');
    }
}
