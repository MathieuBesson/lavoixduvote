<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210729154231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE glossary_category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE glossary_category (id INT NOT NULL, label VARCHAR(20) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE glossary ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE glossary ADD CONSTRAINT FK_B0850B4312469DE2 FOREIGN KEY (category_id) REFERENCES glossary_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B0850B4312469DE2 ON glossary (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE glossary DROP CONSTRAINT FK_B0850B4312469DE2');
        $this->addSql('DROP SEQUENCE glossary_category_id_seq CASCADE');
        $this->addSql('DROP TABLE glossary_category');
        $this->addSql('DROP INDEX IDX_B0850B4312469DE2');
        $this->addSql('ALTER TABLE glossary DROP category_id');
    }
}
