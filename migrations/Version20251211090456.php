<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 *
 * Add watchlist table
 */
final class Version20251211090456 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE watchlist (id INT AUTO_INCREMENT NOT NULL, added_at DATETIME NOT NULL, user_id INT NOT NULL, INDEX IDX_340388D3A76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE watchlist ADD CONSTRAINT FK_340388D3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE watchlist DROP FOREIGN KEY FK_340388D3A76ED395');
        $this->addSql('DROP TABLE watchlist');
    }
}
