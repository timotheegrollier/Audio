<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210817192235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Crée la relation entre le son et son Auteur';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sound ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE sound ADD CONSTRAINT FK_F88EC384A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F88EC384A76ED395 ON sound (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sound DROP FOREIGN KEY FK_F88EC384A76ED395');
        $this->addSql('DROP INDEX IDX_F88EC384A76ED395 ON sound');
        $this->addSql('ALTER TABLE sound DROP user_id');
    }
}