<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210719122630 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE star_measure ADD candidate_id INT NOT NULL');
        $this->addSql('ALTER TABLE star_measure ADD CONSTRAINT FK_17E7173691BD8781 FOREIGN KEY (candidate_id) REFERENCES candidate (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_17E7173691BD8781 ON star_measure (candidate_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE star_measure DROP CONSTRAINT FK_17E7173691BD8781');
        $this->addSql('DROP INDEX IDX_17E7173691BD8781');
        $this->addSql('ALTER TABLE star_measure DROP candidate_id');
    }
}
