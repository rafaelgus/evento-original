<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20170927145801 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE payment CHANGE paidAmount paidAmount INT NOT NULL, CHANGE paidCurrency paidCurrency VARCHAR(255) NOT NULL, CHANGE requestData requestData VARCHAR(255) NOT NULL, CHANGE responseData responseData VARCHAR(255) NOT NULL, CHANGE description description VARCHAR(255) NOT NULL, CHANGE data data VARCHAR(255) NOT NULL, CHANGE param param JSON NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE payment CHANGE paidAmount paidAmount INT DEFAULT NULL, CHANGE paidCurrency paidCurrency VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE requestData requestData VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE responseData responseData VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE description description VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE data data VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE param param JSON DEFAULT NULL');
    }
}
