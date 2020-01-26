<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200126054811 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE month_to_habit DROP FOREIGN KEY FK_9BC12B1E7AEB3B2');
        $this->addSql('ALTER TABLE month_to_habit ADD CONSTRAINT FK_9BC12B1E7AEB3B2 FOREIGN KEY (habit_id) REFERENCES habit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE month_to_habit_to_day DROP FOREIGN KEY FK_2A8C4B06E7AEB3B2');
        $this->addSql('ALTER TABLE month_to_habit_to_day ADD CONSTRAINT FK_2A8C4B06E7AEB3B2 FOREIGN KEY (habit_id) REFERENCES habit (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE month_to_habit DROP FOREIGN KEY FK_9BC12B1E7AEB3B2');
        $this->addSql('ALTER TABLE month_to_habit ADD CONSTRAINT FK_9BC12B1E7AEB3B2 FOREIGN KEY (habit_id) REFERENCES habit (id)');
        $this->addSql('ALTER TABLE month_to_habit_to_day DROP FOREIGN KEY FK_2A8C4B06E7AEB3B2');
        $this->addSql('ALTER TABLE month_to_habit_to_day ADD CONSTRAINT FK_2A8C4B06E7AEB3B2 FOREIGN KEY (habit_id) REFERENCES habit (id)');
    }
}
