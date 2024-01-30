<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240129165755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE invoices (id INT AUTO_INCREMENT NOT NULL, origineid_id INT DEFAULT NULL, customerid_id INT DEFAULT NULL, referencebr VARCHAR(20) DEFAULT NULL, reference VARCHAR(20) DEFAULT NULL, refext VARCHAR(100) DEFAULT NULL, state INT DEFAULT NULL, dolid INT DEFAULT NULL, date DATE DEFAULT NULL, datelimit DATE DEFAULT NULL, conditions INT DEFAULT NULL, totalht DOUBLE PRECISION DEFAULT NULL, totalttc DOUBLE PRECISION DEFAULT NULL, totaltva DOUBLE PRECISION DEFAULT NULL, topay DOUBLE PRECISION DEFAULT NULL, createdat DATETIME DEFAULT NULL, updatedat DATETIME DEFAULT NULL, deletedat DATETIME DEFAULT NULL, mode INT DEFAULT NULL, message VARCHAR(250) DEFAULT NULL, notepublic LONGTEXT DEFAULT NULL, noteprive LONGTEXT DEFAULT NULL, type VARCHAR(1) DEFAULT NULL, transfert VARCHAR(1) DEFAULT NULL, INDEX IDX_6A2F2F9567DF6678 (origineid_id), INDEX IDX_6A2F2F9576F04A3B (customerid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invoices ADD CONSTRAINT FK_6A2F2F9567DF6678 FOREIGN KEY (origineid_id) REFERENCES myconnectors (id)');
        $this->addSql('ALTER TABLE invoices ADD CONSTRAINT FK_6A2F2F9576F04A3B FOREIGN KEY (customerid_id) REFERENCES customers (id)');
        $this->addSql('ALTER TABLE contracts ADD origineid_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contracts ADD CONSTRAINT FK_950A97367DF6678 FOREIGN KEY (origineid_id) REFERENCES myconnectors (id)');
        $this->addSql('CREATE INDEX IDX_950A97367DF6678 ON contracts (origineid_id)');
        $this->addSql('ALTER TABLE customers ADD origineid_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE customers ADD CONSTRAINT FK_62534E2167DF6678 FOREIGN KEY (origineid_id) REFERENCES myconnectors (id)');
        $this->addSql('CREATE INDEX IDX_62534E2167DF6678 ON customers (origineid_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoices DROP FOREIGN KEY FK_6A2F2F9567DF6678');
        $this->addSql('ALTER TABLE invoices DROP FOREIGN KEY FK_6A2F2F9576F04A3B');
        $this->addSql('DROP TABLE invoices');
        $this->addSql('ALTER TABLE contracts DROP FOREIGN KEY FK_950A97367DF6678');
        $this->addSql('DROP INDEX IDX_950A97367DF6678 ON contracts');
        $this->addSql('ALTER TABLE contracts DROP origineid_id');
        $this->addSql('ALTER TABLE customers DROP FOREIGN KEY FK_62534E2167DF6678');
        $this->addSql('DROP INDEX IDX_62534E2167DF6678 ON customers');
        $this->addSql('ALTER TABLE customers DROP origineid_id');
    }
}
