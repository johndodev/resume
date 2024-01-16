<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240116165459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE degree (id INT AUTO_INCREMENT NOT NULL, resume_id INT DEFAULT NULL, title VARCHAR(64) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, url_label VARCHAR(64) DEFAULT NULL, description TEXT DEFAULT NULL, started_at DATE DEFAULT NULL, stopped_at DATE DEFAULT NULL, INDEX IDX_A7A36D63D262AF09 (resume_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experience (id INT AUTO_INCREMENT NOT NULL, resume_id INT DEFAULT NULL, title VARCHAR(64) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, url_label VARCHAR(64) DEFAULT NULL, description TEXT DEFAULT NULL, started_at DATE DEFAULT NULL, stopped_at DATE DEFAULT NULL, INDEX IDX_590C103D262AF09 (resume_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE network (id INT AUTO_INCREMENT NOT NULL, resume_id INT DEFAULT NULL, name VARCHAR(64) NOT NULL, url VARCHAR(255) NOT NULL, icon_class VARCHAR(255) NOT NULL, INDEX IDX_608487BCD262AF09 (resume_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE realisation (id INT AUTO_INCREMENT NOT NULL, resume_id INT DEFAULT NULL, title VARCHAR(64) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, url_label VARCHAR(64) DEFAULT NULL, description TEXT DEFAULT NULL, started_at DATE DEFAULT NULL, stopped_at DATE DEFAULT NULL, ordering SMALLINT NOT NULL, print_description TEXT DEFAULT NULL, visible_print TINYINT(1) NOT NULL, INDEX IDX_EAA5610ED262AF09 (resume_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resume (id INT AUTO_INCREMENT NOT NULL, updated_at DATETIME DEFAULT NULL, name VARCHAR(64) NOT NULL, birthdate DATE NOT NULL, job_title VARCHAR(64) NOT NULL, status VARCHAR(255) NOT NULL, status_type VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, city VARCHAR(64) NOT NULL, email VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE degree ADD CONSTRAINT FK_A7A36D63D262AF09 FOREIGN KEY (resume_id) REFERENCES resume (id)');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT FK_590C103D262AF09 FOREIGN KEY (resume_id) REFERENCES resume (id)');
        $this->addSql('ALTER TABLE network ADD CONSTRAINT FK_608487BCD262AF09 FOREIGN KEY (resume_id) REFERENCES resume (id)');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT FK_EAA5610ED262AF09 FOREIGN KEY (resume_id) REFERENCES resume (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE degree DROP FOREIGN KEY FK_A7A36D63D262AF09');
        $this->addSql('ALTER TABLE experience DROP FOREIGN KEY FK_590C103D262AF09');
        $this->addSql('ALTER TABLE network DROP FOREIGN KEY FK_608487BCD262AF09');
        $this->addSql('ALTER TABLE realisation DROP FOREIGN KEY FK_EAA5610ED262AF09');
        $this->addSql('DROP TABLE degree');
        $this->addSql('DROP TABLE experience');
        $this->addSql('DROP TABLE network');
        $this->addSql('DROP TABLE realisation');
        $this->addSql('DROP TABLE resume');
    }
}
