<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220508095521 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6688C5F785');
        $this->addSql('CREATE TABLE discount (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, rate DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE price_proposal (id INT AUTO_INCREMENT NOT NULL, discount_id INT NOT NULL, prospect_id INT NOT NULL, object VARCHAR(255) NOT NULL, creation_date DATE NOT NULL, currency VARCHAR(255) NOT NULL, INDEX IDX_DD53AF654C7C611F (discount_id), INDEX IDX_DD53AF65D182060A (prospect_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE price_proposal_service (price_proposal_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_4742B746F3A06C4E (price_proposal_id), INDEX IDX_4742B746ED5CA9E6 (service_id), PRIMARY KEY(price_proposal_id, service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE price_proposal_feature (id INT AUTO_INCREMENT NOT NULL, price_proposal_id INT NOT NULL, description LONGTEXT NOT NULL, qty INT NOT NULL, price DOUBLE PRECISION NOT NULL, discount DOUBLE PRECISION DEFAULT NULL, INDEX IDX_B90858F2F3A06C4E (price_proposal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prospect (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, agent VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, department_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_E19D9AD2AE80F5DF (department_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_feature (id INT AUTO_INCREMENT NOT NULL, service_id INT NOT NULL, description LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_D05327FAED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE price_proposal ADD CONSTRAINT FK_DD53AF654C7C611F FOREIGN KEY (discount_id) REFERENCES discount (id)');
        $this->addSql('ALTER TABLE price_proposal ADD CONSTRAINT FK_DD53AF65D182060A FOREIGN KEY (prospect_id) REFERENCES prospect (id)');
        $this->addSql('ALTER TABLE price_proposal_service ADD CONSTRAINT FK_4742B746F3A06C4E FOREIGN KEY (price_proposal_id) REFERENCES price_proposal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE price_proposal_service ADD CONSTRAINT FK_4742B746ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE price_proposal_feature ADD CONSTRAINT FK_B90858F2F3A06C4E FOREIGN KEY (price_proposal_id) REFERENCES price_proposal (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE service_feature ADD CONSTRAINT FK_D05327FAED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_category');
        $this->addSql('ALTER TABLE eagle DROP linkedin');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE price_proposal DROP FOREIGN KEY FK_DD53AF654C7C611F');
        $this->addSql('ALTER TABLE price_proposal_service DROP FOREIGN KEY FK_4742B746F3A06C4E');
        $this->addSql('ALTER TABLE price_proposal_feature DROP FOREIGN KEY FK_B90858F2F3A06C4E');
        $this->addSql('ALTER TABLE price_proposal DROP FOREIGN KEY FK_DD53AF65D182060A');
        $this->addSql('ALTER TABLE price_proposal_service DROP FOREIGN KEY FK_4742B746ED5CA9E6');
        $this->addSql('ALTER TABLE service_feature DROP FOREIGN KEY FK_D05327FAED5CA9E6');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, eagle_id INT NOT NULL, article_category_id INT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date DATE NOT NULL, img VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, content LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_23A0E6688C5F785 (article_category_id), INDEX IDX_23A0E66C23885A (eagle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE article_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6688C5F785 FOREIGN KEY (article_category_id) REFERENCES article_category (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66C23885A FOREIGN KEY (eagle_id) REFERENCES eagle (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE discount');
        $this->addSql('DROP TABLE price_proposal');
        $this->addSql('DROP TABLE price_proposal_service');
        $this->addSql('DROP TABLE price_proposal_feature');
        $this->addSql('DROP TABLE prospect');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE service_feature');
        $this->addSql('ALTER TABLE eagle ADD linkedin VARCHAR(255) DEFAULT NULL');
    }
}
