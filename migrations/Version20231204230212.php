<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204230212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annoncerecrutement (user_id INT DEFAULT NULL, idRecrut INT AUTO_INCREMENT NOT NULL, poste_demande VARCHAR(255) NOT NULL, salaire_propose DOUBLE PRECISION NOT NULL, type_contrat VARCHAR(255) NOT NULL, date_pub DATE NOT NULL, localisation VARCHAR(25) NOT NULL, date_embauche VARCHAR(255) DEFAULT NULL, nb_poste_recherche INT NOT NULL, archived TINYINT(1) NOT NULL, INDEX IDX_58D406E2A76ED395 (user_id), PRIMARY KEY(idRecrut)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candidature (idannrecru_id INT DEFAULT NULL, user_id INT DEFAULT NULL, idCandidature INT AUTO_INCREMENT NOT NULL, experienceprofessionnelle VARCHAR(5000) NOT NULL, formation VARCHAR(5000) NOT NULL, competencestechniques VARCHAR(5000) NOT NULL, certifforma VARCHAR(200) NOT NULL, messagemotivation VARCHAR(255) NOT NULL, datecandidature DATE NOT NULL, statuscandidature TINYINT(1) NOT NULL, archived TINYINT(1) NOT NULL, INDEX IDX_E33BD3B898FB9136 (idannrecru_id), INDEX IDX_E33BD3B8A76ED395 (user_id), PRIMARY KEY(idCandidature)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, id_user INT NOT NULL, prodid INT NOT NULL, nomprod VARCHAR(150) NOT NULL, prix DOUBLE PRECISION NOT NULL, dateajout DATE NOT NULL, qte DOUBLE PRECISION NOT NULL, image VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE culture (id INT AUTO_INCREMENT NOT NULL, categorys_id INT DEFAULT NULL, libelle VARCHAR(200) NOT NULL, dateplantation DATE NOT NULL, daterecolte DATE NOT NULL, categorytype VARCHAR(150) NOT NULL, revenuescultures DOUBLE PRECISION NOT NULL, coutsplantations DOUBLE PRECISION NOT NULL, INDEX IDX_B6A99CEBA96778EC (categorys_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, idvet INT DEFAULT NULL, valeur INT NOT NULL, INDEX IDX_CFBDFA14F9DABC50 (idvet), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ouvrier (idOuvrier INT AUTO_INCREMENT NOT NULL, dateembauche DATE NOT NULL, poste VARCHAR(255) NOT NULL, nomequipe VARCHAR(200) NOT NULL, PRIMARY KEY(idOuvrier)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `produit` (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nomprod VARCHAR(255) NOT NULL, cat VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, qte DOUBLE PRECISION NOT NULL, descr VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, image VARCHAR(255) NOT NULL, dateajout DATETIME NOT NULL, datemodif DATETIME NOT NULL, INDEX IDX_29A5EC27A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, produit_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, dateajout DATETIME NOT NULL, datemodif DATETIME NOT NULL, INDEX IDX_CE606404A76ED395 (user_id), INDEX IDX_CE606404F347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE traitementmedicale (id INT AUTO_INCREMENT NOT NULL, idvet INT DEFAULT NULL, numero VARCHAR(11) NOT NULL, typeintervmed VARCHAR(200) NOT NULL, dateintervmed DATE NOT NULL, coutinterv DOUBLE PRECISION NOT NULL, medicament VARCHAR(200) NOT NULL, dureetraitement VARCHAR(200) NOT NULL, description VARCHAR(200) NOT NULL, INDEX IDX_A207FE66F9DABC50 (idvet), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE veterinaire (idvet INT AUTO_INCREMENT NOT NULL, nomvet VARCHAR(200) NOT NULL, prenomvet VARCHAR(200) NOT NULL, adresscabinet VARCHAR(200) NOT NULL, numtel INT NOT NULL, adressmail VARCHAR(200) NOT NULL, specialite VARCHAR(200) NOT NULL, PRIMARY KEY(idvet)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annoncerecrutement ADD CONSTRAINT FK_58D406E2A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B898FB9136 FOREIGN KEY (idannrecru_id) REFERENCES annoncerecrutement (idRecrut)');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B8A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE culture ADD CONSTRAINT FK_B6A99CEBA96778EC FOREIGN KEY (categorys_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14F9DABC50 FOREIGN KEY (idvet) REFERENCES veterinaire (idvet)');
        $this->addSql('ALTER TABLE `produit` ADD CONSTRAINT FK_29A5EC27A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404F347EFB FOREIGN KEY (produit_id) REFERENCES `produit` (id)');
        $this->addSql('ALTER TABLE traitementmedicale ADD CONSTRAINT FK_A207FE66F9DABC50 FOREIGN KEY (idvet) REFERENCES veterinaire (idvet)');
        $this->addSql('ALTER TABLE user ADD google_authenticator_secret VARCHAR(255) DEFAULT NULL, ADD is_banned TINYINT(1) DEFAULT NULL, ADD ban_expires_at VARCHAR(255) DEFAULT NULL, ADD is_verified TINYINT(1) NOT NULL, ADD google_id VARCHAR(255) DEFAULT NULL, ADD reset_token VARCHAR(100) DEFAULT NULL, CHANGE adresse adresse VARCHAR(255) NOT NULL, CHANGE role role VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annoncerecrutement DROP FOREIGN KEY FK_58D406E2A76ED395');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B898FB9136');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B8A76ED395');
        $this->addSql('ALTER TABLE culture DROP FOREIGN KEY FK_B6A99CEBA96778EC');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14F9DABC50');
        $this->addSql('ALTER TABLE `produit` DROP FOREIGN KEY FK_29A5EC27A76ED395');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404A76ED395');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404F347EFB');
        $this->addSql('ALTER TABLE traitementmedicale DROP FOREIGN KEY FK_A207FE66F9DABC50');
        $this->addSql('DROP TABLE annoncerecrutement');
        $this->addSql('DROP TABLE candidature');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE culture');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE ouvrier');
        $this->addSql('DROP TABLE `produit`');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE traitementmedicale');
        $this->addSql('DROP TABLE veterinaire');
        $this->addSql('ALTER TABLE `user` DROP google_authenticator_secret, DROP is_banned, DROP ban_expires_at, DROP is_verified, DROP google_id, DROP reset_token, CHANGE adresse adresse INT NOT NULL, CHANGE role role JSON NOT NULL COMMENT \'(DC2Type:json)\'');
    }
}
