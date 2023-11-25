<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231125073855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX `primary` ON annoncerecrutement');
        $this->addSql('ALTER TABLE annoncerecrutement ADD user_id INT DEFAULT NULL, ADD idRecrut INT AUTO_INCREMENT NOT NULL, ADD poste_demande VARCHAR(255) NOT NULL, ADD type_contrat VARCHAR(255) NOT NULL, ADD date_pub DATE NOT NULL, ADD date_embauche DATE NOT NULL, ADD nb_poste_recherche INT NOT NULL, DROP idRecurt, DROP posteDemande, DROP typeContrat, DROP datePub, DROP dateEmbauche, DROP nbPosteRecherche, CHANGE localisation localisation VARCHAR(25) NOT NULL, CHANGE salairePropose salaire_propose DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE annoncerecrutement ADD CONSTRAINT FK_58D406E2A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_58D406E2A76ED395 ON annoncerecrutement (user_id)');
        $this->addSql('ALTER TABLE annoncerecrutement ADD PRIMARY KEY (idRecrut)');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY fk_idAnnRecru');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY fk_idOuvrier');
        $this->addSql('DROP INDEX fk_idAnnRecru ON candidature');
        $this->addSql('DROP INDEX fk_idOuvrier ON candidature');
        $this->addSql('ALTER TABLE candidature DROP idAnnRecru, CHANGE ExperienceProfessionnelle experienceprofessionnelle VARCHAR(5000) NOT NULL, CHANGE Formation formation VARCHAR(5000) NOT NULL, CHANGE CompetencesTechniques competencestechniques VARCHAR(5000) NOT NULL, CHANGE CertifForma certifforma VARCHAR(200) NOT NULL, CHANGE statusCandidature statuscandidature TINYINT(1) NOT NULL, CHANGE idOuvrierfor idannrecru_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B898FB9136 FOREIGN KEY (idannrecru_id) REFERENCES annoncerecrutement (idRecrut)');
        $this->addSql('CREATE INDEX IDX_E33BD3B898FB9136 ON candidature (idannrecru_id)');
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
        $this->addSql('ALTER TABLE annoncerecrutement MODIFY idRecrut INT NOT NULL');
        $this->addSql('ALTER TABLE annoncerecrutement DROP FOREIGN KEY FK_58D406E2A76ED395');
        $this->addSql('DROP INDEX IDX_58D406E2A76ED395 ON annoncerecrutement');
        $this->addSql('DROP INDEX `PRIMARY` ON annoncerecrutement');
        $this->addSql('ALTER TABLE annoncerecrutement ADD posteDemande VARCHAR(255) NOT NULL, ADD typeContrat VARCHAR(255) NOT NULL, ADD datePub DATE NOT NULL, ADD dateEmbauche DATE NOT NULL, ADD nbPosteRecherche INT NOT NULL, DROP user_id, DROP idRecrut, DROP poste_demande, DROP type_contrat, DROP date_pub, DROP date_embauche, CHANGE localisation localisation VARCHAR(255) NOT NULL, CHANGE nb_poste_recherche idRecurt INT NOT NULL, CHANGE salaire_propose salairePropose DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE annoncerecrutement ADD PRIMARY KEY (idRecurt)');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B898FB9136');
        $this->addSql('DROP INDEX IDX_E33BD3B898FB9136 ON candidature');
        $this->addSql('ALTER TABLE candidature ADD idAnnRecru INT NOT NULL, CHANGE experienceprofessionnelle ExperienceProfessionnelle VARCHAR(5000) DEFAULT NULL, CHANGE formation Formation VARCHAR(5000) DEFAULT NULL, CHANGE competencestechniques CompetencesTechniques VARCHAR(5000) DEFAULT NULL, CHANGE certifforma CertifForma VARCHAR(200) DEFAULT NULL, CHANGE statuscandidature statusCandidature TINYINT(1) DEFAULT NULL, CHANGE idannrecru_id idOuvrierfor INT DEFAULT NULL');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT fk_idAnnRecru FOREIGN KEY (idAnnRecru) REFERENCES annoncerecrutement (idRecurt) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT fk_idOuvrier FOREIGN KEY (idOuvrierfor) REFERENCES ouvrier (idOuvrier) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX fk_idAnnRecru ON candidature (idAnnRecru)');
        $this->addSql('CREATE INDEX fk_idOuvrier ON candidature (idOuvrierfor)');
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
