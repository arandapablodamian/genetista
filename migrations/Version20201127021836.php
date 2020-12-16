<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201127021836 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE result_subsection_answer');
        $this->addSql('ALTER TABLE result_subsection ADD answers LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE result_subsection_answer (result_subsection_id INT NOT NULL, answer_id INT NOT NULL, INDEX IDX_69AFAB73116DA (result_subsection_id), INDEX IDX_69AFABAA334807 (answer_id), PRIMARY KEY(result_subsection_id, answer_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE result_subsection_answer ADD CONSTRAINT FK_69AFAB73116DA FOREIGN KEY (result_subsection_id) REFERENCES result_subsection (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE result_subsection_answer ADD CONSTRAINT FK_69AFABAA334807 FOREIGN KEY (answer_id) REFERENCES answer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE result_subsection DROP answers');
    }
}
