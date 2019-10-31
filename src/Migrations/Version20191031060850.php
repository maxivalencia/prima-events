<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191031060850 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE stock ADD user_id INT DEFAULT NULL, ADD article_id INT DEFAULT NULL, ADD mouvement_id INT DEFAULT NULL, ADD client_id INT DEFAULT NULL, ADD mode_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B365660A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B3656607294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B365660ECD1C222 FOREIGN KEY (mouvement_id) REFERENCES mouvement (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B36566019EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B36566077E5854A FOREIGN KEY (mode_id) REFERENCES mode (id)');
        $this->addSql('CREATE INDEX IDX_4B365660A76ED395 ON stock (user_id)');
        $this->addSql('CREATE INDEX IDX_4B3656607294869C ON stock (article_id)');
        $this->addSql('CREATE INDEX IDX_4B365660ECD1C222 ON stock (mouvement_id)');
        $this->addSql('CREATE INDEX IDX_4B36566019EB6921 ON stock (client_id)');
        $this->addSql('CREATE INDEX IDX_4B36566077E5854A ON stock (mode_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B365660A76ED395');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B3656607294869C');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B365660ECD1C222');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B36566019EB6921');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B36566077E5854A');
        $this->addSql('DROP INDEX IDX_4B365660A76ED395 ON stock');
        $this->addSql('DROP INDEX IDX_4B3656607294869C ON stock');
        $this->addSql('DROP INDEX IDX_4B365660ECD1C222 ON stock');
        $this->addSql('DROP INDEX IDX_4B36566019EB6921 ON stock');
        $this->addSql('DROP INDEX IDX_4B36566077E5854A ON stock');
        $this->addSql('ALTER TABLE stock DROP user_id, DROP article_id, DROP mouvement_id, DROP client_id, DROP mode_id');
    }
}
