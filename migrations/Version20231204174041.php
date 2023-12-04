<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204174041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bilancomptable ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bilancomptable ADD CONSTRAINT FK_FB2FE98EA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_FB2FE98EA76ED395 ON bilancomptable (user_id)');
        $this->addSql('ALTER TABLE bilanresultat ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bilanresultat ADD CONSTRAINT FK_A693CC02A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_A693CC02A76ED395 ON bilanresultat (user_id)');
        $this->addSql('ALTER TABLE negociation CHANGE is_archived is_archived TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bilancomptable DROP FOREIGN KEY FK_FB2FE98EA76ED395');
        $this->addSql('DROP INDEX IDX_FB2FE98EA76ED395 ON bilancomptable');
        $this->addSql('ALTER TABLE bilancomptable DROP user_id');
        $this->addSql('ALTER TABLE bilanresultat DROP FOREIGN KEY FK_A693CC02A76ED395');
        $this->addSql('DROP INDEX IDX_A693CC02A76ED395 ON bilanresultat');
        $this->addSql('ALTER TABLE bilanresultat DROP user_id');
        $this->addSql('ALTER TABLE negociation CHANGE is_archived is_archived TINYINT(1) DEFAULT NULL');
    }
}
