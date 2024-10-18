<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241018104413 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panier_article DROP FOREIGN KEY FK_F880CAE7F347EFB');
        $this->addSql('DROP TABLE panier_article');
        $this->addSql('ALTER TABLE commande CHANGE ref_commande ref_commande VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE panier_article (id INT AUTO_INCREMENT NOT NULL, produit_id INT NOT NULL, quantite INT NOT NULL, INDEX IDX_F880CAE7F347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE panier_article ADD CONSTRAINT FK_F880CAE7F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE commande CHANGE ref_commande ref_commande VARCHAR(255) NOT NULL');
    }
}
