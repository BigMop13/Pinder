<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230805141521 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'fixed relation from user to preferences (PINDER-19)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user ADD user_preferences_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6491748B0EE FOREIGN KEY (user_preferences_id) REFERENCES user_preference (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6491748B0EE ON user (user_preferences_id)');
        $this->addSql('ALTER TABLE user_preference DROP FOREIGN KEY FK_FA0E76BFA76ED395');
        $this->addSql('DROP INDEX UNIQ_FA0E76BFA76ED395 ON user_preference');
        $this->addSql('ALTER TABLE user_preference DROP user_id');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user_preference ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_preference ADD CONSTRAINT FK_FA0E76BFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FA0E76BFA76ED395 ON user_preference (user_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6491748B0EE');
        $this->addSql('DROP INDEX UNIQ_8D93D6491748B0EE ON user');
        $this->addSql('ALTER TABLE user DROP user_preferences_id');
    }
}
