<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231010170756 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, categories_id_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, images VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_B3BA5A5A7B478B1A (categories_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A7B478B1A FOREIGN KEY (categories_id_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE allergens ADD products_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE allergens ADD CONSTRAINT FK_67F79FB46C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id)');
        $this->addSql('CREATE INDEX IDX_67F79FB46C8A81A9 ON allergens (products_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE allergens DROP FOREIGN KEY FK_67F79FB46C8A81A9');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A7B478B1A');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP INDEX IDX_67F79FB46C8A81A9 ON allergens');
        $this->addSql('ALTER TABLE allergens DROP products_id');
    }
}
