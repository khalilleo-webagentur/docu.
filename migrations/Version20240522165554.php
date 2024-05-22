<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240522165554 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE temp_user (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, email VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_249A5903A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, token VARCHAR(100) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, is_deleted TINYINT(1) NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_setting (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_C779A692A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE temp_user ADD CONSTRAINT FK_249A5903A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user_setting ADD CONSTRAINT FK_C779A692A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE temp_user DROP FOREIGN KEY FK_249A5903A76ED395');
        $this->addSql('ALTER TABLE user_setting DROP FOREIGN KEY FK_C779A692A76ED395');
        $this->addSql('DROP TABLE temp_user');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_setting');
    }
}