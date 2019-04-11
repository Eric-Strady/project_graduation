<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190411143250 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contract DROP image_title, DROP image_ext');
        $this->addSql('ALTER TABLE post DROP image_title, DROP image_ext');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contract ADD image_title VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD image_ext VARCHAR(4) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE post ADD image_title VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD image_ext VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
