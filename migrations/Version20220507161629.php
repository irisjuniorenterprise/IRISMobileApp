<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220507161629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, eagle_id INT NOT NULL, article_category_id INT NOT NULL, title VARCHAR(255) NOT NULL, date DATE NOT NULL, img VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_23A0E66C23885A (eagle_id), INDEX IDX_23A0E6688C5F785 (article_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66C23885A FOREIGN KEY (eagle_id) REFERENCES eagle (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6688C5F785 FOREIGN KEY (article_category_id) REFERENCES article_category (id)');
        $this->addSql('ALTER TABLE eagle ADD linkedin VARCHAR(255) DEFAULT NULL, CHANGE university_id university_id INT NOT NULL, CHANGE study_field_id study_field_id INT NOT NULL');
        $this->addSql('ALTER TABLE post CHANGE author_id author_id INT NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE imgs imgs LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6688C5F785');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_category');
        $this->addSql('ALTER TABLE eagle DROP linkedin, CHANGE university_id university_id INT DEFAULT NULL, CHANGE study_field_id study_field_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post CHANGE author_id author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product CHANGE imgs imgs LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
    }
}
