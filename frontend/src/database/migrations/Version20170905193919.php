<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20170905193919 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE doctrine_migration_versions');
        $this->addSql('ALTER TABLE articles ADD isNew TINYINT(1) NOT NULL, ADD created DATETIME NOT NULL, ADD updated DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE colors ADD hexadecimalCode VARCHAR(255) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE doctrine_migration_versions (version VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(version)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE articles DROP isNew, DROP created, DROP updated');
        $this->addSql('ALTER TABLE colors DROP hexadecimalCode');
    }
}
