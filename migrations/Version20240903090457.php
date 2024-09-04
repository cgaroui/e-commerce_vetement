<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240903090457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, adresse_client_id INT DEFAULT NULL, adresse VARCHAR(255) NOT NULL, cp VARCHAR(50) NOT NULL, ville VARCHAR(255) NOT NULL, INDEX IDX_C35F0816B4ECFFF7 (adresse_client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE adresse_client (id INT AUTO_INCREMENT NOT NULL, adresse_id INT DEFAULT NULL, client_id INT DEFAULT NULL, INDEX IDX_891D1BD4DE7DC5C (adresse_id), INDEX IDX_891D1BD19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(50) DEFAULT NULL, date_naissance DATETIME DEFAULT NULL, mdp VARCHAR(255) NOT NULL, date_inscription DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, livraison_id INT DEFAULT NULL, prix_total DOUBLE PRECISION NOT NULL, nom_client VARCHAR(50) NOT NULL, prenom_client VARCHAR(50) NOT NULL, date_commande DATETIME NOT NULL, INDEX IDX_6EEAA67D19EB6921 (client_id), INDEX IDX_6EEAA67D8E54FB25 (livraison_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, produit_id INT DEFAULT NULL, texte LONGTEXT NOT NULL, date DATETIME NOT NULL, photo_produit VARCHAR(255) DEFAULT NULL, note_produit INT NOT NULL, INDEX IDX_67F068BCF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detail_commande (id INT AUTO_INCREMENT NOT NULL, commande_id INT DEFAULT NULL, produit_id INT DEFAULT NULL, INDEX IDX_98344FA682EA2E54 (commande_id), INDEX IDX_98344FA6F347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detail_produit (id INT AUTO_INCREMENT NOT NULL, taille_id INT DEFAULT NULL, genre_id INT DEFAULT NULL, produit_id INT DEFAULT NULL, stock_produit INT NOT NULL, INDEX IDX_4E6A6CF2FF25611A (taille_id), INDEX IDX_4E6A6CF24296D31F (genre_id), INDEX IDX_4E6A6CF2F347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favoris (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, produit_id INT DEFAULT NULL, INDEX IDX_8933C43219EB6921 (client_id), INDEX IDX_8933C432F347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, nom_genre VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE likes (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, comentaire_id INT DEFAULT NULL, INDEX IDX_49CA4E7D19EB6921 (client_id), INDEX IDX_49CA4E7DE26E6343 (comentaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livraison (id INT AUTO_INCREMENT NOT NULL, adresse_id INT DEFAULT NULL, nom_destinataire VARCHAR(50) NOT NULL, choix_livraison VARCHAR(255) NOT NULL, INDEX IDX_A60C9F1F4DE7DC5C (adresse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere_produit (id INT AUTO_INCREMENT NOT NULL, matiere_id INT DEFAULT NULL, produit_id INT DEFAULT NULL, INDEX IDX_4A8363DBF46CD258 (matiere_id), INDEX IDX_4A8363DBF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter (id INT AUTO_INCREMENT NOT NULL, date_envoie DATETIME NOT NULL, contenu LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter_prospet (id INT AUTO_INCREMENT NOT NULL, prospet_id INT DEFAULT NULL, newsletter_id INT DEFAULT NULL, INDEX IDX_41AFAD893870A009 (prospet_id), INDEX IDX_41AFAD8922DB1917 (newsletter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, prix INT NOT NULL, nom VARCHAR(50) NOT NULL, reference VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, image VARCHAR(255) NOT NULL, reduction INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prospet (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, date_inscription DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taille (id INT AUTO_INCREMENT NOT NULL, taille VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adresse ADD CONSTRAINT FK_C35F0816B4ECFFF7 FOREIGN KEY (adresse_client_id) REFERENCES adresse_client (id)');
        $this->addSql('ALTER TABLE adresse_client ADD CONSTRAINT FK_891D1BD4DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE adresse_client ADD CONSTRAINT FK_891D1BD19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D8E54FB25 FOREIGN KEY (livraison_id) REFERENCES livraison (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE detail_commande ADD CONSTRAINT FK_98344FA682EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE detail_commande ADD CONSTRAINT FK_98344FA6F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE detail_produit ADD CONSTRAINT FK_4E6A6CF2FF25611A FOREIGN KEY (taille_id) REFERENCES taille (id)');
        $this->addSql('ALTER TABLE detail_produit ADD CONSTRAINT FK_4E6A6CF24296D31F FOREIGN KEY (genre_id) REFERENCES genre (id)');
        $this->addSql('ALTER TABLE detail_produit ADD CONSTRAINT FK_4E6A6CF2F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C43219EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C432F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7DE26E6343 FOREIGN KEY (comentaire_id) REFERENCES commentaire (id)');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1F4DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE matiere_produit ADD CONSTRAINT FK_4A8363DBF46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE matiere_produit ADD CONSTRAINT FK_4A8363DBF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE newsletter_prospet ADD CONSTRAINT FK_41AFAD893870A009 FOREIGN KEY (prospet_id) REFERENCES prospet (id)');
        $this->addSql('ALTER TABLE newsletter_prospet ADD CONSTRAINT FK_41AFAD8922DB1917 FOREIGN KEY (newsletter_id) REFERENCES newsletter (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresse DROP FOREIGN KEY FK_C35F0816B4ECFFF7');
        $this->addSql('ALTER TABLE adresse_client DROP FOREIGN KEY FK_891D1BD4DE7DC5C');
        $this->addSql('ALTER TABLE adresse_client DROP FOREIGN KEY FK_891D1BD19EB6921');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D19EB6921');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D8E54FB25');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCF347EFB');
        $this->addSql('ALTER TABLE detail_commande DROP FOREIGN KEY FK_98344FA682EA2E54');
        $this->addSql('ALTER TABLE detail_commande DROP FOREIGN KEY FK_98344FA6F347EFB');
        $this->addSql('ALTER TABLE detail_produit DROP FOREIGN KEY FK_4E6A6CF2FF25611A');
        $this->addSql('ALTER TABLE detail_produit DROP FOREIGN KEY FK_4E6A6CF24296D31F');
        $this->addSql('ALTER TABLE detail_produit DROP FOREIGN KEY FK_4E6A6CF2F347EFB');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C43219EB6921');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C432F347EFB');
        $this->addSql('ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7D19EB6921');
        $this->addSql('ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7DE26E6343');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1F4DE7DC5C');
        $this->addSql('ALTER TABLE matiere_produit DROP FOREIGN KEY FK_4A8363DBF46CD258');
        $this->addSql('ALTER TABLE matiere_produit DROP FOREIGN KEY FK_4A8363DBF347EFB');
        $this->addSql('ALTER TABLE newsletter_prospet DROP FOREIGN KEY FK_41AFAD893870A009');
        $this->addSql('ALTER TABLE newsletter_prospet DROP FOREIGN KEY FK_41AFAD8922DB1917');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE adresse_client');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE detail_commande');
        $this->addSql('DROP TABLE detail_produit');
        $this->addSql('DROP TABLE favoris');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE likes');
        $this->addSql('DROP TABLE livraison');
        $this->addSql('DROP TABLE matiere');
        $this->addSql('DROP TABLE matiere_produit');
        $this->addSql('DROP TABLE newsletter');
        $this->addSql('DROP TABLE newsletter_prospet');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE prospet');
        $this->addSql('DROP TABLE taille');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
