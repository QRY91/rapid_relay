<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230515001816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE athlete (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, age INTEGER NOT NULL, gender VARCHAR(255) NOT NULL, is_active BOOLEAN NOT NULL)');
        $this->addSql('CREATE TABLE discipline (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE relay (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE relay_discipline (relay_id INTEGER NOT NULL, discipline_id INTEGER NOT NULL, PRIMARY KEY(relay_id, discipline_id), CONSTRAINT FK_74182F5668A482E FOREIGN KEY (relay_id) REFERENCES relay (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_74182F56A5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_74182F5668A482E ON relay_discipline (relay_id)');
        $this->addSql('CREATE INDEX IDX_74182F56A5522701 ON relay_discipline (discipline_id)');
        $this->addSql('CREATE TABLE result (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, athlete_id INTEGER NOT NULL, discipline_id INTEGER NOT NULL, date DATE NOT NULL, outcome INTEGER NOT NULL, CONSTRAINT FK_136AC113FE6BCB8B FOREIGN KEY (athlete_id) REFERENCES athlete (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_136AC113A5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_136AC113FE6BCB8B ON result (athlete_id)');
        $this->addSql('CREATE INDEX IDX_136AC113A5522701 ON result (discipline_id)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE athlete');
        $this->addSql('DROP TABLE discipline');
        $this->addSql('DROP TABLE relay');
        $this->addSql('DROP TABLE relay_discipline');
        $this->addSql('DROP TABLE result');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
