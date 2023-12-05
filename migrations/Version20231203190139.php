<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231203190139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE note ADD agriculteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA147EBB810E FOREIGN KEY (agriculteur_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA147EBB810E ON note (agriculteur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA147EBB810E');
        $this->addSql('DROP INDEX IDX_CFBDFA147EBB810E ON note');
        $this->addSql('ALTER TABLE note DROP agriculteur_id');
    }
}
