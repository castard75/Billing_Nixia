<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240130060112 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE controle (id INT AUTO_INCREMENT NOT NULL, customerid_id INT DEFAULT NULL, contratid_id INT DEFAULT NULL, telephoneid_id INT DEFAULT NULL, origineid_id INT DEFAULT NULL, dolid INT DEFAULT NULL, name VARCHAR(150) DEFAULT NULL, trprincipal VARCHAR(150) DEFAULT NULL, trsecondaire VARCHAR(150) DEFAULT NULL, codesite VARCHAR(150) DEFAULT NULL, adresseip VARCHAR(150) DEFAULT NULL, reference VARCHAR(50) DEFAULT NULL, status INT DEFAULT 1, createdat DATETIME DEFAULT CURRENT_TIMESTAMP, updatedat DATETIME DEFAULT CURRENT_TIMESTAMP, deletedat DATETIME DEFAULT NULL, transfert VARCHAR(1) DEFAULT NULL, niveau INT DEFAULT 1, startserviceat DATETIME DEFAULT NULL, outserviceat DATETIME DEFAULT NULL, endserviceat DATETIME DEFAULT NULL, INDEX IDX_E39396E76F04A3B (customerid_id), INDEX IDX_E39396E6F354B52 (contratid_id), INDEX IDX_E39396E1F90E30F (telephoneid_id), INDEX IDX_E39396E67DF6678 (origineid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE controle ADD CONSTRAINT FK_E39396E76F04A3B FOREIGN KEY (customerid_id) REFERENCES customers (id)');
        $this->addSql('ALTER TABLE controle ADD CONSTRAINT FK_E39396E6F354B52 FOREIGN KEY (contratid_id) REFERENCES contracts (id)');
        $this->addSql('ALTER TABLE controle ADD CONSTRAINT FK_E39396E1F90E30F FOREIGN KEY (telephoneid_id) REFERENCES telephone (id)');
        $this->addSql('ALTER TABLE controle ADD CONSTRAINT FK_E39396E67DF6678 FOREIGN KEY (origineid_id) REFERENCES myconnectors (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE controle DROP FOREIGN KEY FK_E39396E76F04A3B');
        $this->addSql('ALTER TABLE controle DROP FOREIGN KEY FK_E39396E6F354B52');
        $this->addSql('ALTER TABLE controle DROP FOREIGN KEY FK_E39396E1F90E30F');
        $this->addSql('ALTER TABLE controle DROP FOREIGN KEY FK_E39396E67DF6678');
        $this->addSql('DROP TABLE controle');
    }
}
