<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221203112840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, micro_post_id INT DEFAULT NULL, like_by_id INT DEFAULT NULL, seen TINYINT(1) NOT NULL, discr VARCHAR(255) NOT NULL, INDEX IDX_BF5476CAA76ED395 (user_id), INDEX IDX_BF5476CA11E37CEA (micro_post_id), INDEX IDX_BF5476CA1D8309E3 (like_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA11E37CEA FOREIGN KEY (micro_post_id) REFERENCES micro_post (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA1D8309E3 FOREIGN KEY (like_by_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAA76ED395');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA11E37CEA');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA1D8309E3');
        $this->addSql('DROP TABLE notification');
    }
}
