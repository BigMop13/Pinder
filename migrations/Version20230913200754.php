<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230913200754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'added hobbies chosen by user property';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE user_details_hobby (user_details_id INT NOT NULL, hobby_id INT NOT NULL, INDEX IDX_4705F8881C7DC1CE (user_details_id), INDEX IDX_4705F888322B2123 (hobby_id), PRIMARY KEY(user_details_id, hobby_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_details_hobby ADD CONSTRAINT FK_4705F8881C7DC1CE FOREIGN KEY (user_details_id) REFERENCES user_details (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_details_hobby ADD CONSTRAINT FK_4705F888322B2123 FOREIGN KEY (hobby_id) REFERENCES hobby (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user_details_hobby DROP FOREIGN KEY FK_4705F8881C7DC1CE');
        $this->addSql('ALTER TABLE user_details_hobby DROP FOREIGN KEY FK_4705F888322B2123');
        $this->addSql('DROP TABLE user_details_hobby');
    }
}
