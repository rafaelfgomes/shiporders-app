<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210111020716 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY fk_orders_addresses');
        $this->addSql('ALTER TABLE person_contact DROP FOREIGN KEY fk_contact');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY fk_items_order_item');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY fk_orders_order_item');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY fk_orders_persons');
        $this->addSql('ALTER TABLE person_contact DROP FOREIGN KEY fk_person');
        $this->addSql('CREATE TABLE person (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE addresses');
        $this->addSql('DROP TABLE contacts');
        $this->addSql('DROP TABLE items');
        $this->addSql('DROP TABLE order_item');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE person_contact');
        $this->addSql('DROP TABLE persons');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE addresses (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, city VARCHAR(80) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, country VARCHAR(60) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE contacts (id INT UNSIGNED AUTO_INCREMENT NOT NULL, code INT UNSIGNED NOT NULL, number VARCHAR(9) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE items (id INT UNSIGNED AUTO_INCREMENT NOT NULL, title VARCHAR(70) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, note VARCHAR(120) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, quantity INT UNSIGNED NOT NULL, price NUMERIC(8, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE order_item (order_id INT UNSIGNED NOT NULL, item_id INT UNSIGNED NOT NULL, INDEX fk_items_order_item (item_id), INDEX IDX_52EA1F098D9F6D38 (order_id), PRIMARY KEY(order_id, item_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE orders (id INT UNSIGNED AUTO_INCREMENT NOT NULL, person_id INT UNSIGNED NOT NULL, address_id INT UNSIGNED NOT NULL, INDEX fk_orders_persons (person_id), INDEX fk_orders_addresses (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE person_contact (person_id INT UNSIGNED NOT NULL, contact_id INT UNSIGNED NOT NULL, INDEX fk_contact (contact_id), INDEX IDX_6EFC55B1217BBB47 (person_id), PRIMARY KEY(person_id, contact_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE persons (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT fk_items_order_item FOREIGN KEY (item_id) REFERENCES items (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT fk_orders_order_item FOREIGN KEY (order_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT fk_orders_addresses FOREIGN KEY (address_id) REFERENCES addresses (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT fk_orders_persons FOREIGN KEY (person_id) REFERENCES persons (id)');
        $this->addSql('ALTER TABLE person_contact ADD CONSTRAINT fk_contact FOREIGN KEY (contact_id) REFERENCES contacts (id)');
        $this->addSql('ALTER TABLE person_contact ADD CONSTRAINT fk_person FOREIGN KEY (person_id) REFERENCES persons (id)');
        $this->addSql('DROP TABLE person');
    }
}
