<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191112080931 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE caution (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE indemnite (id INT AUTO_INCREMENT NOT NULL, refence VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE retour (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, quantite_sortie INT NOT NULL, reference VARCHAR(255) NOT NULL, date_retour DATE NOT NULL, quantite_retourner INT NOT NULL, cassure INT NOT NULL, prix DOUBLE PRECISION NOT NULL, INDEX IDX_ED6FD3217294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE retour_article (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, quantitesortie INT NOT NULL, reference VARCHAR(255) NOT NULL, date_retour DATE NOT NULL, quatite_retourner INT NOT NULL, cassure INT NOT NULL, prix DOUBLE PRECISION NOT NULL, reste INT NOT NULL, INDEX IDX_F0632AEA7294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE retour_client (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sortie_article (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, refernce VARCHAR(255) NOT NULL, quantite_commander INT NOT NULL, quantite_sortie INT NOT NULL, date DATE NOT NULL, reste INT DEFAULT NULL, INDEX IDX_C0EA050B7294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE retour ADD CONSTRAINT FK_ED6FD3217294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE retour_article ADD CONSTRAINT FK_F0632AEA7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE sortie_article ADD CONSTRAINT FK_C0EA050B7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE client ADD cin VARCHAR(255) DEFAULT NULL, ADD stat VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE stock ADD nb_jour INT DEFAULT NULL, ADD date_de_validation_proformat DATE DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE caution');
        $this->addSql('DROP TABLE indemnite');
        $this->addSql('DROP TABLE retour');
        $this->addSql('DROP TABLE retour_article');
        $this->addSql('DROP TABLE retour_client');
        $this->addSql('DROP TABLE sortie_article');
        $this->addSql('ALTER TABLE client DROP cin, DROP stat');
        $this->addSql('ALTER TABLE stock DROP nb_jour, DROP date_de_validation_proformat');
    }
}
