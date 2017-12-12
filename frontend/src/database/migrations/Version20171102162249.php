<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20171102162249 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE addresses RENAME INDEX idx_ed3bf7b5f92f3e70 TO IDX_6FCA7516F92F3E70');
        $this->addSql('ALTER TABLE addresses RENAME INDEX idx_ed3bf7b59395c3f3 TO IDX_6FCA75169395C3F3');
        $this->addSql('ALTER TABLE orders ADD billing_id INT DEFAULT NULL, ADD shipping_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE3B025C87 FOREIGN KEY (billing_id) REFERENCES billings (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE4887F3F8 FOREIGN KEY (shipping_id) REFERENCES shippings (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E52FFDEE3B025C87 ON orders (billing_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E52FFDEE4887F3F8 ON orders (shipping_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE addresses RENAME INDEX idx_6fca7516f92f3e70 TO IDX_ED3BF7B5F92F3E70');
        $this->addSql('ALTER TABLE addresses RENAME INDEX idx_6fca75169395c3f3 TO IDX_ED3BF7B59395C3F3');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE3B025C87');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE4887F3F8');
        $this->addSql('DROP INDEX UNIQ_E52FFDEE3B025C87 ON orders');
        $this->addSql('DROP INDEX UNIQ_E52FFDEE4887F3F8 ON orders');
        $this->addSql('ALTER TABLE orders DROP billing_id, DROP shipping_id');
    }
}
