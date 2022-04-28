<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220428223032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blame (id INT AUTO_INCREMENT NOT NULL, eagle_id INT NOT NULL, date DATETIME NOT NULL, reason VARCHAR(255) NOT NULL, INDEX IDX_F0BEBAA1C23885A (eagle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE history (id INT AUTO_INCREMENT NOT NULL, eagle_id INT NOT NULL, roles JSON NOT NULL, valid_until DATETIME NOT NULL, INDEX IDX_27BA704BC23885A (eagle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mandate (id INT AUTO_INCREMENT NOT NULL, next_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, start DATE NOT NULL, UNIQUE INDEX UNIQ_197D0FEEAA23F6C8 (next_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poll (id INT AUTO_INCREMENT NOT NULL, post_id INT NOT NULL, end DATETIME NOT NULL, UNIQUE INDEX UNIQ_84BCFA454B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poll_option (id INT AUTO_INCREMENT NOT NULL, poll_id INT NOT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_B68343EB3C947C0F (poll_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE polling (id INT AUTO_INCREMENT NOT NULL, eagle_id INT NOT NULL, poll_id INT NOT NULL, poll_option_id INT NOT NULL, date DATETIME NOT NULL, INDEX IDX_CA3A2250C23885A (eagle_id), INDEX IDX_CA3A22503C947C0F (poll_id), INDEX IDX_CA3A22506C13349B (poll_option_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blame ADD CONSTRAINT FK_F0BEBAA1C23885A FOREIGN KEY (eagle_id) REFERENCES eagle (id)');
        $this->addSql('ALTER TABLE history ADD CONSTRAINT FK_27BA704BC23885A FOREIGN KEY (eagle_id) REFERENCES eagle (id)');
        $this->addSql('ALTER TABLE mandate ADD CONSTRAINT FK_197D0FEEAA23F6C8 FOREIGN KEY (next_id) REFERENCES mandate (id)');
        $this->addSql('ALTER TABLE poll ADD CONSTRAINT FK_84BCFA454B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE poll_option ADD CONSTRAINT FK_B68343EB3C947C0F FOREIGN KEY (poll_id) REFERENCES poll (id)');
        $this->addSql('ALTER TABLE polling ADD CONSTRAINT FK_CA3A2250C23885A FOREIGN KEY (eagle_id) REFERENCES eagle (id)');
        $this->addSql('ALTER TABLE polling ADD CONSTRAINT FK_CA3A22503C947C0F FOREIGN KEY (poll_id) REFERENCES poll (id)');
        $this->addSql('ALTER TABLE polling ADD CONSTRAINT FK_CA3A22506C13349B FOREIGN KEY (poll_option_id) REFERENCES poll_option (id)');
        $this->addSql('ALTER TABLE eagle CHANGE department_id department_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post CHANGE author_id author_id INT NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE imgs imgs LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mandate DROP FOREIGN KEY FK_197D0FEEAA23F6C8');
        $this->addSql('ALTER TABLE poll_option DROP FOREIGN KEY FK_B68343EB3C947C0F');
        $this->addSql('ALTER TABLE polling DROP FOREIGN KEY FK_CA3A22503C947C0F');
        $this->addSql('ALTER TABLE polling DROP FOREIGN KEY FK_CA3A22506C13349B');
        $this->addSql('DROP TABLE blame');
        $this->addSql('DROP TABLE history');
        $this->addSql('DROP TABLE mandate');
        $this->addSql('DROP TABLE poll');
        $this->addSql('DROP TABLE poll_option');
        $this->addSql('DROP TABLE polling');
        $this->addSql('ALTER TABLE eagle CHANGE department_id department_id INT NOT NULL');
        $this->addSql('ALTER TABLE post CHANGE author_id author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product CHANGE imgs imgs LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
    }
}
