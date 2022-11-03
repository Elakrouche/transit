<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220831150410 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, agent_matricule_id INT DEFAULT NULL, fournisseur_matri_id INT DEFAULT NULL, client_id INT DEFAULT NULL, fourgon_id INT DEFAULT NULL, remorque_id INT DEFAULT NULL, parking_matricule_id INT DEFAULT NULL, date_transit DATETIME NOT NULL, montant INT NOT NULL, num_dossier VARCHAR(255) NOT NULL, num_facture VARCHAR(255) NOT NULL, INDEX IDX_723705D1ECE653CE (agent_matricule_id), INDEX IDX_723705D167376A9B (fournisseur_matri_id), INDEX IDX_723705D119EB6921 (client_id), INDEX IDX_723705D16F844FAE (fourgon_id), INDEX IDX_723705D141A32AC4 (remorque_id), INDEX IDX_723705D11B486506 (parking_matricule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transit (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1ECE653CE FOREIGN KEY (agent_matricule_id) REFERENCES agent (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D167376A9B FOREIGN KEY (fournisseur_matri_id) REFERENCES fournisseur (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D119EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D16F844FAE FOREIGN KEY (fourgon_id) REFERENCES fourgon (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D141A32AC4 FOREIGN KEY (remorque_id) REFERENCES remorque (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D11B486506 FOREIGN KEY (parking_matricule_id) REFERENCES parking (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1ECE653CE');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D167376A9B');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D119EB6921');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D16F844FAE');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D141A32AC4');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D11B486506');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE transit');
    }
}
