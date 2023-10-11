<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231011065312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE allergens DROP FOREIGN KEY FK_67F79FB46C8A81A9');
        $this->addSql('DROP INDEX IDX_67F79FB46C8A81A9 ON allergens');
        $this->addSql('ALTER TABLE allergens DROP products_id');
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF34668B3750AF4');
        $this->addSql('DROP INDEX IDX_3AF34668B3750AF4 ON categories');
        $this->addSql('ALTER TABLE categories CHANGE parent_id parent_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668B3750AF4 FOREIGN KEY (parent_id_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_3AF34668B3750AF4 ON categories (parent_id_id)');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A7B478B1A');
        $this->addSql('DROP INDEX IDX_B3BA5A5A7B478B1A ON products');
        $this->addSql('ALTER TABLE products CHANGE categories_id categories_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A7B478B1A FOREIGN KEY (categories_id_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A7B478B1A ON products (categories_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE allergens ADD products_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE allergens ADD CONSTRAINT FK_67F79FB46C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_67F79FB46C8A81A9 ON allergens (products_id)');
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF34668B3750AF4');
        $this->addSql('DROP INDEX IDX_3AF34668B3750AF4 ON categories');
        $this->addSql('ALTER TABLE categories CHANGE parent_id_id parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668B3750AF4 FOREIGN KEY (parent_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_3AF34668B3750AF4 ON categories (parent_id)');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A7B478B1A');
        $this->addSql('DROP INDEX IDX_B3BA5A5A7B478B1A ON products');
        $this->addSql('ALTER TABLE products CHANGE categories_id_id categories_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A7B478B1A FOREIGN KEY (categories_id) REFERENCES categories (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A7B478B1A ON products (categories_id)');
    }
}
