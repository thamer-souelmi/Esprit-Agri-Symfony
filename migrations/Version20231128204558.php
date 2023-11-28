<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231128204558 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annoncerecrutement (user_id INT DEFAULT NULL, idRecrut INT AUTO_INCREMENT NOT NULL, poste_demande VARCHAR(255) NOT NULL, salaire_propose DOUBLE PRECISION NOT NULL, type_contrat VARCHAR(255) NOT NULL, date_pub DATE NOT NULL, localisation VARCHAR(25) NOT NULL, date_embauche DATE NOT NULL, nb_poste_recherche INT NOT NULL, filter1 VARCHAR(255) NOT NULL, archivedA TINYINT(1) NOT NULL, INDEX IDX_58D406E2A76ED395 (user_id), PRIMARY KEY(idRecrut)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annoncerecrutement ADD CONSTRAINT FK_58D406E2A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B898FB9136 FOREIGN KEY (idannrecru_id) REFERENCES annoncerecrutement (idRecrut)');
        $this->addSql('CREATE INDEX IDX_E33BD3B898FB9136 ON candidature (idannrecru_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B898FB9136');
        $this->addSql('ALTER TABLE annoncerecrutement DROP FOREIGN KEY FK_58D406E2A76ED395');
        $this->addSql('DROP TABLE annoncerecrutement');
        $this->addSql('DROP INDEX IDX_E33BD3B898FB9136 ON candidature');
    }
}
