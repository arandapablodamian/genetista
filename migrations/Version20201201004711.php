<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201201004711 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE result_marker (id INT AUTO_INCREMENT NOT NULL, result_subsection_id INT DEFAULT NULL, gene VARCHAR(255) DEFAULT NULL, marker VARCHAR(255) DEFAULT NULL, genotype VARCHAR(255) DEFAULT NULL, answers LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', bibliography VARCHAR(5000) DEFAULT NULL, INDEX IDX_66501BA273116DA (result_subsection_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE result_marker ADD CONSTRAINT FK_66501BA273116DA FOREIGN KEY (result_subsection_id) REFERENCES result_subsection (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE result_marker');
    }
}
