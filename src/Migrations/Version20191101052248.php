<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191101052248 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE stock ADD user_sortie_id INT DEFAULT NULL, ADD user_retour_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B365660CC9254B7 FOREIGN KEY (user_sortie_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B36566028368EFB FOREIGN KEY (user_retour_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_4B365660CC9254B7 ON stock (user_sortie_id)');
        $this->addSql('CREATE INDEX IDX_4B36566028368EFB ON stock (user_retour_id)');
        $this->addSql('ALTER TABLE type_payement DROP FOREIGN KEY FK_7FF55F79D3964A07');
        $this->addSql('DROP INDEX IDX_7FF55F79D3964A07 ON type_payement');
        $this->addSql('ALTER TABLE type_payement DROP paye_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B365660CC9254B7');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B36566028368EFB');
        $this->addSql('DROP INDEX IDX_4B365660CC9254B7 ON stock');
        $this->addSql('DROP INDEX IDX_4B36566028368EFB ON stock');
        $this->addSql('ALTER TABLE stock DROP user_sortie_id, DROP user_retour_id');
        $this->addSql('ALTER TABLE type_payement ADD paye_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE type_payement ADD CONSTRAINT FK_7FF55F79D3964A07 FOREIGN KEY (paye_id) REFERENCES paye (id)');
        $this->addSql('CREATE INDEX IDX_7FF55F79D3964A07 ON type_payement (paye_id)');
    }
}
