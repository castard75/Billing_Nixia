<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240130052043 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE link_contract_invoice (id INT AUTO_INCREMENT NOT NULL, contractid_id INT NOT NULL, invoiceid_id INT DEFAULT NULL, INDEX IDX_DF6964974A14A024 (contractid_id), INDEX IDX_DF69649720A48C29 (invoiceid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE link_contract_invoice ADD CONSTRAINT FK_DF6964974A14A024 FOREIGN KEY (contractid_id) REFERENCES contracts (id)');
        $this->addSql('ALTER TABLE link_contract_invoice ADD CONSTRAINT FK_DF69649720A48C29 FOREIGN KEY (invoiceid_id) REFERENCES invoices (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE link_contract_invoice DROP FOREIGN KEY FK_DF6964974A14A024');
        $this->addSql('ALTER TABLE link_contract_invoice DROP FOREIGN KEY FK_DF69649720A48C29');
        $this->addSql('DROP TABLE link_contract_invoice');
    }
}
