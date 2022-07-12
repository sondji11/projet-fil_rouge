<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220706105024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menu_burger (id INT AUTO_INCREMENT NOT NULL, burger_id INT DEFAULT NULL, menu_id INT DEFAULT NULL, quantiterburger VARCHAR(255) DEFAULT NULL, INDEX IDX_3CA402D517CE5090 (burger_id), INDEX IDX_3CA402D5CCD7E912 (menu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_portion (id INT AUTO_INCREMENT NOT NULL, portionfrite_id INT DEFAULT NULL, menu_id INT DEFAULT NULL, quantitefrite VARCHAR(255) DEFAULT NULL, INDEX IDX_685BE098B2D45716 (portionfrite_id), INDEX IDX_685BE098CCD7E912 (menu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE menu_burger ADD CONSTRAINT FK_3CA402D517CE5090 FOREIGN KEY (burger_id) REFERENCES burger (id)');
        $this->addSql('ALTER TABLE menu_burger ADD CONSTRAINT FK_3CA402D5CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE menu_portion ADD CONSTRAINT FK_685BE098B2D45716 FOREIGN KEY (portionfrite_id) REFERENCES portionfrite (id)');
        $this->addSql('ALTER TABLE menu_portion ADD CONSTRAINT FK_685BE098CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('DROP TABLE menu_portionfrite');
        $this->addSql('ALTER TABLE menu_taille DROP FOREIGN KEY FK_A517D3E0FF25611A');
        $this->addSql('ALTER TABLE menu_taille DROP FOREIGN KEY FK_A517D3E0CCD7E912');
        $this->addSql('ALTER TABLE menu_taille ADD id INT AUTO_INCREMENT NOT NULL, ADD quantitetaille VARCHAR(255) DEFAULT NULL, CHANGE menu_id menu_id INT DEFAULT NULL, CHANGE taille_id taille_id INT DEFAULT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE menu_taille ADD CONSTRAINT FK_A517D3E0FF25611A FOREIGN KEY (taille_id) REFERENCES taille (id)');
        $this->addSql('ALTER TABLE menu_taille ADD CONSTRAINT FK_A517D3E0CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menu_portionfrite (menu_id INT NOT NULL, portionfrite_id INT NOT NULL, INDEX IDX_DA2FC97ACCD7E912 (menu_id), INDEX IDX_DA2FC97AB2D45716 (portionfrite_id), PRIMARY KEY(menu_id, portionfrite_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE menu_portionfrite ADD CONSTRAINT FK_DA2FC97ACCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_portionfrite ADD CONSTRAINT FK_DA2FC97AB2D45716 FOREIGN KEY (portionfrite_id) REFERENCES portionfrite (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE menu_burger');
        $this->addSql('DROP TABLE menu_portion');
        $this->addSql('ALTER TABLE menu_taille MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE menu_taille DROP FOREIGN KEY FK_A517D3E0FF25611A');
        $this->addSql('ALTER TABLE menu_taille DROP FOREIGN KEY FK_A517D3E0CCD7E912');
        $this->addSql('ALTER TABLE menu_taille DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE menu_taille DROP id, DROP quantitetaille, CHANGE taille_id taille_id INT NOT NULL, CHANGE menu_id menu_id INT NOT NULL');
        $this->addSql('ALTER TABLE menu_taille ADD CONSTRAINT FK_A517D3E0FF25611A FOREIGN KEY (taille_id) REFERENCES taille (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_taille ADD CONSTRAINT FK_A517D3E0CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_taille ADD PRIMARY KEY (menu_id, taille_id)');
    }
}
