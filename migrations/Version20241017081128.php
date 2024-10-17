<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241017081128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout d\'une contrainte NOT NULL sur la colonne date_inscription';
    }

    public function up(Schema $schema): void
    {
        // Cette requête ajoute la contrainte NOT NULL à la colonne date_inscription
        $this->addSql('ALTER TABLE user CHANGE date_inscription date_inscription DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // Cette requête revient à l'état précédent (date_inscription peut être NULL)
        $this->addSql('ALTER TABLE user CHANGE date_inscription date_inscription DATETIME DEFAULT NULL');
    }
}
