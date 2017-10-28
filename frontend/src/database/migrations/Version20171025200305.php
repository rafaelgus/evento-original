<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20171025200305 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Addresses (id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, customer_id INT DEFAULT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, province VARCHAR(255) NOT NULL, postalCode VARCHAR(255) NOT NULL, INDEX IDX_ED3BF7B5F92F3E70 (country_id), INDEX IDX_ED3BF7B59395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Addresses ADD CONSTRAINT FK_ED3BF7B5F92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id)');
        $this->addSql('ALTER TABLE Addresses ADD CONSTRAINT FK_ED3BF7B59395C3F3 FOREIGN KEY (customer_id) REFERENCES customers (id)');
        $this->addSql('ALTER TABLE customers DROP billingAddress, DROP address');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE Addresses');
        $this->addSql('ALTER TABLE customers ADD billingAddress VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD address VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
