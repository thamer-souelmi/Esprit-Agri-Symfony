<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231117212812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annoncerecrutement DROP FOREIGN KEY fk_idrecrute_user');
        $this->addSql('ALTER TABLE annoncerecrutement CHANGE idUser idUser INT DEFAULT NULL');
        $this->addSql('ALTER TABLE annoncerecrutement ADD CONSTRAINT FK_58D406E2FE6E88D7 FOREIGN KEY (idUser) REFERENCES user (id)');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY fk_idOuvrier');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY fk_idAnnRecru');
        $this->addSql('ALTER TABLE candidature CHANGE idAnnRecru idAnnRecru INT DEFAULT NULL');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B8FA6B7CA1 FOREIGN KEY (idAnnRecru) REFERENCES annoncerecrutement (idRecurt)');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B84545E8BC FOREIGN KEY (idOuvrierfor) REFERENCES ouvrier (idOuvrier)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annoncerecrutement DROP FOREIGN KEY FK_58D406E2FE6E88D7');
        $this->addSql('ALTER TABLE annoncerecrutement CHANGE idUser idUser INT NOT NULL');
        $this->addSql('ALTER TABLE annoncerecrutement ADD CONSTRAINT fk_idrecrute_user FOREIGN KEY (idUser) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B8FA6B7CA1');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B84545E8BC');
        $this->addSql('ALTER TABLE candidature CHANGE idAnnRecru idAnnRecru INT NOT NULL');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT fk_idOuvrier FOREIGN KEY (idOuvrierfor) REFERENCES ouvrier (idOuvrier) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT fk_idAnnRecru FOREIGN KEY (idAnnRecru) REFERENCES annoncerecrutement (idRecurt) ON DELETE CASCADE');
    }
}
