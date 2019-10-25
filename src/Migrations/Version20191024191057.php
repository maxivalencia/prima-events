<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191024191057 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE privilege ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE privilege ADD CONSTRAINT FK_87209A8719EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_87209A8719EB6921 ON privilege (client_id)');
        $this->addSql('ALTER TABLE type_client ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE type_client ADD CONSTRAINT FK_E4936F6D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_E4936F6D19EB6921 ON type_client (client_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE privilege DROP FOREIGN KEY FK_87209A8719EB6921');
        $this->addSql('ALTER TABLE type_client DROP FOREIGN KEY FK_E4936F6D19EB6921');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP INDEX IDX_87209A8719EB6921 ON privilege');
        $this->addSql('ALTER TABLE privilege DROP client_id');
        $this->addSql('DROP INDEX IDX_E4936F6D19EB6921 ON type_client');
        $this->addSql('ALTER TABLE type_client DROP client_id');
    }
}
