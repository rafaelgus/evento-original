<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170621142411 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE categories ADD tree_root INT DEFAULT NULL, ADD parent_id INT DEFAULT NULL, ADD lft INT NOT NULL, ADD lvl INT NOT NULL, ADD rgt INT NOT NULL');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668A977936C FOREIGN KEY (tree_root) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668727ACA70 FOREIGN KEY (parent_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_3AF34668A977936C ON categories (tree_root)');
        $this->addSql('CREATE INDEX IDX_3AF34668727ACA70 ON categories (parent_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF34668A977936C');
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF34668727ACA70');
        $this->addSql('DROP INDEX IDX_3AF34668A977936C ON categories');
        $this->addSql('DROP INDEX IDX_3AF34668727ACA70 ON categories');
        $this->addSql('ALTER TABLE categories DROP tree_root, DROP parent_id, DROP lft, DROP lvl, DROP rgt');
    }
}
