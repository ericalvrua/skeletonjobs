<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210424141115 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE islas (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE islas_ofertas (islas_id INT NOT NULL, ofertas_id INT NOT NULL, INDEX IDX_21A04A764CE82CC3 (islas_id), INDEX IDX_21A04A76DB88A202 (ofertas_id), PRIMARY KEY(islas_id, ofertas_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE islas_ofertas ADD CONSTRAINT FK_21A04A764CE82CC3 FOREIGN KEY (islas_id) REFERENCES islas (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE islas_ofertas ADD CONSTRAINT FK_21A04A76DB88A202 FOREIGN KEY (ofertas_id) REFERENCES ofertas (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE islas_ofertas DROP FOREIGN KEY FK_21A04A764CE82CC3');
        $this->addSql('DROP TABLE islas');
        $this->addSql('DROP TABLE islas_ofertas');
    }
}
