<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210109164555 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE horaire CHANGE jour2 jour2 VARCHAR(255) NOT NULL, CHANGE jour3 jour3 VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE information DROP FOREIGN KEY FK_29791883858C55AD');
        $this->addSql('DROP INDEX uniq_29791883858c55ad ON information');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2979188358C54515 ON information (horaire_id)');
        $this->addSql('ALTER TABLE information ADD CONSTRAINT FK_29791883858C55AD FOREIGN KEY (horaire_id) REFERENCES horaire (id)');
        $this->addSql('ALTER TABLE site ADD google VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE horaire CHANGE jour2 jour2 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE jour3 jour3 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE information DROP FOREIGN KEY FK_2979188358C54515');
        $this->addSql('DROP INDEX uniq_2979188358c54515 ON information');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_29791883858C55AD ON information (horaire_id)');
        $this->addSql('ALTER TABLE information ADD CONSTRAINT FK_2979188358C54515 FOREIGN KEY (horaire_id) REFERENCES horaire (id)');
        $this->addSql('ALTER TABLE site DROP google');
    }
}
