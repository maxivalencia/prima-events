<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191024200238 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE paye (id INT AUTO_INCREMENT NOT NULL, refstock VARCHAR(255) NOT NULL, date_payement DATE NOT NULL, tva TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE payement ADD paye_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payement ADD CONSTRAINT FK_B20A7885D3964A07 FOREIGN KEY (paye_id) REFERENCES paye (id)');
        $this->addSql('CREATE INDEX IDX_B20A7885D3964A07 ON payement (paye_id)');
        $this->addSql('ALTER TABLE type_payement ADD paye_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE type_payement ADD CONSTRAINT FK_7FF55F79D3964A07 FOREIGN KEY (paye_id) REFERENCES paye (id)');
        $this->addSql('CREATE INDEX IDX_7FF55F79D3964A07 ON type_payement (paye_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE payement DROP FOREIGN KEY FK_B20A7885D3964A07');
        $this->addSql('ALTER TABLE type_payement DROP FOREIGN KEY FK_7FF55F79D3964A07');
        $this->addSql('DROP TABLE paye');
        $this->addSql('DROP INDEX IDX_B20A7885D3964A07 ON payement');
        $this->addSql('ALTER TABLE payement DROP paye_id');
        $this->addSql('DROP INDEX IDX_7FF55F79D3964A07 ON type_payement');
        $this->addSql('ALTER TABLE type_payement DROP paye_id');
    }
}
