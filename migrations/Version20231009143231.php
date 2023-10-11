<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231009143231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, statut VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, use_id INT DEFAULT NULL, produit_id INT DEFAULT NULL, commande_id INT DEFAULT NULL, name_produit VARCHAR(255) NOT NULL, price_panier NUMERIC(10, 2) NOT NULL, quantity INT NOT NULL, INDEX IDX_24CC0DF2C1A7BCDD (use_id), INDEX IDX_24CC0DF2F347EFB (produit_id), INDEX IDX_24CC0DF282EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, use_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_29A5EC27C1A7BCDD (use_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, commande_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D64982EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2C1A7BCDD FOREIGN KEY (use_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF282EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27C1A7BCDD FOREIGN KEY (use_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D64982EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2C1A7BCDD');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2F347EFB');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF282EA2E54');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27C1A7BCDD');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D64982EA2E54');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE `user`');
    }
}
