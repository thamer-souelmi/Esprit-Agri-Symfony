<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231127144752 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonceinvestissement (idAnnonce INT AUTO_INCREMENT NOT NULL, titre VARCHAR(200) NOT NULL, montant DOUBLE PRECISION NOT NULL, datePublication DATE NOT NULL, localisation VARCHAR(100) NOT NULL, description VARCHAR(400) NOT NULL, photo VARCHAR(500) NOT NULL, PRIMARY KEY(idAnnonce)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bilancomptable (idBilanC INT AUTO_INCREMENT NOT NULL, idUser INT NOT NULL, annee DATE NOT NULL, resultatNet DOUBLE PRECISION NOT NULL, valeurTerrain DOUBLE PRECISION NOT NULL, materiels DOUBLE PRECISION NOT NULL, autresImmobilisations DOUBLE PRECISION NOT NULL, stocksProduits DOUBLE PRECISION NOT NULL, creanceClient DOUBLE PRECISION NOT NULL, tresorie DOUBLE PRECISION NOT NULL, capitalSocial DOUBLE PRECISION NOT NULL, reserves DOUBLE PRECISION NOT NULL, emprunts DOUBLE PRECISION NOT NULL, dettesCT DOUBLE PRECISION NOT NULL, dettesIT DOUBLE PRECISION NOT NULL, fournisseurs DOUBLE PRECISION NOT NULL, PRIMARY KEY(idBilanC)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bilanresultat (idBilanR INT AUTO_INCREMENT NOT NULL, anneeR DATE NOT NULL, idUser INT NOT NULL, autreRevenus DOUBLE PRECISION NOT NULL, subvention DOUBLE PRECISION NOT NULL, revenuesCultures DOUBLE PRECISION NOT NULL, semences DOUBLE PRECISION NOT NULL, coutMainOeuvre DOUBLE PRECISION NOT NULL, coutInterventionMedicale DOUBLE PRECISION NOT NULL, coutsPlantations DOUBLE PRECISION NOT NULL, chargesElectricite DOUBLE PRECISION NOT NULL, chargeEntretien DOUBLE PRECISION NOT NULL, chargeAdministratives DOUBLE PRECISION NOT NULL, PRIMARY KEY(idBilanR)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE negociation (id INT AUTO_INCREMENT NOT NULL, montantPropose DOUBLE PRECISION NOT NULL, message VARCHAR(255) NOT NULL, etatNego TINYINT(1) DEFAULT NULL, dateNegociation DATE NOT NULL, is_archived TINYINT(1) NOT NULL, idAnnonce INT DEFAULT NULL, INDEX IDX_B5E137D8E6ECF817 (idAnnonce), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE veterinaire (idvet INT AUTO_INCREMENT NOT NULL, nomvet VARCHAR(200) NOT NULL, prenomvet VARCHAR(200) NOT NULL, adresscabinet VARCHAR(200) NOT NULL, numtel INT NOT NULL, adressmail VARCHAR(200) NOT NULL, specialite VARCHAR(200) NOT NULL, PRIMARY KEY(idvet)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE negociation ADD CONSTRAINT FK_B5E137D8E6ECF817 FOREIGN KEY (idAnnonce) REFERENCES annonceinvestissement (idAnnonce)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE negociation DROP FOREIGN KEY FK_B5E137D8E6ECF817');
        $this->addSql('DROP TABLE annonceinvestissement');
        $this->addSql('DROP TABLE bilancomptable');
        $this->addSql('DROP TABLE bilanresultat');
        $this->addSql('DROP TABLE negociation');
        $this->addSql('DROP TABLE veterinaire');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
