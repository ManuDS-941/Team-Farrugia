<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210107220236 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE information ADD site_id INT NOT NULL, ADD horaire_id INT NOT NULL');
        $this->addSql('ALTER TABLE information ADD CONSTRAINT FK_29791883F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('ALTER TABLE information ADD CONSTRAINT FK_29791883858C55AD FOREIGN KEY (horaire_id) REFERENCES horaire (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_29791883F6BD1646 ON information (site_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_29791883858C55AD ON information (horaire_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE information DROP FOREIGN KEY FK_29791883F6BD1646');
        $this->addSql('ALTER TABLE information DROP FOREIGN KEY FK_29791883858C55AD');
        $this->addSql('DROP INDEX UNIQ_29791883F6BD1646 ON information');
        $this->addSql('DROP INDEX UNIQ_29791883858C55AD ON information');
        $this->addSql('ALTER TABLE information DROP site_id, DROP horaire_id');
    }
}
