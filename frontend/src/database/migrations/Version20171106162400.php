<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20171106162400 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE addresses (id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, customer_id INT DEFAULT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, province VARCHAR(255) NOT NULL, postalCode VARCHAR(255) NOT NULL, INDEX IDX_6FCA7516F92F3E70 (country_id), INDEX IDX_6FCA75169395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE billings (id INT AUTO_INCREMENT NOT NULL, address_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, lastName VARCHAR(255) NOT NULL, company VARCHAR(255) NOT NULL, INDEX IDX_2DE1A7B1F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shippings (id INT AUTO_INCREMENT NOT NULL, address_id INT DEFAULT NULL, method VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_272037CDF5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE addresses ADD CONSTRAINT FK_6FCA7516F92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id)');
        $this->addSql('ALTER TABLE addresses ADD CONSTRAINT FK_6FCA75169395C3F3 FOREIGN KEY (customer_id) REFERENCES customers (id)');
        $this->addSql('ALTER TABLE billings ADD CONSTRAINT FK_2DE1A7B1F5B7AF75 FOREIGN KEY (address_id) REFERENCES addresses (id)');
        $this->addSql('ALTER TABLE shippings ADD CONSTRAINT FK_272037CDF5B7AF75 FOREIGN KEY (address_id) REFERENCES addresses (id)');
        $this->addSql('ALTER TABLE orders ADD billing_id INT DEFAULT NULL, ADD shipping_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE3B025C87 FOREIGN KEY (billing_id) REFERENCES billings (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE4887F3F8 FOREIGN KEY (shipping_id) REFERENCES shippings (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E52FFDEE3B025C87 ON orders (billing_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E52FFDEE4887F3F8 ON orders (shipping_id)');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D8D9F6D38');
        $this->addSql('ALTER TABLE payment CHANGE data data VARCHAR(5000) DEFAULT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D8D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE customers DROP billingAddress, DROP address');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE billings DROP FOREIGN KEY FK_2DE1A7B1F5B7AF75');
        $this->addSql('ALTER TABLE shippings DROP FOREIGN KEY FK_272037CDF5B7AF75');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE3B025C87');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE4887F3F8');
        $this->addSql('DROP TABLE addresses');
        $this->addSql('DROP TABLE billings');
        $this->addSql('DROP TABLE shippings');
        $this->addSql('ALTER TABLE customers ADD billingAddress VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD address VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('DROP INDEX UNIQ_E52FFDEE3B025C87 ON orders');
        $this->addSql('DROP INDEX UNIQ_E52FFDEE4887F3F8 ON orders');
        $this->addSql('ALTER TABLE orders DROP billing_id, DROP shipping_id');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D8D9F6D38');
        $this->addSql('ALTER TABLE payment CHANGE data data VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D8D9F6D38 FOREIGN KEY (order_id) REFERENCES payment (id)');
    }
}
