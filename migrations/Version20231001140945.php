<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231001140945 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'changed user age to datetime';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user CHANGE age age DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user CHANGE age age INT NOT NULL');
    }
}
