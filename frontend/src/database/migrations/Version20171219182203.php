<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20171219182203 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE billings DROP FOREIGN KEY FK_2DE1A7B1F5B7AF75');
        $this->addSql('ALTER TABLE shippings DROP FOREIGN KEY FK_272037CDF5B7AF75');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE3B025C87');
        $this->addSql('ALTER TABLE addresses DROP FOREIGN KEY FK_6FCA75169395C3F3');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E99395C3F3');
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F468D9F6D38');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D8D9F6D38');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE4887F3F8');
        $this->addSql('DROP TABLE addresses');
        $this->addSql('DROP TABLE billings');
        $this->addSql('DROP TABLE customers');
        $this->addSql('DROP TABLE order_detail');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE shippings');
        $this->addSql('DROP INDEX UNIQ_1483A5E99395C3F3 ON users');
        $this->addSql('ALTER TABLE users DROP customer_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE addresses (id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, customer_id INT DEFAULT NULL, address VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, city VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, province VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, postalCode VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, INDEX IDX_6FCA7516F92F3E70 (country_id), INDEX IDX_6FCA75169395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE billings (id INT AUTO_INCREMENT NOT NULL, address_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, lastName VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, company VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, INDEX IDX_2DE1A7B1F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customers (id INT AUTO_INCREMENT NOT NULL, firstName VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, lastName VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, websiteName VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, websiteUrl VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, affiliateCode VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, phoneNumber VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_detail (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, order_id INT DEFAULT NULL, quantity INT NOT NULL, currency VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, amount INT NOT NULL, discount TINYINT(1) NOT NULL, INDEX IDX_ED896F467294869C (article_id), INDEX IDX_ED896F468D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, billing_id INT DEFAULT NULL, shipping_id INT DEFAULT NULL, create_date DATETIME NOT NULL, status VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX UNIQ_E52FFDEE3B025C87 (billing_id), UNIQUE INDEX UNIQ_E52FFDEE4887F3F8 (shipping_id), INDEX IDX_E52FFDEEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, order_id INT DEFAULT NULL, user_id INT DEFAULT NULL, paidDate DATETIME DEFAULT NULL, originalAmount INT NOT NULL, originalCurrency VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, paidAmount INT DEFAULT NULL, paidCurrency VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, status VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, gateway VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, requestData VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, responseData VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, description VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, data VARCHAR(5000) DEFAULT NULL COLLATE utf8_unicode_ci, param TEXT DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:json)\', externalId VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX UNIQ_6D28840D8D9F6D38 (order_id), INDEX IDX_6D28840DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shippings (id INT AUTO_INCREMENT NOT NULL, address_id INT DEFAULT NULL, method VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX UNIQ_272037CDF5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE addresses ADD CONSTRAINT FK_6FCA75169395C3F3 FOREIGN KEY (customer_id) REFERENCES customers (id)');
        $this->addSql('ALTER TABLE addresses ADD CONSTRAINT FK_6FCA7516F92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id)');
        $this->addSql('ALTER TABLE billings ADD CONSTRAINT FK_2DE1A7B1F5B7AF75 FOREIGN KEY (address_id) REFERENCES addresses (id)');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F467294869C FOREIGN KEY (article_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F468D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE3B025C87 FOREIGN KEY (billing_id) REFERENCES billings (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE4887F3F8 FOREIGN KEY (shipping_id) REFERENCES shippings (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D8D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE shippings ADD CONSTRAINT FK_272037CDF5B7AF75 FOREIGN KEY (address_id) REFERENCES addresses (id)');
        $this->addSql('ALTER TABLE users ADD customer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E99395C3F3 FOREIGN KEY (customer_id) REFERENCES customers (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E99395C3F3 ON users (customer_id)');
    }
}
