<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211230172507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD ribbon VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE category_parent ADD ribbon VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE nav_large ADD ribbon VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD ribbon VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP ribbon');
        $this->addSql('ALTER TABLE category_parent DROP ribbon');
        $this->addSql('ALTER TABLE nav_large DROP ribbon');
        $this->addSql('ALTER TABLE product DROP ribbon');
    }
}
