<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240526174436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE docu_catigory (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(180) NOT NULL, description LONGTEXT NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE docu_item (id INT AUTO_INCREMENT NOT NULL, catigory_id INT NOT NULL, slug VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, likes INT NOT NULL, dis_likes INT NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_8BE01E0345E988AD (catigory_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `docu_temp_user` (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, email VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_377CA6BFA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `docu_user` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, token VARCHAR(100) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, is_deleted TINYINT(1) NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE docu_item ADD CONSTRAINT FK_8BE01E0345E988AD FOREIGN KEY (catigory_id) REFERENCES docu_catigory (id)');
        $this->addSql('ALTER TABLE `docu_temp_user` ADD CONSTRAINT FK_377CA6BFA76ED395 FOREIGN KEY (user_id) REFERENCES `docu_user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE docu_item DROP FOREIGN KEY FK_8BE01E0345E988AD');
        $this->addSql('ALTER TABLE `docu_temp_user` DROP FOREIGN KEY FK_377CA6BFA76ED395');
        $this->addSql('DROP TABLE docu_catigory');
        $this->addSql('DROP TABLE docu_item');
        $this->addSql('DROP TABLE `docu_temp_user`');
        $this->addSql('DROP TABLE `docu_user`');
    }
}
