<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20171031194535 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE billings (id INT AUTO_INCREMENT NOT NULL, address_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, lastName VARCHAR(255) NOT NULL, company VARCHAR(255) NOT NULL, INDEX IDX_2DE1A7B1F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shippings (id INT AUTO_INCREMENT NOT NULL, address_id INT DEFAULT NULL, method VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_272037CDF5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE billings ADD CONSTRAINT FK_2DE1A7B1F5B7AF75 FOREIGN KEY (address_id) REFERENCES Addresses (id)');
        $this->addSql('ALTER TABLE shippings ADD CONSTRAINT FK_272037CDF5B7AF75 FOREIGN KEY (address_id) REFERENCES Addresses (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE billings');
        $this->addSql('DROP TABLE shippings');
    }
}
