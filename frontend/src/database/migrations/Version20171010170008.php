<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20171010170008 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE users ADD customer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E99395C3F3 FOREIGN KEY (customer_id) REFERENCES customers (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E99395C3F3 ON users (customer_id)');
        $this->addSql('ALTER TABLE payment ADD externalId VARCHAR(255) DEFAULT NULL, CHANGE requestData requestData VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE order_detail ADD article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F467294869C FOREIGN KEY (article_id) REFERENCES articles (id)');
        $this->addSql('CREATE INDEX IDX_ED896F467294869C ON order_detail (article_id)');
        $this->addSql('ALTER TABLE customers DROP FOREIGN KEY FK_62534E21A76ED395');
        $this->addSql('DROP INDEX UNIQ_62534E21A76ED395 ON customers');
        $this->addSql('ALTER TABLE customers DROP user_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customers ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE customers ADD CONSTRAINT FK_62534E21A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_62534E21A76ED395 ON customers (user_id)');
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F467294869C');
        $this->addSql('DROP INDEX IDX_ED896F467294869C ON order_detail');
        $this->addSql('ALTER TABLE order_detail DROP article_id');
        $this->addSql('ALTER TABLE payment DROP externalId, CHANGE requestData requestData VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E99395C3F3');
        $this->addSql('DROP INDEX UNIQ_1483A5E99395C3F3 ON users');
        $this->addSql('ALTER TABLE users DROP customer_id');
    }
}
