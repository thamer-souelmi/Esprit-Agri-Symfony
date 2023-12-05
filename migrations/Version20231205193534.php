<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231205193534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonceinvestissement (user_id INT DEFAULT NULL, idAnnonce INT AUTO_INCREMENT NOT NULL, titre VARCHAR(200) NOT NULL, montant DOUBLE PRECISION NOT NULL, datePublication DATE NOT NULL, localisation VARCHAR(100) NOT NULL, description VARCHAR(400) NOT NULL, photo VARCHAR(500) NOT NULL, INDEX IDX_5FE22F97A76ED395 (user_id), PRIMARY KEY(idAnnonce)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonceinvestissement ADD CONSTRAINT FK_5FE22F97A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE annoncerecrutement ADD user_id INT DEFAULT NULL, ADD archived TINYINT(1) NOT NULL, CHANGE date_pub date_pub DATE NOT NULL');
        $this->addSql('ALTER TABLE annoncerecrutement ADD CONSTRAINT FK_58D406E2A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_58D406E2A76ED395 ON annoncerecrutement (user_id)');
        $this->addSql('ALTER TABLE candidature ADD idannrecru_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL, ADD archived TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B898FB9136 FOREIGN KEY (idannrecru_id) REFERENCES annoncerecrutement (idRecrut)');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B8A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_E33BD3B898FB9136 ON candidature (idannrecru_id)');
        $this->addSql('CREATE INDEX IDX_E33BD3B8A76ED395 ON candidature (user_id)');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_USER_PRODUIT');
        $this->addSql('ALTER TABLE produit CHANGE image image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_USER_RECLAMATION');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY fk_produit_id');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_RECLAMATION_PRODUIT');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY fk_user_id');
        $this->addSql('ALTER TABLE user CHANGE image image VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonceinvestissement DROP FOREIGN KEY FK_5FE22F97A76ED395');
        $this->addSql('DROP TABLE annonceinvestissement');
        $this->addSql('ALTER TABLE annoncerecrutement DROP FOREIGN KEY FK_58D406E2A76ED395');
        $this->addSql('DROP INDEX IDX_58D406E2A76ED395 ON annoncerecrutement');
        $this->addSql('ALTER TABLE annoncerecrutement DROP user_id, DROP archived, CHANGE date_pub date_pub VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B898FB9136');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B8A76ED395');
        $this->addSql('DROP INDEX IDX_E33BD3B898FB9136 ON candidature');
        $this->addSql('DROP INDEX IDX_E33BD3B8A76ED395 ON candidature');
        $this->addSql('ALTER TABLE candidature DROP idannrecru_id, DROP user_id, DROP archived');
        $this->addSql('ALTER TABLE `produit` CHANGE image image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE `produit` ADD CONSTRAINT FK_USER_PRODUIT FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_USER_RECLAMATION FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT fk_produit_id FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_RECLAMATION_PRODUIT FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `user` CHANGE image image VARCHAR(255) DEFAULT NULL');
    }
}
