<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210711084103 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE candidate_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE political_party_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "primary_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE candidate (id INT NOT NULL, party_primary_id INT DEFAULT NULL, political_party_id INT NOT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, biography TEXT DEFAULT NULL, elected_by_primary BOOLEAN NOT NULL, second_round_elections BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C8B28E4429A5F120 ON candidate (party_primary_id)');
        $this->addSql('CREATE INDEX IDX_C8B28E4427268D9C ON candidate (political_party_id)');
        $this->addSql('CREATE TABLE political_party (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, site_link VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CEABE1695E237E06 ON political_party (name)');
        $this->addSql('CREATE TABLE "primary" (id INT NOT NULL, political_party_id INT NOT NULL, date_first_round DATE DEFAULT NULL, date_second_round DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1745EA8627268D9C ON "primary" (political_party_id)');
        $this->addSql('ALTER TABLE candidate ADD CONSTRAINT FK_C8B28E4429A5F120 FOREIGN KEY (party_primary_id) REFERENCES "primary" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE candidate ADD CONSTRAINT FK_C8B28E4427268D9C FOREIGN KEY (political_party_id) REFERENCES political_party (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "primary" ADD CONSTRAINT FK_1745EA8627268D9C FOREIGN KEY (political_party_id) REFERENCES political_party (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE candidate DROP CONSTRAINT FK_C8B28E4427268D9C');
        $this->addSql('ALTER TABLE "primary" DROP CONSTRAINT FK_1745EA8627268D9C');
        $this->addSql('ALTER TABLE candidate DROP CONSTRAINT FK_C8B28E4429A5F120');
        $this->addSql('DROP SEQUENCE candidate_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE political_party_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "primary_id_seq" CASCADE');
        $this->addSql('DROP TABLE candidate');
        $this->addSql('DROP TABLE political_party');
        $this->addSql('DROP TABLE "primary"');
    }
}
