<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201113012039 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE marker_section DROP FOREIGN KEY FK_57FFEBE5474460EB');
        $this->addSql('CREATE TABLE section_subsection (section_id INT NOT NULL, subsection_id INT NOT NULL, INDEX IDX_FBA1E8FFD823E37A (section_id), INDEX IDX_FBA1E8FF87B204D9 (subsection_id), PRIMARY KEY(section_id, subsection_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section_report (id INT AUTO_INCREMENT NOT NULL, section_id INT DEFAULT NULL, report_id INT DEFAULT NULL, order_number INT NOT NULL, INDEX IDX_8E6785A2D823E37A (section_id), INDEX IDX_8E6785A24BD2A4C0 (report_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subsection (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, is_automatic TINYINT(1) NOT NULL, markers VARCHAR(2000) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subsection_answer (subsection_id INT NOT NULL, answer_id INT NOT NULL, INDEX IDX_F0683FF387B204D9 (subsection_id), INDEX IDX_F0683FF3AA334807 (answer_id), PRIMARY KEY(subsection_id, answer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE section_subsection ADD CONSTRAINT FK_FBA1E8FFD823E37A FOREIGN KEY (section_id) REFERENCES section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE section_subsection ADD CONSTRAINT FK_FBA1E8FF87B204D9 FOREIGN KEY (subsection_id) REFERENCES subsection (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE section_report ADD CONSTRAINT FK_8E6785A2D823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
        $this->addSql('ALTER TABLE section_report ADD CONSTRAINT FK_8E6785A24BD2A4C0 FOREIGN KEY (report_id) REFERENCES report (id)');
        $this->addSql('ALTER TABLE subsection_answer ADD CONSTRAINT FK_F0683FF387B204D9 FOREIGN KEY (subsection_id) REFERENCES subsection (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subsection_answer ADD CONSTRAINT FK_F0683FF3AA334807 FOREIGN KEY (answer_id) REFERENCES answer (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE answer_section');
        $this->addSql('DROP TABLE marker');
        $this->addSql('DROP TABLE marker_section');
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEF4BD2A4C0');
        $this->addSql('DROP INDEX IDX_2D737AEF4BD2A4C0 ON section');
        $this->addSql('ALTER TABLE section DROP report_id, DROP is_automatic');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE section_subsection DROP FOREIGN KEY FK_FBA1E8FF87B204D9');
        $this->addSql('ALTER TABLE subsection_answer DROP FOREIGN KEY FK_F0683FF387B204D9');
        $this->addSql('CREATE TABLE answer_section (answer_id INT NOT NULL, section_id INT NOT NULL, INDEX IDX_6533B59ED823E37A (section_id), INDEX IDX_6533B59EAA334807 (answer_id), PRIMARY KEY(answer_id, section_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE marker (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE marker_section (marker_id INT NOT NULL, section_id INT NOT NULL, INDEX IDX_57FFEBE5474460EB (marker_id), INDEX IDX_57FFEBE5D823E37A (section_id), PRIMARY KEY(marker_id, section_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE answer_section ADD CONSTRAINT FK_6533B59EAA334807 FOREIGN KEY (answer_id) REFERENCES answer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE answer_section ADD CONSTRAINT FK_6533B59ED823E37A FOREIGN KEY (section_id) REFERENCES section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE marker_section ADD CONSTRAINT FK_57FFEBE5474460EB FOREIGN KEY (marker_id) REFERENCES marker (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE marker_section ADD CONSTRAINT FK_57FFEBE5D823E37A FOREIGN KEY (section_id) REFERENCES section (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE section_subsection');
        $this->addSql('DROP TABLE section_report');
        $this->addSql('DROP TABLE subsection');
        $this->addSql('DROP TABLE subsection_answer');
        $this->addSql('ALTER TABLE section ADD report_id INT DEFAULT NULL, ADD is_automatic TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEF4BD2A4C0 FOREIGN KEY (report_id) REFERENCES report (id)');
        $this->addSql('CREATE INDEX IDX_2D737AEF4BD2A4C0 ON section (report_id)');
    }
}
