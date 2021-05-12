<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210318103038 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ofertas ADD categoria_id INT NOT NULL');
        $this->addSql('ALTER TABLE ofertas ADD CONSTRAINT FK_48C925F33397707A FOREIGN KEY (categoria_id) REFERENCES categorias (id)');
        $this->addSql('CREATE INDEX IDX_48C925F33397707A ON ofertas (categoria_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ofertas DROP FOREIGN KEY FK_48C925F33397707A');
        $this->addSql('DROP INDEX IDX_48C925F33397707A ON ofertas');
        $this->addSql('ALTER TABLE ofertas DROP categoria_id');
    }
}
