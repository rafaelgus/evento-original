<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170724174622 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article_ingredients DROP FOREIGN KEY FK_D1E37B28933FE08C');
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD3168460F904B');
        $this->addSql('DROP TABLE article_ingredients');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE ingredients');
        $this->addSql('DROP TABLE licenses');
        $this->addSql('DROP TABLE migrations');
        $this->addSql('DROP TABLE password_resets');
        $this->addSql('DROP TABLE prices');
        $this->addSql('ALTER TABLE categories ADD slug VARCHAR(255) NOT NULL, ADD description LONGTEXT NOT NULL');
        $this->addSql('DROP INDEX IDX_BFDD3168460F904B ON articles');
        $this->addSql('ALTER TABLE articles ADD ingredients LONGTEXT NOT NULL, DROP license_id, DROP shortDescription, DROP priceType, DROP slug, CHANGE price price NUMERIC(10, 0) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE article_ingredients (article_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_D1E37B287294869C (article_id), INDEX IDX_D1E37B28933FE08C (ingredient_id), PRIMARY KEY(article_id, ingredient_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, path VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, INDEX IDX_C53D045F7294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredients (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE licenses (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE migrations (id INT UNSIGNED AUTO_INCREMENT NOT NULL, migration VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, batch INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE password_resets (email VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, token VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, created_at DATETIME DEFAULT NULL, INDEX password_resets_email_index (email)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prices (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, gramme INT NOT NULL, priceCurrency NUMERIC(10, 0) NOT NULL, price NUMERIC(10, 0) NOT NULL, INDEX IDX_E4CB6D597294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_ingredients ADD CONSTRAINT FK_D1E37B287294869C FOREIGN KEY (article_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE article_ingredients ADD CONSTRAINT FK_D1E37B28933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredients (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F7294869C FOREIGN KEY (article_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE prices ADD CONSTRAINT FK_E4CB6D597294869C FOREIGN KEY (article_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE articles ADD license_id INT DEFAULT NULL, ADD shortDescription VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD priceType VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD slug VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP ingredients, CHANGE price price NUMERIC(10, 0) DEFAULT NULL');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168460F904B FOREIGN KEY (license_id) REFERENCES licenses (id)');
        $this->addSql('CREATE INDEX IDX_BFDD3168460F904B ON articles (license_id)');
        $this->addSql('ALTER TABLE categories DROP slug, DROP description');
    }
}
