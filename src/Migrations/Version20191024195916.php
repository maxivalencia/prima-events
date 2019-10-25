<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191024195916 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE stock (id INT AUTO_INCREMENT NOT NULL, quantite INT NOT NULL, reference VARCHAR(255) NOT NULL, date_commande DATE DEFAULT NULL, date_sortie_prevue DATE DEFAULT NULL, date_sortie_effectif DATE DEFAULT NULL, date_retour_prevu DATE DEFAULT NULL, date_retour_effectif DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD stock_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66DCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66DCD6110 ON article (stock_id)');
        $this->addSql('ALTER TABLE client ADD stock_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455DCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('CREATE INDEX IDX_C7440455DCD6110 ON client (stock_id)');
        $this->addSql('ALTER TABLE mode ADD stock_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mode ADD CONSTRAINT FK_97CA47ABDCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('CREATE INDEX IDX_97CA47ABDCD6110 ON mode (stock_id)');
        $this->addSql('ALTER TABLE mouvement ADD stock_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mouvement ADD CONSTRAINT FK_5B51FC3EDCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('CREATE INDEX IDX_5B51FC3EDCD6110 ON mouvement (stock_id)');
        $this->addSql('ALTER TABLE utilisateur ADD stock_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3DCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B3DCD6110 ON utilisateur (stock_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66DCD6110');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455DCD6110');
        $this->addSql('ALTER TABLE mode DROP FOREIGN KEY FK_97CA47ABDCD6110');
        $this->addSql('ALTER TABLE mouvement DROP FOREIGN KEY FK_5B51FC3EDCD6110');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3DCD6110');
        $this->addSql('DROP TABLE stock');
        $this->addSql('DROP INDEX IDX_23A0E66DCD6110 ON article');
        $this->addSql('ALTER TABLE article DROP stock_id');
        $this->addSql('DROP INDEX IDX_C7440455DCD6110 ON client');
        $this->addSql('ALTER TABLE client DROP stock_id');
        $this->addSql('DROP INDEX IDX_97CA47ABDCD6110 ON mode');
        $this->addSql('ALTER TABLE mode DROP stock_id');
        $this->addSql('DROP INDEX IDX_5B51FC3EDCD6110 ON mouvement');
        $this->addSql('ALTER TABLE mouvement DROP stock_id');
        $this->addSql('DROP INDEX IDX_1D1C63B3DCD6110 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP stock_id');
    }
}
