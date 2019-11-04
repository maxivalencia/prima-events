<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191104054955 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE fournisseur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client ADD type_client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455AD2D2831 FOREIGN KEY (type_client_id) REFERENCES type_client (id)');
        $this->addSql('CREATE INDEX IDX_C7440455AD2D2831 ON client (type_client_id)');
        $this->addSql('ALTER TABLE mode DROP FOREIGN KEY FK_97CA47ABDCD6110');
        $this->addSql('DROP INDEX IDX_97CA47ABDCD6110 ON mode');
        $this->addSql('ALTER TABLE mode DROP stock_id');
        $this->addSql('ALTER TABLE paye ADD type_payement_id INT DEFAULT NULL, ADD montant DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE paye ADD CONSTRAINT FK_C04B89FFCD95D198 FOREIGN KEY (type_payement_id) REFERENCES type_payement (id)');
        $this->addSql('CREATE INDEX IDX_C04B89FFCD95D198 ON paye (type_payement_id)');
        $this->addSql('ALTER TABLE stock ADD user_sortie_id INT DEFAULT NULL, ADD user_retour_id INT DEFAULT NULL, ADD location_id INT DEFAULT NULL, ADD quantite_louer INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B365660CC9254B7 FOREIGN KEY (user_sortie_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B36566028368EFB FOREIGN KEY (user_retour_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B36566064D218E FOREIGN KEY (location_id) REFERENCES fournisseur (id)');
        $this->addSql('CREATE INDEX IDX_4B365660CC9254B7 ON stock (user_sortie_id)');
        $this->addSql('CREATE INDEX IDX_4B36566028368EFB ON stock (user_retour_id)');
        $this->addSql('CREATE INDEX IDX_4B36566064D218E ON stock (location_id)');
        $this->addSql('ALTER TABLE type_client DROP FOREIGN KEY FK_E4936F6D19EB6921');
        $this->addSql('DROP INDEX IDX_E4936F6D19EB6921 ON type_client');
        $this->addSql('ALTER TABLE type_client DROP client_id');
        $this->addSql('ALTER TABLE type_payement DROP FOREIGN KEY FK_7FF55F79D3964A07');
        $this->addSql('DROP INDEX IDX_7FF55F79D3964A07 ON type_payement');
        $this->addSql('ALTER TABLE type_payement DROP paye_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B36566064D218E');
        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455AD2D2831');
        $this->addSql('DROP INDEX IDX_C7440455AD2D2831 ON client');
        $this->addSql('ALTER TABLE client DROP type_client_id');
        $this->addSql('ALTER TABLE mode ADD stock_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mode ADD CONSTRAINT FK_97CA47ABDCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('CREATE INDEX IDX_97CA47ABDCD6110 ON mode (stock_id)');
        $this->addSql('ALTER TABLE paye DROP FOREIGN KEY FK_C04B89FFCD95D198');
        $this->addSql('DROP INDEX IDX_C04B89FFCD95D198 ON paye');
        $this->addSql('ALTER TABLE paye DROP type_payement_id, DROP montant');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B365660CC9254B7');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B36566028368EFB');
        $this->addSql('DROP INDEX IDX_4B365660CC9254B7 ON stock');
        $this->addSql('DROP INDEX IDX_4B36566028368EFB ON stock');
        $this->addSql('DROP INDEX IDX_4B36566064D218E ON stock');
        $this->addSql('ALTER TABLE stock DROP user_sortie_id, DROP user_retour_id, DROP location_id, DROP quantite_louer');
        $this->addSql('ALTER TABLE type_client ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE type_client ADD CONSTRAINT FK_E4936F6D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_E4936F6D19EB6921 ON type_client (client_id)');
        $this->addSql('ALTER TABLE type_payement ADD paye_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE type_payement ADD CONSTRAINT FK_7FF55F79D3964A07 FOREIGN KEY (paye_id) REFERENCES paye (id)');
        $this->addSql('CREATE INDEX IDX_7FF55F79D3964A07 ON type_payement (paye_id)');
    }
}
