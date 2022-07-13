<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220713152919 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        //$this->addSql('ALTER TABLE commande CHANGE prix prix DOUBLE PRECISION NOT NULL');
        //$this->addSql('ALTER TABLE ligne_de_commande CHANGE prix prix DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE produit CHANGE image image LONGBLOB DEFAULT NULL');
       // $this->addSql('ALTER TABLE zone CHANGE prix prix DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
       // $this->addSql('ALTER TABLE commande CHANGE prix prix DOUBLE PRECISION DEFAULT NULL');
       // $this->addSql('ALTER TABLE ligne_de_commande CHANGE prix prix DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE produit CHANGE image image LONGBLOB NOT NULL');
      //  $this->addSql('ALTER TABLE zone CHANGE prix prix DOUBLE PRECISION DEFAULT NULL');
    }
}
