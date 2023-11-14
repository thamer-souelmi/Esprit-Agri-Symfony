<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231114145902 extends AbstractMigration
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
        $this->addSql('ALTER TABLE culture DROP user_id');
        $this->addSql('DROP INDEX IDX_75EA56E0FB7336F0 ON messenger_messages');
        $this->addSql('DROP INDEX IDX_75EA56E0E3BD61CE ON messenger_messages');
        $this->addSql('DROP INDEX IDX_75EA56E016BA31DB ON messenger_messages');
        $this->addSql('ALTER TABLE negociation CHANGE etatNego etatNego VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annoncerecrutement DROP FOREIGN KEY FK_58D406E2A3662CC0');
        $this->addSql('DROP INDEX fk_annonce_candidature ON annoncerecrutement');
        $this->addSql('ALTER TABLE annoncerecrutement DROP idCandidature');
        $this->addSql('DROP INDEX fk_candidature_annonce ON candidature');
        $this->addSql('ALTER TABLE candidature DROP idRecurt');
        $this->addSql('ALTER TABLE culture ADD user_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('ALTER TABLE negociation CHANGE etatNego etatNego VARCHAR(255) DEFAULT NULL');
    }
}
