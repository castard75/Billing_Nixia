<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240129111720 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE customers (id INT AUTO_INCREMENT NOT NULL, dolid INT DEFAULT NULL, civility INT DEFAULT NULL, name VARCHAR(150) DEFAULT NULL, firstname VARCHAR(150) DEFAULT NULL, reference VARCHAR(50) DEFAULT NULL, referencesupplier VARCHAR(50) DEFAULT NULL, siren VARCHAR(20) DEFAULT NULL, siret VARCHAR(20) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, additionaladdress VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, fixphone VARCHAR(45) DEFAULT NULL, mobilephone VARCHAR(45) DEFAULT NULL, cityid INT DEFAULT NULL, postcode VARCHAR(50) DEFAULT NULL, namecity VARCHAR(250) DEFAULT NULL, countryid INT DEFAULT 181, customertypeid INT DEFAULT NULL, companyid INT DEFAULT NULL, conditionreglement INT DEFAULT NULL, modereglement INT DEFAULT NULL, status INT DEFAULT 1, state INT DEFAULT 1, codecompta VARCHAR(100) DEFAULT NULL, createdat DATETIME DEFAULT CURRENT_TIMESTAMP, updatedat DATETIME DEFAULT CURRENT_TIMESTAMP, deletedat DATETIME DEFAULT NULL, customerstate INT DEFAULT NULL, supplierstate INT DEFAULT NULL, classe INT DEFAULT NULL, datecustomer DATETIME DEFAULT NULL, dateupdatecustomer DATETIME DEFAULT NULL, transfert VARCHAR(1) DEFAULT NULL, pricelevel INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE customers');
    }
}
