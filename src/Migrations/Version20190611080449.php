<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190611080449 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contract ADD grower_id INT NOT NULL, DROP grower_name, DROP grower_gps_lat, DROP grower_gps_lng');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F28595243E353 FOREIGN KEY (grower_id) REFERENCES grower (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E98F28595243E353 ON contract (grower_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contract DROP FOREIGN KEY FK_E98F28595243E353');
        $this->addSql('DROP INDEX UNIQ_E98F28595243E353 ON contract');
        $this->addSql('ALTER TABLE contract ADD grower_name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD grower_gps_lat DOUBLE PRECISION NOT NULL, ADD grower_gps_lng DOUBLE PRECISION NOT NULL, DROP grower_id');
    }
}
