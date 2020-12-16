<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201202230747 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE result_report ADD report_logo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE result_report ADD CONSTRAINT FK_20B04CD89916694A FOREIGN KEY (report_logo_id) REFERENCES report_logo (id)');
        $this->addSql('CREATE INDEX IDX_20B04CD89916694A ON result_report (report_logo_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE result_report DROP FOREIGN KEY FK_20B04CD89916694A');
        $this->addSql('DROP INDEX IDX_20B04CD89916694A ON result_report');
        $this->addSql('ALTER TABLE result_report DROP report_logo_id');
    }
}
