<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220622093813 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boisson ADD nom VARCHAR(255) NOT NULL, ADD image LONGTEXT NOT NULL COMMENT \'(DC2Type:object)\', ADD etat VARCHAR(255) NOT NULL, ADD type VARCHAR(255) NOT NULL, ADD prix DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE fritte ADD nom VARCHAR(255) NOT NULL, ADD image LONGTEXT NOT NULL COMMENT \'(DC2Type:object)\', ADD etat VARCHAR(255) NOT NULL, ADD type VARCHAR(255) NOT NULL, ADD prix DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boisson DROP nom, DROP image, DROP etat, DROP type, DROP prix');
        $this->addSql('ALTER TABLE fritte DROP nom, DROP image, DROP etat, DROP type, DROP prix');
    }
}
