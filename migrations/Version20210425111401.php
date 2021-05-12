<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210425111401 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE preguntas (id INT AUTO_INCREMENT NOT NULL, oferta_id INT NOT NULL, pregunta VARCHAR(255) NOT NULL, requerido TINYINT(1) NOT NULL, INDEX IDX_38794855FAFBF624 (oferta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE respuestas (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, pregunta_id INT NOT NULL, respuesta VARCHAR(255) NOT NULL, INDEX IDX_5CD06EB1DB38439E (usuario_id), INDEX IDX_5CD06EB131A5801E (pregunta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE preguntas ADD CONSTRAINT FK_38794855FAFBF624 FOREIGN KEY (oferta_id) REFERENCES ofertas (id)');
        $this->addSql('ALTER TABLE respuestas ADD CONSTRAINT FK_5CD06EB1DB38439E FOREIGN KEY (usuario_id) REFERENCES usuarios (id)');
        $this->addSql('ALTER TABLE respuestas ADD CONSTRAINT FK_5CD06EB131A5801E FOREIGN KEY (pregunta_id) REFERENCES preguntas (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE respuestas DROP FOREIGN KEY FK_5CD06EB131A5801E');
        $this->addSql('DROP TABLE preguntas');
        $this->addSql('DROP TABLE respuestas');
    }
}
