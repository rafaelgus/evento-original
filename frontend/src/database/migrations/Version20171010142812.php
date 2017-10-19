<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20171010142812 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, order_id INT DEFAULT NULL, user_id INT DEFAULT NULL, paidDate DATETIME DEFAULT NULL, originalAmount INT NOT NULL, originalCurrency VARCHAR(255) NOT NULL, paidAmount INT DEFAULT NULL, paidCurrency VARCHAR(255) DEFAULT NULL, status VARCHAR(255) NOT NULL, gateway VARCHAR(255) NOT NULL, requestData VARCHAR(255) NOT NULL, responseData VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, data VARCHAR(255) DEFAULT NULL, param JSON DEFAULT NULL, UNIQUE INDEX UNIQ_6D28840D8D9F6D38 (order_id), INDEX IDX_6D28840DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_detail (id INT AUTO_INCREMENT NOT NULL, order_id INT DEFAULT NULL, quantity INT NOT NULL, currency VARCHAR(255) NOT NULL, amount INT NOT NULL, discount TINYINT(1) NOT NULL, INDEX IDX_ED896F468D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, create_date DATETIME NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_E52FFDEEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D8D9F6D38 FOREIGN KEY (order_id) REFERENCES payment (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F468D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D8D9F6D38');
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F468D9F6D38');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE order_detail');
        $this->addSql('DROP TABLE orders');
    }
}
