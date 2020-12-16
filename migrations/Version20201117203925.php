<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201117203925 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE report_generator_second (id INT AUTO_INCREMENT NOT NULL, report_id INT DEFAULT NULL, report_generator_id INT DEFAULT NULL, date_created DATETIME NOT NULL, date_last_modified DATETIME NOT NULL, INDEX IDX_51B74CA24BD2A4C0 (report_id), INDEX IDX_51B74CA2C17F13E1 (report_generator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE result_report (id INT AUTO_INCREMENT NOT NULL, report_generator_second_id INT DEFAULT NULL, client LONGTEXT NOT NULL, INDEX IDX_20B04CD8B5746A49 (report_generator_second_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE result_section (id INT AUTO_INCREMENT NOT NULL, section_id INT DEFAULT NULL, result_report_id INT DEFAULT NULL, INDEX IDX_4F4AF80BD823E37A (section_id), INDEX IDX_4F4AF80B7276121D (result_report_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE result_subsection (id INT AUTO_INCREMENT NOT NULL, subsection_id INT DEFAULT NULL, result_section_id INT DEFAULT NULL, markers_found LONGTEXT NOT NULL, INDEX IDX_9E4AD8FF87B204D9 (subsection_id), INDEX IDX_9E4AD8FF2078E9A5 (result_section_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE result_subsection_answer (result_subsection_id INT NOT NULL, answer_id INT NOT NULL, INDEX IDX_69AFAB73116DA (result_subsection_id), INDEX IDX_69AFABAA334807 (answer_id), PRIMARY KEY(result_subsection_id, answer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE report_generator_second ADD CONSTRAINT FK_51B74CA24BD2A4C0 FOREIGN KEY (report_id) REFERENCES report (id)');
        $this->addSql('ALTER TABLE report_generator_second ADD CONSTRAINT FK_51B74CA2C17F13E1 FOREIGN KEY (report_generator_id) REFERENCES report_generator (id)');
        $this->addSql('ALTER TABLE result_report ADD CONSTRAINT FK_20B04CD8B5746A49 FOREIGN KEY (report_generator_second_id) REFERENCES report_generator_second (id)');
        $this->addSql('ALTER TABLE result_section ADD CONSTRAINT FK_4F4AF80BD823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
        $this->addSql('ALTER TABLE result_section ADD CONSTRAINT FK_4F4AF80B7276121D FOREIGN KEY (result_report_id) REFERENCES result_report (id)');
        $this->addSql('ALTER TABLE result_subsection ADD CONSTRAINT FK_9E4AD8FF87B204D9 FOREIGN KEY (subsection_id) REFERENCES subsection (id)');
        $this->addSql('ALTER TABLE result_subsection ADD CONSTRAINT FK_9E4AD8FF2078E9A5 FOREIGN KEY (result_section_id) REFERENCES result_section (id)');
        $this->addSql('ALTER TABLE result_subsection_answer ADD CONSTRAINT FK_69AFAB73116DA FOREIGN KEY (result_subsection_id) REFERENCES result_subsection (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE result_subsection_answer ADD CONSTRAINT FK_69AFABAA334807 FOREIGN KEY (answer_id) REFERENCES answer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE report_generator ADD date_created DATETIME NOT NULL, ADD date_last_modified DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE result_report DROP FOREIGN KEY FK_20B04CD8B5746A49');
        $this->addSql('ALTER TABLE result_section DROP FOREIGN KEY FK_4F4AF80B7276121D');
        $this->addSql('ALTER TABLE result_subsection DROP FOREIGN KEY FK_9E4AD8FF2078E9A5');
        $this->addSql('ALTER TABLE result_subsection_answer DROP FOREIGN KEY FK_69AFAB73116DA');
        $this->addSql('DROP TABLE report_generator_second');
        $this->addSql('DROP TABLE result_report');
        $this->addSql('DROP TABLE result_section');
        $this->addSql('DROP TABLE result_subsection');
        $this->addSql('DROP TABLE result_subsection_answer');
        $this->addSql('ALTER TABLE report_generator DROP date_created, DROP date_last_modified');
    }
}
