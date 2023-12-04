<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204172102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE negociation ADD users_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE negociation ADD CONSTRAINT FK_B5E137D867B3B43D FOREIGN KEY (users_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_B5E137D867B3B43D ON negociation (users_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE negociation DROP FOREIGN KEY FK_B5E137D867B3B43D');
        $this->addSql('DROP INDEX IDX_B5E137D867B3B43D ON negociation');
        $this->addSql('ALTER TABLE negociation DROP users_id');
    }
}
