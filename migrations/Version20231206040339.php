<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231206040339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annoncerecrutement CHANGE filter1 filter1 VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE culture CHANGE categorytype categorytype VARCHAR(150) NOT NULL');
        $this->addSql('ALTER TABLE negociation CHANGE is_archived is_archived TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE produit ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC2719EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC2719EB6921 ON produit (client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annoncerecrutement CHANGE filter1 filter1 VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE culture CHANGE categorytype categorytype VARCHAR(150) DEFAULT NULL');
        $this->addSql('ALTER TABLE negociation CHANGE is_archived is_archived TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE `produit` DROP FOREIGN KEY FK_29A5EC2719EB6921');
        $this->addSql('DROP INDEX IDX_29A5EC2719EB6921 ON `produit`');
        $this->addSql('ALTER TABLE `produit` DROP client_id');
    }
}
