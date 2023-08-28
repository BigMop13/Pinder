<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230828193426 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'changed user preference to have more than one gender in preference (NO-TASK)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE user_preference_gender (user_preference_id INT NOT NULL, gender_id INT NOT NULL, INDEX IDX_63D974F6369E8F90 (user_preference_id), INDEX IDX_63D974F6708A0E0 (gender_id), PRIMARY KEY(user_preference_id, gender_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_preference_gender ADD CONSTRAINT FK_63D974F6369E8F90 FOREIGN KEY (user_preference_id) REFERENCES user_preference (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_preference_gender ADD CONSTRAINT FK_63D974F6708A0E0 FOREIGN KEY (gender_id) REFERENCES gender (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_preference DROP FOREIGN KEY FK_FA0E76BF5A2DB2A0');
        $this->addSql('DROP INDEX IDX_FA0E76BF5A2DB2A0 ON user_preference');
        $this->addSql('ALTER TABLE user_preference DROP sex_id');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user_preference_gender DROP FOREIGN KEY FK_63D974F6369E8F90');
        $this->addSql('ALTER TABLE user_preference_gender DROP FOREIGN KEY FK_63D974F6708A0E0');
        $this->addSql('DROP TABLE user_preference_gender');
        $this->addSql('ALTER TABLE user_preference ADD sex_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_preference ADD CONSTRAINT FK_FA0E76BF5A2DB2A0 FOREIGN KEY (sex_id) REFERENCES gender (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_FA0E76BF5A2DB2A0 ON user_preference (sex_id)');
    }
}
