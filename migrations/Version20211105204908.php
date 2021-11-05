<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211105204908 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE card_order (id INT AUTO_INCREMENT NOT NULL, ordered_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', quantity INT NOT NULL, received TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE card ADD card_order_id INT NOT NULL');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D334AEA3BB FOREIGN KEY (card_order_id) REFERENCES card_order (id)');
        $this->addSql('CREATE INDEX IDX_161498D334AEA3BB ON card (card_order_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D334AEA3BB');
        $this->addSql('DROP TABLE card_order');
        $this->addSql('DROP INDEX IDX_161498D334AEA3BB ON card');
        $this->addSql('ALTER TABLE card DROP card_order_id');
    }
}
