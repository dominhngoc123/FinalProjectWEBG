<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211229205334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F468D9F6D38');
        $this->addSql('ALTER TABLE order_detail CHANGE order_id order_id INT NOT NULL');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F468D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F468D9F6D38');
        $this->addSql('ALTER TABLE order_detail CHANGE order_id order_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F468D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
    }
}
