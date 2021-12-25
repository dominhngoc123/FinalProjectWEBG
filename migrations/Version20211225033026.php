<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211225033026 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, author_full_name VARCHAR(50) NOT NULL, author_stage_name VARCHAR(50) DEFAULT NULL, create_at DATETIME NOT NULL, create_by VARCHAR(50) NOT NULL, update_at DATETIME DEFAULT NULL, update_by VARCHAR(50) DEFAULT NULL, author_description VARCHAR(255) DEFAULT NULL, author_image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE author_book (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, book_id INT DEFAULT NULL, INDEX IDX_2F0A2BEEF675F31B (author_id), INDEX IDX_2F0A2BEE16A2B381 (book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, book_title VARCHAR(255) NOT NULL, published_at DATETIME DEFAULT NULL, book_summary VARCHAR(255) DEFAULT NULL, book_price DOUBLE PRECISION NOT NULL, book_quantity SMALLINT NOT NULL, create_at DATETIME NOT NULL, create_by VARCHAR(50) NOT NULL, update_at DATETIME DEFAULT NULL, update_by VARCHAR(50) DEFAULT NULL, book_image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book_category (id INT AUTO_INCREMENT NOT NULL, book_id INT DEFAULT NULL, category_id INT DEFAULT NULL, INDEX IDX_1FB30F9816A2B381 (book_id), INDEX IDX_1FB30F9812469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book_type (id INT AUTO_INCREMENT NOT NULL, book_id INT DEFAULT NULL, type_id INT DEFAULT NULL, INDEX IDX_95431C2116A2B381 (book_id), INDEX IDX_95431C21C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, category_name VARCHAR(50) NOT NULL, category_description VARCHAR(255) DEFAULT NULL, create_at DATETIME NOT NULL, create_by VARCHAR(50) NOT NULL, update_at DATETIME DEFAULT NULL, update_by VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, create_at DATETIME NOT NULL, create_by VARCHAR(50) NOT NULL, update_at DATETIME DEFAULT NULL, update_by VARCHAR(50) DEFAULT NULL, INDEX IDX_F5299398A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_detail (id INT AUTO_INCREMENT NOT NULL, _order_id INT DEFAULT NULL, book_id INT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, quantity SMALLINT NOT NULL, INDEX IDX_ED896F46A35F2858 (_order_id), INDEX IDX_ED896F4616A2B381 (book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, type_name VARCHAR(50) NOT NULL, type_description VARCHAR(255) DEFAULT NULL, create_at DATETIME NOT NULL, create_by VARCHAR(50) NOT NULL, update_at DATETIME DEFAULT NULL, update_by VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, user_email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, username VARCHAR(50) NOT NULL, user_full_name VARCHAR(50) DEFAULT NULL, user_address VARCHAR(255) DEFAULT NULL, user_phone VARCHAR(10) DEFAULT NULL, user_dob DATE DEFAULT NULL, create_at DATETIME NOT NULL, create_by VARCHAR(50) NOT NULL, update_at DATETIME DEFAULT NULL, update_by VARCHAR(50) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649550872C (user_email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE author_book ADD CONSTRAINT FK_2F0A2BEEF675F31B FOREIGN KEY (author_id) REFERENCES author (id)');
        $this->addSql('ALTER TABLE author_book ADD CONSTRAINT FK_2F0A2BEE16A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE book_category ADD CONSTRAINT FK_1FB30F9816A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE book_category ADD CONSTRAINT FK_1FB30F9812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE book_type ADD CONSTRAINT FK_95431C2116A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE book_type ADD CONSTRAINT FK_95431C21C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F46A35F2858 FOREIGN KEY (_order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F4616A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE author_book DROP FOREIGN KEY FK_2F0A2BEEF675F31B');
        $this->addSql('ALTER TABLE author_book DROP FOREIGN KEY FK_2F0A2BEE16A2B381');
        $this->addSql('ALTER TABLE book_category DROP FOREIGN KEY FK_1FB30F9816A2B381');
        $this->addSql('ALTER TABLE book_type DROP FOREIGN KEY FK_95431C2116A2B381');
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F4616A2B381');
        $this->addSql('ALTER TABLE book_category DROP FOREIGN KEY FK_1FB30F9812469DE2');
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F46A35F2858');
        $this->addSql('ALTER TABLE book_type DROP FOREIGN KEY FK_95431C21C54C8C93');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE author_book');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE book_category');
        $this->addSql('DROP TABLE book_type');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_detail');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE user');
    }
}
