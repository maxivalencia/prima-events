<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191107062449 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, stock_id INT DEFAULT NULL, type_client_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, INDEX IDX_C7440455DCD6110 (stock_id), INDEX IDX_C7440455AD2D2831 (type_client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paye (id INT AUTO_INCREMENT NOT NULL, payement_id INT DEFAULT NULL, typepayement_id INT DEFAULT NULL, type_payement_id INT DEFAULT NULL, motif_payement_id INT DEFAULT NULL, refstock VARCHAR(255) NOT NULL, date_payement DATE NOT NULL, tva TINYINT(1) NOT NULL, montant DOUBLE PRECISION NOT NULL, INDEX IDX_C04B89FF868C0609 (payement_id), INDEX IDX_C04B89FFF8C42054 (typepayement_id), INDEX IDX_C04B89FFCD95D198 (type_payement_id), INDEX IDX_C04B89FFBC4657A1 (motif_payement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, article_id INT DEFAULT NULL, mouvement_id INT DEFAULT NULL, client_id INT DEFAULT NULL, mode_id INT DEFAULT NULL, user_sortie_id INT DEFAULT NULL, user_retour_id INT DEFAULT NULL, location_id INT DEFAULT NULL, quantite INT NOT NULL, reference VARCHAR(255) NOT NULL, date_commande DATE DEFAULT NULL, date_sortie_prevue DATE DEFAULT NULL, date_sortie_effectif DATE DEFAULT NULL, date_retour_prevu DATE DEFAULT NULL, date_retour_effectif DATE DEFAULT NULL, quantite_louer INT DEFAULT NULL, INDEX IDX_4B365660A76ED395 (user_id), INDEX IDX_4B3656607294869C (article_id), INDEX IDX_4B365660ECD1C222 (mouvement_id), INDEX IDX_4B36566019EB6921 (client_id), INDEX IDX_4B36566077E5854A (mode_id), INDEX IDX_4B365660CC9254B7 (user_sortie_id), INDEX IDX_4B36566028368EFB (user_retour_id), INDEX IDX_4B36566064D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, stock_id INT DEFAULT NULL, designation VARCHAR(255) NOT NULL, prix_unitaire DOUBLE PRECISION NOT NULL, prix_casse DOUBLE PRECISION NOT NULL, INDEX IDX_23A0E66DCD6110 (stock_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_payement (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_client (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, stock_id INT DEFAULT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, INDEX IDX_1D1C63B3DCD6110 (stock_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE motif_payement (id INT AUTO_INCREMENT NOT NULL, motif VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taux_refacturation (id INT AUTO_INCREMENT NOT NULL, taux DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE privilege (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, privilege VARCHAR(255) NOT NULL, INDEX IDX_87209A8719EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tva (id INT AUTO_INCREMENT NOT NULL, tva DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payement (id INT AUTO_INCREMENT NOT NULL, paye_id INT DEFAULT NULL, mode VARCHAR(255) NOT NULL, INDEX IDX_B20A7885D3964A07 (paye_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fournisseur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mode (id INT AUTO_INCREMENT NOT NULL, mode VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mouvement (id INT AUTO_INCREMENT NOT NULL, stock_id INT DEFAULT NULL, mouvement VARCHAR(255) NOT NULL, INDEX IDX_5B51FC3EDCD6110 (stock_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455DCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455AD2D2831 FOREIGN KEY (type_client_id) REFERENCES type_client (id)');
        $this->addSql('ALTER TABLE paye ADD CONSTRAINT FK_C04B89FF868C0609 FOREIGN KEY (payement_id) REFERENCES payement (id)');
        $this->addSql('ALTER TABLE paye ADD CONSTRAINT FK_C04B89FFF8C42054 FOREIGN KEY (typepayement_id) REFERENCES type_payement (id)');
        $this->addSql('ALTER TABLE paye ADD CONSTRAINT FK_C04B89FFCD95D198 FOREIGN KEY (type_payement_id) REFERENCES type_payement (id)');
        $this->addSql('ALTER TABLE paye ADD CONSTRAINT FK_C04B89FFBC4657A1 FOREIGN KEY (motif_payement_id) REFERENCES motif_payement (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B365660A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B3656607294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B365660ECD1C222 FOREIGN KEY (mouvement_id) REFERENCES mouvement (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B36566019EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B36566077E5854A FOREIGN KEY (mode_id) REFERENCES mode (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B365660CC9254B7 FOREIGN KEY (user_sortie_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B36566028368EFB FOREIGN KEY (user_retour_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B36566064D218E FOREIGN KEY (location_id) REFERENCES fournisseur (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66DCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3DCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('ALTER TABLE privilege ADD CONSTRAINT FK_87209A8719EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE payement ADD CONSTRAINT FK_B20A7885D3964A07 FOREIGN KEY (paye_id) REFERENCES paye (id)');
        $this->addSql('ALTER TABLE mouvement ADD CONSTRAINT FK_5B51FC3EDCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B36566019EB6921');
        $this->addSql('ALTER TABLE privilege DROP FOREIGN KEY FK_87209A8719EB6921');
        $this->addSql('ALTER TABLE payement DROP FOREIGN KEY FK_B20A7885D3964A07');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455DCD6110');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66DCD6110');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3DCD6110');
        $this->addSql('ALTER TABLE mouvement DROP FOREIGN KEY FK_5B51FC3EDCD6110');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B3656607294869C');
        $this->addSql('ALTER TABLE paye DROP FOREIGN KEY FK_C04B89FFF8C42054');
        $this->addSql('ALTER TABLE paye DROP FOREIGN KEY FK_C04B89FFCD95D198');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455AD2D2831');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B365660A76ED395');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B365660CC9254B7');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B36566028368EFB');
        $this->addSql('ALTER TABLE paye DROP FOREIGN KEY FK_C04B89FFBC4657A1');
        $this->addSql('ALTER TABLE paye DROP FOREIGN KEY FK_C04B89FF868C0609');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B36566064D218E');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B36566077E5854A');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B365660ECD1C222');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE paye');
        $this->addSql('DROP TABLE stock');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE type_payement');
        $this->addSql('DROP TABLE type_client');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE motif_payement');
        $this->addSql('DROP TABLE taux_refacturation');
        $this->addSql('DROP TABLE privilege');
        $this->addSql('DROP TABLE tva');
        $this->addSql('DROP TABLE payement');
        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('DROP TABLE mode');
        $this->addSql('DROP TABLE mouvement');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
    }
}
