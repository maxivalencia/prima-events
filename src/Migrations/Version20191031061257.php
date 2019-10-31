<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191031061257 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE paye ADD payement_id INT DEFAULT NULL, ADD typepayement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE paye ADD CONSTRAINT FK_C04B89FF868C0609 FOREIGN KEY (payement_id) REFERENCES payement (id)');
        $this->addSql('ALTER TABLE paye ADD CONSTRAINT FK_C04B89FFF8C42054 FOREIGN KEY (typepayement_id) REFERENCES type_payement (id)');
        $this->addSql('CREATE INDEX IDX_C04B89FF868C0609 ON paye (payement_id)');
        $this->addSql('CREATE INDEX IDX_C04B89FFF8C42054 ON paye (typepayement_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE paye DROP FOREIGN KEY FK_C04B89FF868C0609');
        $this->addSql('ALTER TABLE paye DROP FOREIGN KEY FK_C04B89FFF8C42054');
        $this->addSql('DROP INDEX IDX_C04B89FF868C0609 ON paye');
        $this->addSql('DROP INDEX IDX_C04B89FFF8C42054 ON paye');
        $this->addSql('ALTER TABLE paye DROP payement_id, DROP typepayement_id');
    }
}
