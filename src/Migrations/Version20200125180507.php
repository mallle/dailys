<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200125180507 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE day (id INT AUTO_INCREMENT NOT NULL, number INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE month (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE month_to_habit_to_day (id INT AUTO_INCREMENT NOT NULL, day_id INT NOT NULL, month_id INT NOT NULL, habit_id INT NOT NULL, checked TINYINT(1) NOT NULL, INDEX IDX_2A8C4B069C24126 (day_id), INDEX IDX_2A8C4B06A0CBDE4 (month_id), INDEX IDX_2A8C4B06E7AEB3B2 (habit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE habit (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE month_to_habit_to_day ADD CONSTRAINT FK_2A8C4B069C24126 FOREIGN KEY (day_id) REFERENCES day (id)');
        $this->addSql('ALTER TABLE month_to_habit_to_day ADD CONSTRAINT FK_2A8C4B06A0CBDE4 FOREIGN KEY (month_id) REFERENCES month (id)');
        $this->addSql('ALTER TABLE month_to_habit_to_day ADD CONSTRAINT FK_2A8C4B06E7AEB3B2 FOREIGN KEY (habit_id) REFERENCES habit (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE month_to_habit_to_day DROP FOREIGN KEY FK_2A8C4B069C24126');
        $this->addSql('ALTER TABLE month_to_habit_to_day DROP FOREIGN KEY FK_2A8C4B06A0CBDE4');
        $this->addSql('ALTER TABLE month_to_habit_to_day DROP FOREIGN KEY FK_2A8C4B06E7AEB3B2');
        $this->addSql('DROP TABLE day');
        $this->addSql('DROP TABLE month');
        $this->addSql('DROP TABLE month_to_habit_to_day');
        $this->addSql('DROP TABLE habit');
    }
}
