<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211211170805 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carrier ADD delevry_city VARCHAR(255) DEFAULT NULL, ADD delevry_country VARCHAR(255) DEFAULT NULL, ADD delevry_zip_code VARCHAR(255) DEFAULT NULL, ADD delevry_company VARCHAR(255) DEFAULT NULL, ADD delevry_phone VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carrier DROP delevry_city, DROP delevry_country, DROP delevry_zip_code, DROP delevry_company, DROP delevry_phone');
    }
}
