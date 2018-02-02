<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20180116235126 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE payments (id INT AUTO_INCREMENT NOT NULL, order_id INT DEFAULT NULL, user_id INT DEFAULT NULL, paidDate DATETIME DEFAULT NULL, originalAmount INT NOT NULL, originalCurrency VARCHAR(255) NOT NULL, paidAmount INT DEFAULT NULL, paidCurrency VARCHAR(255) DEFAULT NULL, status VARCHAR(255) NOT NULL, gateway VARCHAR(255) NOT NULL, requestData VARCHAR(255) DEFAULT NULL, responseData VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, data TEXT DEFAULT NULL, param JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', externalId VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_65D29B328D9F6D38 (order_id), INDEX IDX_65D29B32A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE payments ADD CONSTRAINT FK_65D29B328D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE payments ADD CONSTRAINT FK_65D29B32A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('DROP TABLE payment');
        $this->addSql('ALTER TABLE vouchers CHANGE amount amount INT DEFAULT NULL');
        $this->addSql('ALTER TABLE billings CHANGE company company VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, order_id INT DEFAULT NULL, user_id INT DEFAULT NULL, paidDate DATETIME DEFAULT NULL, originalAmount INT NOT NULL, originalCurrency VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, paidAmount INT DEFAULT NULL, paidCurrency VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, status VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, gateway VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, requestData VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, responseData VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, description VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, data VARCHAR(5000) DEFAULT NULL COLLATE utf8_unicode_ci, param JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', externalId VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX UNIQ_6D28840D8D9F6D38 (order_id), INDEX IDX_6D28840DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D8D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('DROP TABLE payments');
        $this->addSql('ALTER TABLE billings CHANGE company company VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE vouchers CHANGE amount amount NUMERIC(10, 0) DEFAULT NULL');
    }
}
