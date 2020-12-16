<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201104195140 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE marker (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marker_section (marker_id INT NOT NULL, section_id INT NOT NULL, INDEX IDX_57FFEBE5474460EB (marker_id), INDEX IDX_57FFEBE5D823E37A (section_id), PRIMARY KEY(marker_id, section_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE report (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section (id INT AUTO_INCREMENT NOT NULL, report_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, is_automatic TINYINT(1) NOT NULL, INDEX IDX_2D737AEF4BD2A4C0 (report_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, enabled TINYINT(1) DEFAULT \'0\', UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE marker_section ADD CONSTRAINT FK_57FFEBE5474460EB FOREIGN KEY (marker_id) REFERENCES marker (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE marker_section ADD CONSTRAINT FK_57FFEBE5D823E37A FOREIGN KEY (section_id) REFERENCES section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEF4BD2A4C0 FOREIGN KEY (report_id) REFERENCES report (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE marker_section DROP FOREIGN KEY FK_57FFEBE5474460EB');
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEF4BD2A4C0');
        $this->addSql('ALTER TABLE marker_section DROP FOREIGN KEY FK_57FFEBE5D823E37A');
        $this->addSql('DROP TABLE marker');
        $this->addSql('DROP TABLE marker_section');
        $this->addSql('DROP TABLE report');
        $this->addSql('DROP TABLE section');
        $this->addSql('DROP TABLE user');
    }
}
