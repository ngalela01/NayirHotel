<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240531085419 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservations ADD chambre_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA2399B177F54 FOREIGN KEY (chambre_id) REFERENCES chambre (id)');
        $this->addSql('CREATE INDEX IDX_4DA2399B177F54 ON reservations (chambre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA2399B177F54');
        $this->addSql('DROP INDEX IDX_4DA2399B177F54 ON reservations');
        $this->addSql('ALTER TABLE reservations DROP chambre_id');
    }
}
