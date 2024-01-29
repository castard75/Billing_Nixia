<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240129161334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contracts (id INT AUTO_INCREMENT NOT NULL, customerid_id INT DEFAULT NULL, referencebr VARCHAR(200) DEFAULT NULL, reference VARCHAR(20) DEFAULT NULL, refext VARCHAR(25) DEFAULT NULL, dolid INT DEFAULT NULL, state INT DEFAULT NULL, date DATE DEFAULT NULL, totalht DOUBLE PRECISION DEFAULT NULL, totalttc DOUBLE PRECISION DEFAULT NULL, totaltva DOUBLE PRECISION DEFAULT NULL, deletedat DATETIME DEFAULT NULL, notepublic LONGTEXT DEFAULT NULL, noteprive LONGTEXT DEFAULT NULL, transfert VARCHAR(1) DEFAULT NULL, INDEX IDX_950A97376F04A3B (customerid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contracts ADD CONSTRAINT FK_950A97376F04A3B FOREIGN KEY (customerid_id) REFERENCES customers (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contracts DROP FOREIGN KEY FK_950A97376F04A3B');
        $this->addSql('DROP TABLE contracts');
    }
}
