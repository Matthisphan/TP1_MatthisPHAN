<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241002150152 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category RENAME COLUMN nom TO name');
        $this->addSql('ALTER TABLE language RENAME COLUMN nom TO name');
        $this->addSql('ALTER TABLE media ADD short_description TEXT NOT NULL');
        $this->addSql('ALTER TABLE media ADD long_description TEXT NOT NULL');
        $this->addSql('ALTER TABLE media ADD title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE media ADD release_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE media ADD cover_image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE media ADD staff JSON NOT NULL');
        $this->addSql('ALTER TABLE media ADD casting JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE media DROP short_description');
        $this->addSql('ALTER TABLE media DROP long_description');
        $this->addSql('ALTER TABLE media DROP title');
        $this->addSql('ALTER TABLE media DROP release_date');
        $this->addSql('ALTER TABLE media DROP cover_image');
        $this->addSql('ALTER TABLE media DROP staff');
        $this->addSql('ALTER TABLE media DROP casting');
        $this->addSql('ALTER TABLE category RENAME COLUMN name TO nom');
        $this->addSql('ALTER TABLE language RENAME COLUMN name TO nom');
    }
}
