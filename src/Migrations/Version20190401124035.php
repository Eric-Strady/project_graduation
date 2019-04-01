<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190401124035 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contract ADD grower_name VARCHAR(255) NOT NULL, ADD summary LONGTEXT NOT NULL, ADD starting_season_at DATE DEFAULT NULL, ADD ending_season_at DATE DEFAULT NULL, ADD all_year TINYINT(1) NOT NULL, ADD grower_gps_lat DOUBLE PRECISION NOT NULL, ADD grower_gps_lng DOUBLE PRECISION NOT NULL, ADD image_title VARCHAR(255) NOT NULL, ADD image_ext VARCHAR(4) NOT NULL, DROP price');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contract ADD price INT NOT NULL, DROP grower_name, DROP summary, DROP starting_season_at, DROP ending_season_at, DROP all_year, DROP grower_gps_lat, DROP grower_gps_lng, DROP image_title, DROP image_ext');
    }
}
