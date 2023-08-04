<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230804210901 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Created database tables which are needed in registration process (PINDER-16)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE gender (id INT AUTO_INCREMENT NOT NULL, sex VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hobby (id INT AUTO_INCREMENT NOT NULL, hobby VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, user_details_id INT DEFAULT NULL, image_url VARCHAR(255) NOT NULL, INDEX IDX_C53D045F1C7DC1CE (user_details_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, sex_id INT NOT NULL, uid VARCHAR(180) NOT NULL, roles JSON NOT NULL, username VARCHAR(255) DEFAULT NULL, age INT NOT NULL, address VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649539B0606 (uid), INDEX IDX_8D93D6495A2DB2A0 (sex_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_details (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, description LONGTEXT NOT NULL, education VARCHAR(255) DEFAULT NULL, work VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_2A2B1580A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_preference (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, sex_id INT DEFAULT NULL, lower_age_range INT DEFAULT NULL, upper_age_range INT DEFAULT NULL, radius_distance INT DEFAULT NULL, UNIQUE INDEX UNIQ_FA0E76BFA76ED395 (user_id), INDEX IDX_FA0E76BF5A2DB2A0 (sex_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_preference_hobby (user_preference_id INT NOT NULL, hobby_id INT NOT NULL, INDEX IDX_76DE2A51369E8F90 (user_preference_id), INDEX IDX_76DE2A51322B2123 (hobby_id), PRIMARY KEY(user_preference_id, hobby_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F1C7DC1CE FOREIGN KEY (user_details_id) REFERENCES user_details (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495A2DB2A0 FOREIGN KEY (sex_id) REFERENCES gender (id)');
        $this->addSql('ALTER TABLE user_details ADD CONSTRAINT FK_2A2B1580A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_preference ADD CONSTRAINT FK_FA0E76BFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_preference ADD CONSTRAINT FK_FA0E76BF5A2DB2A0 FOREIGN KEY (sex_id) REFERENCES gender (id)');
        $this->addSql('ALTER TABLE user_preference_hobby ADD CONSTRAINT FK_76DE2A51369E8F90 FOREIGN KEY (user_preference_id) REFERENCES user_preference (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_preference_hobby ADD CONSTRAINT FK_76DE2A51322B2123 FOREIGN KEY (hobby_id) REFERENCES hobby (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F1C7DC1CE');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495A2DB2A0');
        $this->addSql('ALTER TABLE user_details DROP FOREIGN KEY FK_2A2B1580A76ED395');
        $this->addSql('ALTER TABLE user_preference DROP FOREIGN KEY FK_FA0E76BFA76ED395');
        $this->addSql('ALTER TABLE user_preference DROP FOREIGN KEY FK_FA0E76BF5A2DB2A0');
        $this->addSql('ALTER TABLE user_preference_hobby DROP FOREIGN KEY FK_76DE2A51369E8F90');
        $this->addSql('ALTER TABLE user_preference_hobby DROP FOREIGN KEY FK_76DE2A51322B2123');
        $this->addSql('DROP TABLE gender');
        $this->addSql('DROP TABLE hobby');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_details');
        $this->addSql('DROP TABLE user_preference');
        $this->addSql('DROP TABLE user_preference_hobby');
    }
}
