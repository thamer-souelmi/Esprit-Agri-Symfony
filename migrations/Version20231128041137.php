<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231128041137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annoncerecrutement ADD idRecrut INT AUTO_INCREMENT NOT NULL, ADD poste_demande VARCHAR(255) NOT NULL, ADD type_contrat VARCHAR(255) NOT NULL, ADD date_pub VARCHAR(255) DEFAULT NULL, ADD date_embauche VARCHAR(255) DEFAULT NULL, ADD nb_poste_recherche INT NOT NULL, DROP idRecurt, DROP posteDemande, DROP typeContrat, DROP datePub, DROP dateEmbauche, DROP nbPosteRecherche, DROP idCandidature, CHANGE localisation localisation VARCHAR(25) NOT NULL, CHANGE salairePropose salaire_propose DOUBLE PRECISION NOT NULL, ADD PRIMARY KEY (idRecrut)');
        $this->addSql('ALTER TABLE candidature CHANGE ExperienceProfessionnelle experienceprofessionnelle VARCHAR(5000) NOT NULL, CHANGE Formation formation VARCHAR(5000) NOT NULL, CHANGE CompetencesTechniques competencestechniques VARCHAR(5000) NOT NULL, CHANGE CertifForma certifforma VARCHAR(200) NOT NULL, CHANGE statusCandidature statuscandidature TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE category CHANGE type type VARCHAR(150) NOT NULL');
        $this->addSql('ALTER TABLE client ADD image VARCHAR(150) NOT NULL, CHANGE Nomprod nomprod VARCHAR(150) NOT NULL');
        $this->addSql('ALTER TABLE culture DROP FOREIGN KEY FK_B6A99CEB12469DE2');
        $this->addSql('DROP INDEX IDX_B6A99CEB12469DE2 ON culture');
        $this->addSql('ALTER TABLE culture CHANGE category_id categorys_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE culture ADD CONSTRAINT FK_B6A99CEBA96778EC FOREIGN KEY (categorys_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_B6A99CEBA96778EC ON culture (categorys_id)');
        $this->addSql('ALTER TABLE ouvrier DROP cinOuvrier, DROP nomOuvrier, DROP prenomOuvrier, DROP dateNaissance, DROP genre, DROP email, DROP adresse, DROP phone, DROP userId, DROP photo');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27A76ED395 ON produit (user_id)');
        $this->addSql('ALTER TABLE reclamation ADD datemodif DATE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annoncerecrutement MODIFY idRecrut INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON annoncerecrutement');
        $this->addSql('ALTER TABLE annoncerecrutement ADD posteDemande VARCHAR(255) NOT NULL, ADD typeContrat VARCHAR(255) NOT NULL, ADD datePub DATE NOT NULL, ADD dateEmbauche DATE NOT NULL, ADD nbPosteRecherche INT NOT NULL, ADD idCandidature INT DEFAULT NULL, DROP idRecrut, DROP poste_demande, DROP type_contrat, DROP date_pub, DROP date_embauche, CHANGE localisation localisation VARCHAR(255) NOT NULL, CHANGE nb_poste_recherche idRecurt INT NOT NULL, CHANGE salaire_propose salairePropose DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE candidature CHANGE experienceprofessionnelle ExperienceProfessionnelle VARCHAR(5000) DEFAULT NULL, CHANGE formation Formation VARCHAR(5000) DEFAULT NULL, CHANGE competencestechniques CompetencesTechniques VARCHAR(5000) DEFAULT NULL, CHANGE certifforma CertifForma VARCHAR(200) DEFAULT NULL, CHANGE statuscandidature statusCandidature TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE category CHANGE type type VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE client DROP image, CHANGE nomprod Nomprod VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE culture DROP FOREIGN KEY FK_B6A99CEBA96778EC');
        $this->addSql('DROP INDEX IDX_B6A99CEBA96778EC ON culture');
        $this->addSql('ALTER TABLE culture CHANGE categorys_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE culture ADD CONSTRAINT FK_B6A99CEB12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_B6A99CEB12469DE2 ON culture (category_id)');
        $this->addSql('ALTER TABLE ouvrier ADD cinOuvrier VARCHAR(200) NOT NULL, ADD nomOuvrier VARCHAR(200) NOT NULL, ADD prenomOuvrier VARCHAR(200) NOT NULL, ADD dateNaissance DATE NOT NULL, ADD genre VARCHAR(255) NOT NULL, ADD email VARCHAR(200) NOT NULL, ADD adresse VARCHAR(200) NOT NULL, ADD phone VARCHAR(200) NOT NULL, ADD userId INT DEFAULT NULL, ADD photo VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE `produit` DROP FOREIGN KEY FK_29A5EC27A76ED395');
        $this->addSql('DROP INDEX IDX_29A5EC27A76ED395 ON `produit`');
        $this->addSql('ALTER TABLE reclamation DROP datemodif');
    }
}
