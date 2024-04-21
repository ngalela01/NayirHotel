<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240421173813 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chambre (id INT AUTO_INCREMENT NOT NULL, type_de_chambre_id INT NOT NULL, numero INT NOT NULL, capacite_adulte INT NOT NULL, capacite_enfant INT NOT NULL, statut TINYINT(1) DEFAULT NULL, prix DOUBLE PRECISION NOT NULL, INDEX IDX_C509E4FF92F964A7 (type_de_chambre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chambre ADD CONSTRAINT FK_C509E4FF92F964A7 FOREIGN KEY (type_de_chambre_id) REFERENCES type_de_chambre (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chambre DROP FOREIGN KEY FK_C509E4FF92F964A7');
        $this->addSql('DROP TABLE chambre');
    }
}
