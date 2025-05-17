<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250517211204 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE `doc_category` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(180) NOT NULL, description LONGTEXT NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE `doc_item` (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, slug VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, read_time VARCHAR(10) NOT NULL, likes INT NOT NULL, dis_likes INT NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_460192C812469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE `doc_temp_user` (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, email VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_D8426562A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE `doc_user` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, token VARCHAR(100) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, is_deleted TINYINT(1) NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `doc_item` ADD CONSTRAINT FK_460192C812469DE2 FOREIGN KEY (category_id) REFERENCES `doc_category` (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `doc_temp_user` ADD CONSTRAINT FK_D8426562A76ED395 FOREIGN KEY (user_id) REFERENCES `doc_user` (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE `doc_item` DROP FOREIGN KEY FK_460192C812469DE2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `doc_temp_user` DROP FOREIGN KEY FK_D8426562A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE `doc_category`
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE `doc_item`
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE `doc_temp_user`
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE `doc_user`
        SQL);
    }
}
