<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191104162617 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE paye ADD motif_payement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE paye ADD CONSTRAINT FK_C04B89FFBC4657A1 FOREIGN KEY (motif_payement_id) REFERENCES motif_payement (id)');
        $this->addSql('CREATE INDEX IDX_C04B89FFBC4657A1 ON paye (motif_payement_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE paye DROP FOREIGN KEY FK_C04B89FFBC4657A1');
        $this->addSql('DROP INDEX IDX_C04B89FFBC4657A1 ON paye');
        $this->addSql('ALTER TABLE paye DROP motif_payement_id');
    }
}
