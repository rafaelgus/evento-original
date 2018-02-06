<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20170905202040 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE vouchers (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, value NUMERIC(10, 0) DEFAULT NULL, amount NUMERIC(10, 0) DEFAULT NULL, type VARCHAR(255) NOT NULL, status VARCHAR(30) NOT NULL, INDEX IDX_9315074812469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vouchers ADD CONSTRAINT FK_9315074812469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('DROP TABLE doctrine_migration_versions');
        $this->addSql('ALTER TABLE articles CHANGE isNew isNew TINYINT(1) DEFAULT NULL, CHANGE created created DATETIME DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE doctrine_migration_versions (version VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(version)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE vouchers');
        $this->addSql('ALTER TABLE articles CHANGE isNew isNew TINYINT(1) NOT NULL, CHANGE created created DATETIME NOT NULL');
    }
}
