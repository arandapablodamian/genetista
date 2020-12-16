<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201202110411 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE report_logo (id INT AUTO_INCREMENT NOT NULL, report_generator_id INT DEFAULT NULL, show_jdlogo TINYINT(1) DEFAULT NULL, path VARCHAR(500) DEFAULT NULL, update_at DATETIME DEFAULT NULL, INDEX IDX_97A277E8C17F13E1 (report_generator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE report_logo ADD CONSTRAINT FK_97A277E8C17F13E1 FOREIGN KEY (report_generator_id) REFERENCES report_generator (id)');
        $this->addSql('ALTER TABLE result_report ADD many_to_one_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE result_report ADD CONSTRAINT FK_20B04CD8EAB5DEB FOREIGN KEY (many_to_one_id) REFERENCES report_logo (id)');
        $this->addSql('CREATE INDEX IDX_20B04CD8EAB5DEB ON result_report (many_to_one_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE result_report DROP FOREIGN KEY FK_20B04CD8EAB5DEB');
        $this->addSql('DROP TABLE report_logo');
        $this->addSql('DROP INDEX IDX_20B04CD8EAB5DEB ON result_report');
        $this->addSql('ALTER TABLE result_report DROP many_to_one_id');
    }
}
