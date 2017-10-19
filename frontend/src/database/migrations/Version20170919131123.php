<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20170919131123 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE brands (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE allergens (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE healthy (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_items (id INT AUTO_INCREMENT NOT NULL, menu_id INT DEFAULT NULL, parent_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, position INT NOT NULL, url VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, level INT NOT NULL, visible TINYINT(1) NOT NULL, INDEX IDX_70B2CA2ACCD7E912 (menu_id), INDEX IDX_70B2CA2A727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_translations (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_15FBAD16232D562B (object_id), UNIQUE INDEX lookup_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE healthy_translations (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_57292F19232D562B (object_id), UNIQUE INDEX lookup_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menus (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, remember_token VARCHAR(100) DEFAULT NULL, client_id VARCHAR(255) DEFAULT NULL, client_secret VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_roles (user_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_51498A8EA76ED395 (user_id), INDEX IDX_51498A8ED60322AC (role_id), PRIMARY KEY(user_id, role_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, tree_root INT DEFAULT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, lft INT NOT NULL, lvl INT NOT NULL, rgt INT NOT NULL, INDEX IDX_3AF34668A977936C (tree_root), INDEX IDX_3AF34668727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE allergen_translations (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_18E6340D232D562B (object_id), UNIQUE INDEX lookup_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, type VARCHAR(255) DEFAULT NULL, INDEX IDX_C53D045F7294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE flavours (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredients (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_item_translations (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_24D3F735232D562B (object_id), UNIQUE INDEX lookup_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles (id INT AUTO_INCREMENT NOT NULL, tax_id INT DEFAULT NULL, license_id INT DEFAULT NULL, brand_id INT DEFAULT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, shortDescription VARCHAR(255) NOT NULL, barCode VARCHAR(255) NOT NULL, internalCode VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, price NUMERIC(10, 0) DEFAULT NULL, priceType VARCHAR(255) NOT NULL, priceCurrency VARCHAR(255) NOT NULL, costPrice NUMERIC(10, 0) NOT NULL, publishedOn DATETIME DEFAULT NULL, slug VARCHAR(255) NOT NULL, isNew TINYINT(1) DEFAULT NULL, created DATETIME DEFAULT NULL, updated DATETIME DEFAULT NULL, INDEX IDX_BFDD3168B2A824D8 (tax_id), INDEX IDX_BFDD3168460F904B (license_id), INDEX IDX_BFDD316844F5D008 (brand_id), INDEX IDX_BFDD316812469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_ingredients (article_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_D1E37B287294869C (article_id), INDEX IDX_D1E37B28933FE08C (ingredient_id), PRIMARY KEY(article_id, ingredient_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles_tags (article_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_354053617294869C (article_id), INDEX IDX_35405361BAD26311 (tag_id), PRIMARY KEY(article_id, tag_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles_colors (article_id INT NOT NULL, color_id INT NOT NULL, INDEX IDX_788617B27294869C (article_id), INDEX IDX_788617B27ADA1FB5 (color_id), PRIMARY KEY(article_id, color_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles_flavours (article_id INT NOT NULL, flavour_id INT NOT NULL, INDEX IDX_CE6419527294869C (article_id), INDEX IDX_CE641952867B8DC0 (flavour_id), PRIMARY KEY(article_id, flavour_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles_allergens (article_id INT NOT NULL, allergen_id INT NOT NULL, INDEX IDX_9A34F2387294869C (article_id), INDEX IDX_9A34F2386E775A4A (allergen_id), PRIMARY KEY(article_id, allergen_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles_healthy (article_id INT NOT NULL, healthy_id INT NOT NULL, INDEX IDX_3ACED9497294869C (article_id), INDEX IDX_3ACED949D1DFEEC2 (healthy_id), PRIMARY KEY(article_id, healthy_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taxes (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value NUMERIC(5, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE colors (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, hexadecimalCode VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE color_translations (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_CF7DEFD1232D562B (object_id), UNIQUE INDEX lookup_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, order_id INT DEFAULT NULL, user_id INT DEFAULT NULL, date DATETIME NOT NULL, originalAmount INT NOT NULL, originalCurrency VARCHAR(255) NOT NULL, paidAmount INT NOT NULL, paidCurrency VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, gateway VARCHAR(255) NOT NULL, requestData VARCHAR(255) NOT NULL, responseData VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, data VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_6D28840D8D9F6D38 (order_id), INDEX IDX_6D28840DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE currency_conversions (id INT AUTO_INCREMENT NOT NULL, fromCurrency VARCHAR(255) NOT NULL, toCurrency VARCHAR(255) NOT NULL, rate NUMERIC(10, 0) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_detail (id INT AUTO_INCREMENT NOT NULL, order_id INT DEFAULT NULL, quantity INT NOT NULL, currency VARCHAR(255) NOT NULL, amount INT NOT NULL, discount TINYINT(1) NOT NULL, INDEX IDX_ED896F468D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_translations (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_66A1F185232D562B (object_id), UNIQUE INDEX lookup_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, date DATETIME NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_F5299398A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE flavour_translations (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_FE477C0A232D562B (object_id), UNIQUE INDEX lookup_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vouchers (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, value NUMERIC(10, 0) DEFAULT NULL, amount NUMERIC(10, 0) DEFAULT NULL, type VARCHAR(255) NOT NULL, status VARCHAR(30) NOT NULL, INDEX IDX_9315074812469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE countries (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, currency VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE licenses (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prices (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, gramme INT NOT NULL, priceCurrency NUMERIC(10, 0) NOT NULL, price NUMERIC(10, 0) NOT NULL, INDEX IDX_E4CB6D597294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tags (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_translations (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_1C60F915232D562B (object_id), UNIQUE INDEX lookup_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ext_translations (id INT AUTO_INCREMENT NOT NULL, locale VARCHAR(8) NOT NULL, object_class VARCHAR(255) NOT NULL, field VARCHAR(32) NOT NULL, foreign_key VARCHAR(64) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX translations_lookup_idx (locale, object_class, foreign_key), UNIQUE INDEX lookup_unique_idx (locale, object_class, field, foreign_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ext_log_entries (id INT AUTO_INCREMENT NOT NULL, action VARCHAR(8) NOT NULL, logged_at DATETIME NOT NULL, object_id VARCHAR(64) DEFAULT NULL, object_class VARCHAR(255) NOT NULL, version INT NOT NULL, data LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', username VARCHAR(255) DEFAULT NULL, INDEX log_class_lookup_idx (object_class), INDEX log_date_lookup_idx (logged_at), INDEX log_user_lookup_idx (username), INDEX log_version_lookup_idx (object_id, object_class, version), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE menu_items ADD CONSTRAINT FK_70B2CA2ACCD7E912 FOREIGN KEY (menu_id) REFERENCES menus (id)');
        $this->addSql('ALTER TABLE menu_items ADD CONSTRAINT FK_70B2CA2A727ACA70 FOREIGN KEY (parent_id) REFERENCES menu_items (id)');
        $this->addSql('ALTER TABLE article_translations ADD CONSTRAINT FK_15FBAD16232D562B FOREIGN KEY (object_id) REFERENCES articles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE healthy_translations ADD CONSTRAINT FK_57292F19232D562B FOREIGN KEY (object_id) REFERENCES healthy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_roles ADD CONSTRAINT FK_51498A8EA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users_roles ADD CONSTRAINT FK_51498A8ED60322AC FOREIGN KEY (role_id) REFERENCES roles (id)');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668A977936C FOREIGN KEY (tree_root) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668727ACA70 FOREIGN KEY (parent_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE allergen_translations ADD CONSTRAINT FK_18E6340D232D562B FOREIGN KEY (object_id) REFERENCES allergens (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F7294869C FOREIGN KEY (article_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE menu_item_translations ADD CONSTRAINT FK_24D3F735232D562B FOREIGN KEY (object_id) REFERENCES menu_items (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168B2A824D8 FOREIGN KEY (tax_id) REFERENCES taxes (id)');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168460F904B FOREIGN KEY (license_id) REFERENCES licenses (id)');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD316844F5D008 FOREIGN KEY (brand_id) REFERENCES brands (id)');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD316812469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
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
        $this->addSql('ALTER TABLE color_translations ADD CONSTRAINT FK_CF7DEFD1232D562B FOREIGN KEY (object_id) REFERENCES colors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D8D9F6D38 FOREIGN KEY (order_id) REFERENCES payment (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F468D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE tag_translations ADD CONSTRAINT FK_66A1F185232D562B FOREIGN KEY (object_id) REFERENCES tags (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE flavour_translations ADD CONSTRAINT FK_FE477C0A232D562B FOREIGN KEY (object_id) REFERENCES flavours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vouchers ADD CONSTRAINT FK_9315074812469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE prices ADD CONSTRAINT FK_E4CB6D597294869C FOREIGN KEY (article_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE category_translations ADD CONSTRAINT FK_1C60F915232D562B FOREIGN KEY (object_id) REFERENCES categories (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD316844F5D008');
        $this->addSql('ALTER TABLE allergen_translations DROP FOREIGN KEY FK_18E6340D232D562B');
        $this->addSql('ALTER TABLE articles_allergens DROP FOREIGN KEY FK_9A34F2386E775A4A');
        $this->addSql('ALTER TABLE healthy_translations DROP FOREIGN KEY FK_57292F19232D562B');
        $this->addSql('ALTER TABLE articles_healthy DROP FOREIGN KEY FK_3ACED949D1DFEEC2');
        $this->addSql('ALTER TABLE menu_items DROP FOREIGN KEY FK_70B2CA2A727ACA70');
        $this->addSql('ALTER TABLE menu_item_translations DROP FOREIGN KEY FK_24D3F735232D562B');
        $this->addSql('ALTER TABLE menu_items DROP FOREIGN KEY FK_70B2CA2ACCD7E912');
        $this->addSql('ALTER TABLE users_roles DROP FOREIGN KEY FK_51498A8ED60322AC');
        $this->addSql('ALTER TABLE users_roles DROP FOREIGN KEY FK_51498A8EA76ED395');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DA76ED395');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF34668A977936C');
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF34668727ACA70');
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD316812469DE2');
        $this->addSql('ALTER TABLE vouchers DROP FOREIGN KEY FK_9315074812469DE2');
        $this->addSql('ALTER TABLE category_translations DROP FOREIGN KEY FK_1C60F915232D562B');
        $this->addSql('ALTER TABLE articles_flavours DROP FOREIGN KEY FK_CE641952867B8DC0');
        $this->addSql('ALTER TABLE flavour_translations DROP FOREIGN KEY FK_FE477C0A232D562B');
        $this->addSql('ALTER TABLE article_ingredients DROP FOREIGN KEY FK_D1E37B28933FE08C');
        $this->addSql('ALTER TABLE article_translations DROP FOREIGN KEY FK_15FBAD16232D562B');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F7294869C');
        $this->addSql('ALTER TABLE article_ingredients DROP FOREIGN KEY FK_D1E37B287294869C');
        $this->addSql('ALTER TABLE articles_tags DROP FOREIGN KEY FK_354053617294869C');
        $this->addSql('ALTER TABLE articles_colors DROP FOREIGN KEY FK_788617B27294869C');
        $this->addSql('ALTER TABLE articles_flavours DROP FOREIGN KEY FK_CE6419527294869C');
        $this->addSql('ALTER TABLE articles_allergens DROP FOREIGN KEY FK_9A34F2387294869C');
        $this->addSql('ALTER TABLE articles_healthy DROP FOREIGN KEY FK_3ACED9497294869C');
        $this->addSql('ALTER TABLE prices DROP FOREIGN KEY FK_E4CB6D597294869C');
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD3168B2A824D8');
        $this->addSql('ALTER TABLE articles_colors DROP FOREIGN KEY FK_788617B27ADA1FB5');
        $this->addSql('ALTER TABLE color_translations DROP FOREIGN KEY FK_CF7DEFD1232D562B');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D8D9F6D38');
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F468D9F6D38');
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD3168460F904B');
        $this->addSql('ALTER TABLE articles_tags DROP FOREIGN KEY FK_35405361BAD26311');
        $this->addSql('ALTER TABLE tag_translations DROP FOREIGN KEY FK_66A1F185232D562B');
        $this->addSql('DROP TABLE brands');
        $this->addSql('DROP TABLE allergens');
        $this->addSql('DROP TABLE healthy');
        $this->addSql('DROP TABLE menu_items');
        $this->addSql('DROP TABLE article_translations');
        $this->addSql('DROP TABLE healthy_translations');
        $this->addSql('DROP TABLE menus');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE users_roles');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE allergen_translations');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE flavours');
        $this->addSql('DROP TABLE ingredients');
        $this->addSql('DROP TABLE menu_item_translations');
        $this->addSql('DROP TABLE articles');
        $this->addSql('DROP TABLE article_ingredients');
        $this->addSql('DROP TABLE articles_tags');
        $this->addSql('DROP TABLE articles_colors');
        $this->addSql('DROP TABLE articles_flavours');
        $this->addSql('DROP TABLE articles_allergens');
        $this->addSql('DROP TABLE articles_healthy');
        $this->addSql('DROP TABLE taxes');
        $this->addSql('DROP TABLE colors');
        $this->addSql('DROP TABLE color_translations');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE currency_conversions');
        $this->addSql('DROP TABLE order_detail');
        $this->addSql('DROP TABLE tag_translations');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE flavour_translations');
        $this->addSql('DROP TABLE vouchers');
        $this->addSql('DROP TABLE countries');
        $this->addSql('DROP TABLE licenses');
        $this->addSql('DROP TABLE prices');
        $this->addSql('DROP TABLE tags');
        $this->addSql('DROP TABLE category_translations');
        $this->addSql('DROP TABLE ext_translations');
        $this->addSql('DROP TABLE ext_log_entries');
    }
}
