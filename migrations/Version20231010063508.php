<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231010063508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF34668B3750AF4');
        $this->addSql('DROP INDEX IDX_3AF34668B3750AF4 ON categories');
        $this->addSql('ALTER TABLE categories CHANGE parent_id parent_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668B3750AF4 FOREIGN KEY (parent_id_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_3AF34668B3750AF4 ON categories (parent_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE users');
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF34668B3750AF4');
        $this->addSql('DROP INDEX IDX_3AF34668B3750AF4 ON categories');
        $this->addSql('ALTER TABLE categories CHANGE parent_id_id parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668B3750AF4 FOREIGN KEY (parent_id) REFERENCES categories (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_3AF34668B3750AF4 ON categories (parent_id)');
    }
}
