<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231028220234 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create user rates table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE user_selection (id INT AUTO_INCREMENT NOT NULL, choosing_user_id INT NOT NULL, rated_user_id INT NOT NULL, rate TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE user_selection');
    }
}
