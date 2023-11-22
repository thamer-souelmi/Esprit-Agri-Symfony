<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231114153138 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annoncerecrutement ADD idCandidature INT DEFAULT NULL');
        $this->addSql('ALTER TABLE annoncerecrutement ADD CONSTRAINT FK_58D406E2A3662CC0 FOREIGN KEY (idCandidature) REFERENCES candidature (idCandidature)');
        $this->addSql('CREATE INDEX fk_annonce_candidature ON annoncerecrutement (idCandidature)');
        $this->addSql('ALTER TABLE candidature ADD idRecurt INT DEFAULT NULL');
        $this->addSql('CREATE INDEX fk_candidature_annonce ON candidature (idRecurt)');
        $this->addSql('ALTER TABLE culture ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE culture ADD CONSTRAINT FK_B6A99CEBA76ED395 FOREIGN KEY (user_id) REFERENCES user (userId)');
        $this->addSql('CREATE INDEX fk_user_id ON culture (user_id)');
        $this->addSql('ALTER TABLE user MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON user');
        $this->addSql('ALTER TABLE user CHANGE cin cin INT NOT NULL, CHANGE id userId INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE user ADD PRIMARY KEY (userId)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annoncerecrutement DROP FOREIGN KEY FK_58D406E2A3662CC0');
        $this->addSql('DROP INDEX fk_annonce_candidature ON annoncerecrutement');
        $this->addSql('ALTER TABLE annoncerecrutement DROP idCandidature');
        $this->addSql('DROP INDEX fk_candidature_annonce ON candidature');
        $this->addSql('ALTER TABLE candidature DROP idRecurt');
        $this->addSql('ALTER TABLE culture DROP FOREIGN KEY FK_B6A99CEBA76ED395');
        $this->addSql('DROP INDEX fk_user_id ON culture');
        $this->addSql('ALTER TABLE culture DROP user_id');
        $this->addSql('ALTER TABLE user MODIFY userId INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON user');
        $this->addSql('ALTER TABLE user CHANGE cin cin VARCHAR(255) NOT NULL, CHANGE userId id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE user ADD PRIMARY KEY (id)');
    }
}
