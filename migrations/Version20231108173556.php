<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231108173556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, id_user INT NOT NULL, prodid INT NOT NULL, Nomprod VARCHAR(20) NOT NULL, prix DOUBLE PRECISION NOT NULL, dateajout DATE NOT NULL, qte DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marche (id INT AUTO_INCREMENT NOT NULL, Nomprod VARCHAR(30) NOT NULL, cat VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, qte DOUBLE PRECISION NOT NULL, `desc` VARCHAR(200) NOT NULL, dateajout DATE NOT NULL, status VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, user_id INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, Nomprod VARCHAR(30) NOT NULL, cat VARCHAR(30) NOT NULL, prix DOUBLE PRECISION NOT NULL, qte DOUBLE PRECISION NOT NULL, `desc` DATE NOT NULL, status TINYINT(1) NOT NULL, image VARCHAR(255) DEFAULT NULL, user_id INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE culture DROP FOREIGN KEY fk_user_id');
        $this->addSql('ALTER TABLE culture DROP FOREIGN KEY fk_category_id');
        $this->addSql('ALTER TABLE culture CHANGE category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE culture ADD CONSTRAINT FK_B6A99CEB12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE culture ADD CONSTRAINT FK_B6A99CEBA76ED395 FOREIGN KEY (user_id) REFERENCES user (userId)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE marche');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE culture DROP FOREIGN KEY FK_B6A99CEB12469DE2');
        $this->addSql('ALTER TABLE culture DROP FOREIGN KEY FK_B6A99CEBA76ED395');
        $this->addSql('ALTER TABLE culture CHANGE category_id category_id INT NOT NULL');
        $this->addSql('ALTER TABLE culture ADD CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES user (userId) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE culture ADD CONSTRAINT fk_category_id FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
    }
}
