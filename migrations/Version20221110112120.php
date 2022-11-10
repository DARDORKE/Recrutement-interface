<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221110112120 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidate (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, last_name VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, cv LONGBLOB DEFAULT NULL, is_active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_C8B28E44E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candidate_job_offer (candidate_id INT NOT NULL, job_offer_id INT NOT NULL, INDEX IDX_37F1E76291BD8781 (candidate_id), INDEX IDX_37F1E7623481D195 (job_offer_id), PRIMARY KEY(candidate_id, job_offer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_offer (id INT AUTO_INCREMENT NOT NULL, recruiter_id INT NOT NULL, job_title VARCHAR(255) NOT NULL, workplace VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, is_published TINYINT(1) NOT NULL, INDEX IDX_288A3A4E156BE243 (recruiter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recruiter (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, company_name VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_DE8633D8E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidate_job_offer ADD CONSTRAINT FK_37F1E76291BD8781 FOREIGN KEY (candidate_id) REFERENCES candidate (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candidate_job_offer ADD CONSTRAINT FK_37F1E7623481D195 FOREIGN KEY (job_offer_id) REFERENCES job_offer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job_offer ADD CONSTRAINT FK_288A3A4E156BE243 FOREIGN KEY (recruiter_id) REFERENCES recruiter (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidate_job_offer DROP FOREIGN KEY FK_37F1E76291BD8781');
        $this->addSql('ALTER TABLE candidate_job_offer DROP FOREIGN KEY FK_37F1E7623481D195');
        $this->addSql('ALTER TABLE job_offer DROP FOREIGN KEY FK_288A3A4E156BE243');
        $this->addSql('DROP TABLE candidate');
        $this->addSql('DROP TABLE candidate_job_offer');
        $this->addSql('DROP TABLE job_offer');
        $this->addSql('DROP TABLE recruiter');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
