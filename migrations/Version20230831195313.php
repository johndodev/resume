<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230831195313 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE degree CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE experience CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE realisation CHANGE description description TEXT DEFAULT NULL, CHANGE print_description print_description TEXT DEFAULT NULL');
    }
}
