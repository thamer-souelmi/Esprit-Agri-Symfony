<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231124214834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE culture DROP FOREIGN KEY FK_B6A99CEB12469DE2');
        $this->addSql('DROP INDEX IDX_B6A99CEB12469DE2 ON culture');
        $this->addSql('ALTER TABLE culture CHANGE category_id categorys_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE culture ADD CONSTRAINT FK_B6A99CEBA96778EC FOREIGN KEY (categorys_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_B6A99CEBA96778EC ON culture (categorys_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE culture DROP FOREIGN KEY FK_B6A99CEBA96778EC');
        $this->addSql('DROP INDEX IDX_B6A99CEBA96778EC ON culture');
        $this->addSql('ALTER TABLE culture CHANGE categorys_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE culture ADD CONSTRAINT FK_B6A99CEB12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_B6A99CEB12469DE2 ON culture (category_id)');
    }
}
