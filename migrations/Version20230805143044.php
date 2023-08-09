<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230805143044 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'fixed relation from user to details (PINDER-19)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user ADD user_details_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6491C7DC1CE FOREIGN KEY (user_details_id) REFERENCES user_details (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6491C7DC1CE ON user (user_details_id)');
        $this->addSql('ALTER TABLE user_details DROP FOREIGN KEY FK_2A2B1580A76ED395');
        $this->addSql('DROP INDEX UNIQ_2A2B1580A76ED395 ON user_details');
        $this->addSql('ALTER TABLE user_details DROP user_id');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6491C7DC1CE');
        $this->addSql('DROP INDEX UNIQ_8D93D6491C7DC1CE ON user');
        $this->addSql('ALTER TABLE user DROP user_details_id');
        $this->addSql('ALTER TABLE user_details ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_details ADD CONSTRAINT FK_2A2B1580A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2A2B1580A76ED395 ON user_details (user_id)');
    }
}
