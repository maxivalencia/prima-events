<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191031183332 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client ADD type_client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455AD2D2831 FOREIGN KEY (type_client_id) REFERENCES type_client (id)');
        $this->addSql('CREATE INDEX IDX_C7440455AD2D2831 ON client (type_client_id)');
        $this->addSql('ALTER TABLE paye ADD type_payement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE paye ADD CONSTRAINT FK_C04B89FFCD95D198 FOREIGN KEY (type_payement_id) REFERENCES type_payement (id)');
        $this->addSql('CREATE INDEX IDX_C04B89FFCD95D198 ON paye (type_payement_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455AD2D2831');
        $this->addSql('DROP INDEX IDX_C7440455AD2D2831 ON client');
        $this->addSql('ALTER TABLE client DROP type_client_id');
        $this->addSql('ALTER TABLE paye DROP FOREIGN KEY FK_C04B89FFCD95D198');
        $this->addSql('DROP INDEX IDX_C04B89FFCD95D198 ON paye');
        $this->addSql('ALTER TABLE paye DROP type_payement_id');
    }
}
