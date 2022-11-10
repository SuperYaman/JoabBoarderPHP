<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221010095445 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE not_user_apply ADD advertisement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE not_user_apply ADD CONSTRAINT FK_CF13205DA1FBF71B FOREIGN KEY (advertisement_id) REFERENCES advertisement (id)');
        $this->addSql('CREATE INDEX IDX_CF13205DA1FBF71B ON not_user_apply (advertisement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE not_user_apply DROP FOREIGN KEY FK_CF13205DA1FBF71B');
        $this->addSql('DROP INDEX IDX_CF13205DA1FBF71B ON not_user_apply');
        $this->addSql('ALTER TABLE not_user_apply DROP advertisement_id');
    }
}
