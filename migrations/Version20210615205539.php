<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210615205539 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calandrier ADD voyage_regulier_id INT NOT NULL');
        $this->addSql('ALTER TABLE calandrier ADD CONSTRAINT FK_463A18AA7FA88ADA FOREIGN KEY (voyage_regulier_id) REFERENCES voyage_regulier (id)');
        $this->addSql('CREATE INDEX IDX_463A18AA7FA88ADA ON calandrier (voyage_regulier_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calandrier DROP FOREIGN KEY FK_463A18AA7FA88ADA');
        $this->addSql('DROP INDEX IDX_463A18AA7FA88ADA ON calandrier');
        $this->addSql('ALTER TABLE calandrier DROP voyage_regulier_id');
    }
}
