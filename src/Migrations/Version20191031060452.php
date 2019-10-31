<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191031060452 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE paye DROP FOREIGN KEY FK_C04B89FF868C0609');
        $this->addSql('ALTER TABLE paye DROP FOREIGN KEY FK_C04B89FFCD95D198');
        $this->addSql('DROP INDEX IDX_C04B89FFCD95D198 ON paye');
        $this->addSql('DROP INDEX IDX_C04B89FF868C0609 ON paye');
        $this->addSql('ALTER TABLE paye DROP payement_id, DROP type_payement_id');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B3656607294869C');
        $this->addSql('DROP INDEX IDX_4B3656607294869C ON stock');
        $this->addSql('ALTER TABLE stock DROP article_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE paye ADD payement_id INT DEFAULT NULL, ADD type_payement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE paye ADD CONSTRAINT FK_C04B89FF868C0609 FOREIGN KEY (payement_id) REFERENCES payement (id)');
        $this->addSql('ALTER TABLE paye ADD CONSTRAINT FK_C04B89FFCD95D198 FOREIGN KEY (type_payement_id) REFERENCES type_payement (id)');
        $this->addSql('CREATE INDEX IDX_C04B89FFCD95D198 ON paye (type_payement_id)');
        $this->addSql('CREATE INDEX IDX_C04B89FF868C0609 ON paye (payement_id)');
        $this->addSql('ALTER TABLE stock ADD article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B3656607294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_4B3656607294869C ON stock (article_id)');
    }
}
