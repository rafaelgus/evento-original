<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20180102144731 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE article_translations (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_15FBAD16232D562B (object_id), UNIQUE INDEX lookup_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_ingredients (article_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_D1E37B287294869C (article_id), INDEX IDX_D1E37B28933FE08C (ingredient_id), PRIMARY KEY(article_id, ingredient_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles_tags (article_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_354053617294869C (article_id), INDEX IDX_35405361BAD26311 (tag_id), PRIMARY KEY(article_id, tag_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles_colors (article_id INT NOT NULL, color_id INT NOT NULL, INDEX IDX_788617B27294869C (article_id), INDEX IDX_788617B27ADA1FB5 (color_id), PRIMARY KEY(article_id, color_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles_flavours (article_id INT NOT NULL, flavour_id INT NOT NULL, INDEX IDX_CE6419527294869C (article_id), INDEX IDX_CE641952867B8DC0 (flavour_id), PRIMARY KEY(article_id, flavour_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles_allergens (article_id INT NOT NULL, allergen_id INT NOT NULL, INDEX IDX_9A34F2387294869C (article_id), INDEX IDX_9A34F2386E775A4A (allergen_id), PRIMARY KEY(article_id, allergen_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles_healthy (article_id INT NOT NULL, healthy_id INT NOT NULL, INDEX IDX_3ACED9497294869C (article_id), INDEX IDX_3ACED949D1DFEEC2 (healthy_id), PRIMARY KEY(article_id, healthy_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_translations ADD CONSTRAINT FK_15FBAD16232D562B FOREIGN KEY (object_id) REFERENCES articles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_ingredients ADD CONSTRAINT FK_D1E37B287294869C FOREIGN KEY (article_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE article_ingredients ADD CONSTRAINT FK_D1E37B28933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredients (id)');
        $this->addSql('ALTER TABLE articles_tags ADD CONSTRAINT FK_354053617294869C FOREIGN KEY (article_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE articles_tags ADD CONSTRAINT FK_35405361BAD26311 FOREIGN KEY (tag_id) REFERENCES tags (id)');
        $this->addSql('ALTER TABLE articles_colors ADD CONSTRAINT FK_788617B27294869C FOREIGN KEY (article_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE articles_colors ADD CONSTRAINT FK_788617B27ADA1FB5 FOREIGN KEY (color_id) REFERENCES colors (id)');
        $this->addSql('ALTER TABLE articles_flavours ADD CONSTRAINT FK_CE6419527294869C FOREIGN KEY (article_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE articles_flavours ADD CONSTRAINT FK_CE641952867B8DC0 FOREIGN KEY (flavour_id) REFERENCES flavours (id)');
        $this->addSql('ALTER TABLE articles_allergens ADD CONSTRAINT FK_9A34F2387294869C FOREIGN KEY (article_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE articles_allergens ADD CONSTRAINT FK_9A34F2386E775A4A FOREIGN KEY (allergen_id) REFERENCES allergens (id)');
        $this->addSql('ALTER TABLE articles_healthy ADD CONSTRAINT FK_3ACED9497294869C FOREIGN KEY (article_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE articles_healthy ADD CONSTRAINT FK_3ACED949D1DFEEC2 FOREIGN KEY (healthy_id) REFERENCES healthy (id)');
        $this->addSql('ALTER TABLE colors CHANGE hexadecimalCode hexadecimalCode VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE articles CHANGE slug slug VARCHAR(255) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE article_translations');
        $this->addSql('DROP TABLE article_ingredients');
        $this->addSql('DROP TABLE articles_tags');
        $this->addSql('DROP TABLE articles_colors');
        $this->addSql('DROP TABLE articles_flavours');
        $this->addSql('DROP TABLE articles_allergens');
        $this->addSql('DROP TABLE articles_healthy');
        $this->addSql('ALTER TABLE articles CHANGE slug slug VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE colors CHANGE hexadecimalCode hexadecimalCode VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
