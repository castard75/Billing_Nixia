<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240130050322 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE invoicesitems (id INT AUTO_INCREMENT NOT NULL, invoiceid_id INT DEFAULT NULL, itemprice_id INT DEFAULT NULL, specialcode INT DEFAULT NULL, rang INT DEFAULT NULL, des VARCHAR(100) DEFAULT NULL, quantity DOUBLE PRECISION DEFAULT NULL, unite INT DEFAULT NULL, supplierprice_id INT DEFAULT NULL, reference VARCHAR(255) DEFAULT NULL, name LONGTEXT DEFAULT NULL, ht DOUBLE PRECISION DEFAULT NULL, htachat DOUBLE PRECISION NOT NULL, ttc DOUBLE PRECISION DEFAULT NULL, tva DOUBLE PRECISION DEFAULT NULL, tauxremise DOUBLE PRECISION DEFAULT NULL, tauxtva DOUBLE PRECISION DEFAULT NULL, marge DOUBLE PRECISION NOT NULL, mode_price INT DEFAULT NULL, type_remise INT DEFAULT NULL, INDEX IDX_ACAA7CB520A48C29 (invoiceid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invoicesitems ADD CONSTRAINT FK_ACAA7CB520A48C29 FOREIGN KEY (invoiceid_id) REFERENCES invoices (id)');
        $this->addSql('ALTER TABLE invoices CHANGE mode mode INT DEFAULT 1');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoicesitems DROP FOREIGN KEY FK_ACAA7CB520A48C29');
        $this->addSql('DROP TABLE invoicesitems');
        $this->addSql('ALTER TABLE invoices CHANGE mode mode INT DEFAULT NULL');
    }
}
