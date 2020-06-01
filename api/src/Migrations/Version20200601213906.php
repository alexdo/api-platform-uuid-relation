<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200601213906 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE greeter_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE greeter (id INT NOT NULL, uuid UUID NOT NULL, greeter_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3DC4B1ADD17F50A6 ON greeter (uuid)');
        $this->addSql('COMMENT ON COLUMN greeter.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE greeting_greeters (greeting_id INT NOT NULL, greeter_id INT NOT NULL, PRIMARY KEY(greeting_id, greeter_id))');
        $this->addSql('CREATE INDEX IDX_3E2B31334004BDD8 ON greeting_greeters (greeting_id)');
        $this->addSql('CREATE INDEX IDX_3E2B3133D636926E ON greeting_greeters (greeter_id)');
        $this->addSql('ALTER TABLE greeting_greeters ADD CONSTRAINT FK_3E2B31334004BDD8 FOREIGN KEY (greeting_id) REFERENCES greeting (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE greeting_greeters ADD CONSTRAINT FK_3E2B3133D636926E FOREIGN KEY (greeter_id) REFERENCES greeter (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE greeting ADD uuid UUID NOT NULL');
        $this->addSql('COMMENT ON COLUMN greeting.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_46E3A4ABD17F50A6 ON greeting (uuid)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE greeting_greeters DROP CONSTRAINT FK_3E2B3133D636926E');
        $this->addSql('DROP SEQUENCE greeter_id_seq CASCADE');
        $this->addSql('DROP TABLE greeter');
        $this->addSql('DROP TABLE greeting_greeters');
        $this->addSql('DROP INDEX UNIQ_46E3A4ABD17F50A6');
        $this->addSql('ALTER TABLE greeting DROP uuid');
    }
}
