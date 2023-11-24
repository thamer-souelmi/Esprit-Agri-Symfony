<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231124211516 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, produit_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, dateajout DATE NOT NULL, INDEX IDX_CE606404F347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404F347EFB FOREIGN KEY (produit_id) REFERENCES `produit` (id)');
        $this->addSql('ALTER TABLE annoncerecrutement ADD idRecrut INT AUTO_INCREMENT NOT NULL, ADD poste_demande VARCHAR(255) NOT NULL, ADD type_contrat VARCHAR(255) NOT NULL, ADD date_pub VARCHAR(255) DEFAULT NULL, ADD date_embauche VARCHAR(255) DEFAULT NULL, ADD nb_poste_recherche INT NOT NULL, DROP idRecurt, DROP posteDemande, DROP typeContrat, DROP datePub, DROP dateEmbauche, DROP nbPosteRecherche, DROP idCandidature, CHANGE localisation localisation VARCHAR(25) NOT NULL, CHANGE salairePropose salaire_propose DOUBLE PRECISION NOT NULL, ADD PRIMARY KEY (idRecrut)');
        $this->addSql('DROP INDEX fk_candidature_annonce ON candidature');
        $this->addSql('ALTER TABLE candidature ADD experienceprofessionnelle VARCHAR(5000) NOT NULL, ADD formation VARCHAR(5000) NOT NULL, ADD competencestechniques VARCHAR(5000) NOT NULL, ADD certifforma VARCHAR(200) NOT NULL, DROP idRecurt, CHANGE statusCandidature statuscandidature TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE category CHANGE type type VARCHAR(150) NOT NULL');
        $this->addSql('ALTER TABLE client CHANGE Nomprod nomprod VARCHAR(150) NOT NULL, CHANGE image image VARCHAR(150) NOT NULL');
        $this->addSql('ALTER TABLE culture DROP FOREIGN KEY FK_B6A99CEB12469DE2');
        $this->addSql('ALTER TABLE culture CHANGE categoryType categorytype VARCHAR(150) NOT NULL');
        $this->addSql('DROP INDEX fk_category_id ON culture');
        $this->addSql('CREATE INDEX IDX_B6A99CEB12469DE2 ON culture (category_id)');
        $this->addSql('ALTER TABLE culture ADD CONSTRAINT FK_B6A99CEB12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE ouvrier DROP cinOuvrier, DROP nomOuvrier, DROP prenomOuvrier, DROP dateNaissance, DROP genre, DROP email, DROP adresse, DROP phone, DROP userId, DROP photo');
        $this->addSql('ALTER TABLE produit ADD descr VARCHAR(255) NOT NULL, DROP `desc`, CHANGE Nomprod nomprod VARCHAR(255) NOT NULL, CHANGE cat cat VARCHAR(255) NOT NULL, CHANGE image image VARCHAR(255) NOT NULL, CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27A76ED395 ON produit (user_id)');
        $this->addSql('ALTER TABLE user ADD is_banned TINYINT(1) DEFAULT NULL, ADD ban_expires_at VARCHAR(255) DEFAULT NULL, ADD is_verified TINYINT(1) NOT NULL, CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE prenom prenom VARCHAR(255) NOT NULL, CHANGE mdp mdp VARCHAR(255) NOT NULL, CHANGE mail mail VARCHAR(255) NOT NULL, CHANGE adresse adresse VARCHAR(255) NOT NULL, CHANGE image image VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404F347EFB');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('ALTER TABLE annoncerecrutement MODIFY idRecrut INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON annoncerecrutement');
        $this->addSql('ALTER TABLE annoncerecrutement ADD posteDemande VARCHAR(255) NOT NULL, ADD typeContrat VARCHAR(255) NOT NULL, ADD datePub DATE NOT NULL, ADD dateEmbauche DATE NOT NULL, ADD nbPosteRecherche INT NOT NULL, ADD idCandidature INT DEFAULT NULL, DROP idRecrut, DROP poste_demande, DROP type_contrat, DROP date_pub, DROP date_embauche, CHANGE localisation localisation VARCHAR(255) NOT NULL, CHANGE nb_poste_recherche idRecurt INT NOT NULL, CHANGE salaire_propose salairePropose DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE candidature ADD idRecurt INT DEFAULT NULL, DROP experienceprofessionnelle, DROP formation, DROP competencestechniques, DROP certifforma, CHANGE statuscandidature statusCandidature VARCHAR(255) NOT NULL');
        $this->addSql('CREATE INDEX fk_candidature_annonce ON candidature (idRecurt)');
        $this->addSql('ALTER TABLE category CHANGE type type VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE client CHANGE nomprod Nomprod VARCHAR(20) NOT NULL, CHANGE image image VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE culture DROP FOREIGN KEY FK_B6A99CEB12469DE2');
        $this->addSql('ALTER TABLE culture CHANGE categorytype categoryType VARCHAR(40) DEFAULT NULL');
        $this->addSql('DROP INDEX idx_b6a99ceb12469de2 ON culture');
        $this->addSql('CREATE INDEX fk_category_id ON culture (category_id)');
        $this->addSql('ALTER TABLE culture ADD CONSTRAINT FK_B6A99CEB12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE ouvrier ADD cinOuvrier VARCHAR(200) NOT NULL, ADD nomOuvrier VARCHAR(200) NOT NULL, ADD prenomOuvrier VARCHAR(200) NOT NULL, ADD dateNaissance DATE NOT NULL, ADD genre VARCHAR(255) NOT NULL, ADD email VARCHAR(200) NOT NULL, ADD adresse VARCHAR(200) NOT NULL, ADD phone VARCHAR(200) NOT NULL, ADD userId INT DEFAULT NULL, ADD photo VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE `produit` DROP FOREIGN KEY FK_29A5EC27A76ED395');
        $this->addSql('DROP INDEX IDX_29A5EC27A76ED395 ON `produit`');
        $this->addSql('ALTER TABLE `produit` ADD `desc` DATE NOT NULL, DROP descr, CHANGE user_id user_id INT DEFAULT NULL, CHANGE nomprod Nomprod VARCHAR(30) NOT NULL, CHANGE cat cat VARCHAR(30) NOT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE `user` DROP is_banned, DROP ban_expires_at, DROP is_verified, CHANGE nom nom VARCHAR(20) NOT NULL, CHANGE prenom prenom VARCHAR(20) NOT NULL, CHANGE mdp mdp VARCHAR(200) NOT NULL, CHANGE mail mail VARCHAR(30) NOT NULL, CHANGE adresse adresse VARCHAR(50) NOT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL');
    }
}
