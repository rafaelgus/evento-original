<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170711181303 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE prices (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, gramme INT NOT NULL, priceCurrency NUMERIC(10, 0) NOT NULL, price NUMERIC(10, 0) NOT NULL, INDEX IDX_E4CB6D597294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE prices ADD CONSTRAINT FK_E4CB6D597294869C FOREIGN KEY (article_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE articles ADD license_id INT DEFAULT NULL, ADD shortDescription VARCHAR(255) NOT NULL, CHANGE price price NUMERIC(10, 0) DEFAULT NULL');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168460F904B FOREIGN KEY (license_id) REFERENCES licenses (id)');
        $this->addSql('CREATE INDEX IDX_BFDD3168460F904B ON articles (license_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE prices');
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD3168460F904B');
        $this->addSql('DROP INDEX IDX_BFDD3168460F904B ON articles');
        $this->addSql('ALTER TABLE articles DROP license_id, DROP shortDescription, CHANGE price price NUMERIC(10, 0) NOT NULL');
    }
}
