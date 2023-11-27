<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
<<<<<<<< HEAD:migrations/Version20231126194346.php
final class Version20231126194346 extends AbstractMigration
========
final class Version20231124222753 extends AbstractMigration
>>>>>>>> 07ea0df1d3f65b96ceb9439313392fcd2fd5356d:migrations/Version20231124222753.php
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
<<<<<<<< HEAD:migrations/Version20231126194346.php
        $this->addSql('ALTER TABLE candidature ADD archived TINYINT(1) NOT NULL');
========
        $this->addSql('ALTER TABLE culture CHANGE categorys_id categorys_id INT NOT NULL');
>>>>>>>> 07ea0df1d3f65b96ceb9439313392fcd2fd5356d:migrations/Version20231124222753.php
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
<<<<<<<< HEAD:migrations/Version20231126194346.php
        $this->addSql('ALTER TABLE candidature DROP archived');
========
        $this->addSql('ALTER TABLE culture CHANGE categorys_id categorys_id INT DEFAULT NULL');
>>>>>>>> 07ea0df1d3f65b96ceb9439313392fcd2fd5356d:migrations/Version20231124222753.php
    }
}
