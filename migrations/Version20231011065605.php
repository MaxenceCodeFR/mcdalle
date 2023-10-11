<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231011065605 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE products_allergens (products_id INT NOT NULL, allergens_id INT NOT NULL, INDEX IDX_358A7C926C8A81A9 (products_id), INDEX IDX_358A7C92711662F1 (allergens_id), PRIMARY KEY(products_id, allergens_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE products_allergens ADD CONSTRAINT FK_358A7C926C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products_allergens ADD CONSTRAINT FK_358A7C92711662F1 FOREIGN KEY (allergens_id) REFERENCES allergens (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products_allergens DROP FOREIGN KEY FK_358A7C926C8A81A9');
        $this->addSql('ALTER TABLE products_allergens DROP FOREIGN KEY FK_358A7C92711662F1');
        $this->addSql('DROP TABLE products_allergens');
    }
}
