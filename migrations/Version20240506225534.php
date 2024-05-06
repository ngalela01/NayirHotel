<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240506225534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chambre_service (chambre_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_428BC92E9B177F54 (chambre_id), INDEX IDX_428BC92EED5CA9E6 (service_id), PRIMARY KEY(chambre_id, service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chambre_service ADD CONSTRAINT FK_428BC92E9B177F54 FOREIGN KEY (chambre_id) REFERENCES chambre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE chambre_service ADD CONSTRAINT FK_428BC92EED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD29B177F54');
        $this->addSql('DROP INDEX IDX_E19D9AD29B177F54 ON service');
        $this->addSql('ALTER TABLE service DROP chambre_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chambre_service DROP FOREIGN KEY FK_428BC92E9B177F54');
        $this->addSql('ALTER TABLE chambre_service DROP FOREIGN KEY FK_428BC92EED5CA9E6');
        $this->addSql('DROP TABLE chambre_service');
        $this->addSql('ALTER TABLE service ADD chambre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD29B177F54 FOREIGN KEY (chambre_id) REFERENCES chambre (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_E19D9AD29B177F54 ON service (chambre_id)');
    }
}
