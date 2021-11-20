<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211120121548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE faq_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE faq_theme_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE faq (id INT NOT NULL, theme_id INT DEFAULT NULL, title VARCHAR(300) NOT NULL, icon VARCHAR(100) DEFAULT NULL, faq BOOLEAN NOT NULL, content TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E8FF75CC59027487 ON faq (theme_id)');
        $this->addSql('CREATE TABLE faq_theme (id INT NOT NULL, label VARCHAR(200) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE faq ADD CONSTRAINT FK_E8FF75CC59027487 FOREIGN KEY (theme_id) REFERENCES faq_theme (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE faq DROP CONSTRAINT FK_E8FF75CC59027487');
        $this->addSql('DROP SEQUENCE faq_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE faq_theme_id_seq CASCADE');
        $this->addSql('DROP TABLE faq');
        $this->addSql('DROP TABLE faq_theme');
    }
}
