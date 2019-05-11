<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190511170031 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE food_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, contract_id INT NOT NULL, name VARCHAR(255) NOT NULL, is_fixed_delivery TINYINT(1) NOT NULL, nb_delivery INT DEFAULT NULL, is_fixed_price TINYINT(1) NOT NULL, fixed_price NUMERIC(5, 2) DEFAULT NULL, min_price NUMERIC(5, 2) DEFAULT NULL, max_price NUMERIC(5, 2) DEFAULT NULL, INDEX IDX_D34A04AD2576E0FD (contract_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_food_type (product_id INT NOT NULL, food_type_id INT NOT NULL, INDEX IDX_575949754584665A (product_id), INDEX IDX_575949758AD350AB (food_type_id), PRIMARY KEY(product_id, food_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD2576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id)');
        $this->addSql('ALTER TABLE product_food_type ADD CONSTRAINT FK_575949754584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_food_type ADD CONSTRAINT FK_575949758AD350AB FOREIGN KEY (food_type_id) REFERENCES food_type (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product_food_type DROP FOREIGN KEY FK_575949758AD350AB');
        $this->addSql('ALTER TABLE product_food_type DROP FOREIGN KEY FK_575949754584665A');
        $this->addSql('DROP TABLE food_type');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_food_type');
    }
}
