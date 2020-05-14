<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200514124357 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE github_event CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('CREATE INDEX event_type_idx ON github_event (type)');
        $this->addSql('CREATE INDEX created_id_idx ON github_event (created_at)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX event_type_idx ON github_event');
        $this->addSql('DROP INDEX created_id_idx ON github_event');
        $this->addSql('ALTER TABLE github_event CHANGE created_at created_at DATETIME NOT NULL');
    }
}
