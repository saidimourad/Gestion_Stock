<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191021173850 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE detailentree (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, entree_id INT DEFAULT NULL, qteentree DOUBLE PRECISION NOT NULL, prixentree DOUBLE PRECISION NOT NULL, INDEX IDX_AE4B50637294869C (article_id), INDEX IDX_AE4B5063AF7BD910 (entree_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entree (id INT AUTO_INCREMENT NOT NULL, annee_scolaire_id INT DEFAULT NULL, magasin_id INT DEFAULT NULL, entuser_id INT DEFAULT NULL, commande_id INT DEFAULT NULL, ref_entree INT NOT NULL, date_entree DATETIME NOT NULL, INDEX IDX_598377A69331C741 (annee_scolaire_id), INDEX IDX_598377A620096AE3 (magasin_id), INDEX IDX_598377A652FD6EF5 (entuser_id), INDEX IDX_598377A682EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, userfr_id INT DEFAULT NULL, userchb_id INT DEFAULT NULL, userchu_id INT DEFAULT NULL, annee_scolaire_id INT DEFAULT NULL, magasin_id INT DEFAULT NULL, ref_commande INT NOT NULL, date_commande DATE NOT NULL, is_accept INT DEFAULT 0, is_valid INT DEFAULT 0, datelivraison DATE DEFAULT NULL, dateprevulivraison DATE DEFAULT NULL, is_livre INT DEFAULT NULL, INDEX IDX_6EEAA67DAFC23D17 (userfr_id), INDEX IDX_6EEAA67DF635D4B5 (userchb_id), INDEX IDX_6EEAA67D3BFBBB93 (userchu_id), INDEX IDX_6EEAA67D9331C741 (annee_scolaire_id), INDEX IDX_6EEAA67D20096AE3 (magasin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sortie (id INT AUTO_INCREMENT NOT NULL, repas_id INT DEFAULT NULL, magasin_id INT DEFAULT NULL, annee_scolaire_id INT DEFAULT NULL, user_id INT DEFAULT NULL, ref_sortie VARCHAR(255) NOT NULL, date_sortie DATE NOT NULL, INDEX IDX_3C3FD3F21D236AAA (repas_id), INDEX IDX_3C3FD3F220096AE3 (magasin_id), INDEX IDX_3C3FD3F29331C741 (annee_scolaire_id), INDEX IDX_3C3FD3F2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE annee_scolaire (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) NOT NULL, actif INT NOT NULL, encours INT DEFAULT 0, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detailsortie (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, sortie_id INT DEFAULT NULL, qtesortie DOUBLE PRECISION NOT NULL, INDEX IDX_CBF7F4377294869C (article_id), INDEX IDX_CBF7F437CC72D953 (sortie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lingecommande (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, commande_id INT DEFAULT NULL, qtecommande DOUBLE PRECISION NOT NULL, INDEX IDX_2636C767294869C (article_id), INDEX IDX_2636C7682EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE affecter_chefbureau (id INT AUTO_INCREMENT NOT NULL, region_id INT NOT NULL, user_id INT NOT NULL, annee_scolaire_id INT NOT NULL, date DATE NOT NULL, INDEX IDX_82D86FE198260155 (region_id), INDEX IDX_82D86FE1A76ED395 (user_id), INDEX IDX_82D86FE19331C741 (annee_scolaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE affecter_chefunite (id INT AUTO_INCREMENT NOT NULL, region_id INT NOT NULL, annee_scolaire_id INT NOT NULL, user_id INT NOT NULL, date DATE NOT NULL, INDEX IDX_CEEE609198260155 (region_id), INDEX IDX_CEEE60919331C741 (annee_scolaire_id), INDEX IDX_CEEE6091A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE affecter_magasinier (id INT AUTO_INCREMENT NOT NULL, annee_scolaire_id INT NOT NULL, magasin_id INT NOT NULL, user_id INT NOT NULL, date DATE NOT NULL, INDEX IDX_33773AA39331C741 (annee_scolaire_id), INDEX IDX_33773AA320096AE3 (magasin_id), INDEX IDX_33773AA3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE detailentree ADD CONSTRAINT FK_AE4B50637294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE detailentree ADD CONSTRAINT FK_AE4B5063AF7BD910 FOREIGN KEY (entree_id) REFERENCES entree (id)');
        $this->addSql('ALTER TABLE entree ADD CONSTRAINT FK_598377A69331C741 FOREIGN KEY (annee_scolaire_id) REFERENCES annee_scolaire (id)');
        $this->addSql('ALTER TABLE entree ADD CONSTRAINT FK_598377A620096AE3 FOREIGN KEY (magasin_id) REFERENCES magasin (id)');
        $this->addSql('ALTER TABLE entree ADD CONSTRAINT FK_598377A652FD6EF5 FOREIGN KEY (entuser_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE entree ADD CONSTRAINT FK_598377A682EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DAFC23D17 FOREIGN KEY (userfr_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DF635D4B5 FOREIGN KEY (userchb_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D3BFBBB93 FOREIGN KEY (userchu_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D9331C741 FOREIGN KEY (annee_scolaire_id) REFERENCES annee_scolaire (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D20096AE3 FOREIGN KEY (magasin_id) REFERENCES magasin (id)');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F21D236AAA FOREIGN KEY (repas_id) REFERENCES repas (id)');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F220096AE3 FOREIGN KEY (magasin_id) REFERENCES magasin (id)');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F29331C741 FOREIGN KEY (annee_scolaire_id) REFERENCES annee_scolaire (id)');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE detailsortie ADD CONSTRAINT FK_CBF7F4377294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE detailsortie ADD CONSTRAINT FK_CBF7F437CC72D953 FOREIGN KEY (sortie_id) REFERENCES sortie (id)');
        $this->addSql('ALTER TABLE lingecommande ADD CONSTRAINT FK_2636C767294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE lingecommande ADD CONSTRAINT FK_2636C7682EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE affecter_chefbureau ADD CONSTRAINT FK_82D86FE198260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE affecter_chefbureau ADD CONSTRAINT FK_82D86FE1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE affecter_chefbureau ADD CONSTRAINT FK_82D86FE19331C741 FOREIGN KEY (annee_scolaire_id) REFERENCES annee_scolaire (id)');
        $this->addSql('ALTER TABLE affecter_chefunite ADD CONSTRAINT FK_CEEE609198260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE affecter_chefunite ADD CONSTRAINT FK_CEEE60919331C741 FOREIGN KEY (annee_scolaire_id) REFERENCES annee_scolaire (id)');
        $this->addSql('ALTER TABLE affecter_chefunite ADD CONSTRAINT FK_CEEE6091A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE affecter_magasinier ADD CONSTRAINT FK_33773AA39331C741 FOREIGN KEY (annee_scolaire_id) REFERENCES annee_scolaire (id)');
        $this->addSql('ALTER TABLE affecter_magasinier ADD CONSTRAINT FK_33773AA320096AE3 FOREIGN KEY (magasin_id) REFERENCES magasin (id)');
        $this->addSql('ALTER TABLE affecter_magasinier ADD CONSTRAINT FK_33773AA3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD sexe VARCHAR(255) DEFAULT NULL, ADD etatcivil VARCHAR(255) DEFAULT NULL, ADD dateembauche DATE DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE detailentree DROP FOREIGN KEY FK_AE4B5063AF7BD910');
        $this->addSql('ALTER TABLE entree DROP FOREIGN KEY FK_598377A682EA2E54');
        $this->addSql('ALTER TABLE lingecommande DROP FOREIGN KEY FK_2636C7682EA2E54');
        $this->addSql('ALTER TABLE detailsortie DROP FOREIGN KEY FK_CBF7F437CC72D953');
        $this->addSql('ALTER TABLE entree DROP FOREIGN KEY FK_598377A69331C741');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D9331C741');
        $this->addSql('ALTER TABLE sortie DROP FOREIGN KEY FK_3C3FD3F29331C741');
        $this->addSql('ALTER TABLE affecter_chefbureau DROP FOREIGN KEY FK_82D86FE19331C741');
        $this->addSql('ALTER TABLE affecter_chefunite DROP FOREIGN KEY FK_CEEE60919331C741');
        $this->addSql('ALTER TABLE affecter_magasinier DROP FOREIGN KEY FK_33773AA39331C741');
        $this->addSql('DROP TABLE detailentree');
        $this->addSql('DROP TABLE entree');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE sortie');
        $this->addSql('DROP TABLE annee_scolaire');
        $this->addSql('DROP TABLE detailsortie');
        $this->addSql('DROP TABLE lingecommande');
        $this->addSql('DROP TABLE affecter_chefbureau');
        $this->addSql('DROP TABLE affecter_chefunite');
        $this->addSql('DROP TABLE affecter_magasinier');
        $this->addSql('ALTER TABLE user DROP sexe, DROP etatcivil, DROP dateembauche');
    }
}
