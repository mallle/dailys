<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200121190244 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE month_to_habit_to_day (id INT AUTO_INCREMENT NOT NULL, month_habit_id INT NOT NULL, day_id INT NOT NULL, checked TINYINT(1) NOT NULL, INDEX IDX_2A8C4B06A1D0B141 (month_habit_id), INDEX IDX_2A8C4B069C24126 (day_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE month_to_habit_to_day ADD CONSTRAINT FK_2A8C4B06A1D0B141 FOREIGN KEY (month_habit_id) REFERENCES month_to_habit (id)');
        $this->addSql('ALTER TABLE month_to_habit_to_day ADD CONSTRAINT FK_2A8C4B069C24126 FOREIGN KEY (day_id) REFERENCES day (id)');
        $this->addSql('DROP TABLE month_habit_to_day');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE month_habit_to_day (id INT AUTO_INCREMENT NOT NULL, month_habit_id INT NOT NULL, day_id INT NOT NULL, checked TINYINT(1) NOT NULL, INDEX IDX_A78EED209C24126 (day_id), INDEX IDX_A78EED20A1D0B141 (month_habit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE month_habit_to_day ADD CONSTRAINT FK_A78EED209C24126 FOREIGN KEY (day_id) REFERENCES day (id)');
        $this->addSql('ALTER TABLE month_habit_to_day ADD CONSTRAINT FK_A78EED20A1D0B141 FOREIGN KEY (month_habit_id) REFERENCES month_to_habit (id)');
        $this->addSql('DROP TABLE month_to_habit_to_day');
    }
}
