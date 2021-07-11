<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210711170832 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE action_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE program_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE theme_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE action (id INT NOT NULL, theme_id INT NOT NULL, title VARCHAR(255) NOT NULL, importance INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_47CC8C9259027487 ON action (theme_id)');
        $this->addSql('CREATE TABLE program (id INT NOT NULL, candidate_id INT NOT NULL, presentation TEXT NOT NULL, program_link VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_92ED778491BD8781 ON program (candidate_id)');
        $this->addSql('CREATE TABLE program_action (program_id INT NOT NULL, action_id INT NOT NULL, PRIMARY KEY(program_id, action_id))');
        $this->addSql('CREATE INDEX IDX_138CB2C83EB8070A ON program_action (program_id)');
        $this->addSql('CREATE INDEX IDX_138CB2C89D32F035 ON program_action (action_id)');
        $this->addSql('CREATE TABLE theme (id INT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C9259027487 FOREIGN KEY (theme_id) REFERENCES theme (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program ADD CONSTRAINT FK_92ED778491BD8781 FOREIGN KEY (candidate_id) REFERENCES candidate (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program_action ADD CONSTRAINT FK_138CB2C83EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program_action ADD CONSTRAINT FK_138CB2C89D32F035 FOREIGN KEY (action_id) REFERENCES action (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE program_action DROP CONSTRAINT FK_138CB2C89D32F035');
        $this->addSql('ALTER TABLE program_action DROP CONSTRAINT FK_138CB2C83EB8070A');
        $this->addSql('ALTER TABLE action DROP CONSTRAINT FK_47CC8C9259027487');
        $this->addSql('DROP SEQUENCE action_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE program_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE theme_id_seq CASCADE');
        $this->addSql('DROP TABLE action');
        $this->addSql('DROP TABLE program');
        $this->addSql('DROP TABLE program_action');
        $this->addSql('DROP TABLE theme');
    }
}
