<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Fill country table
 */
final class Version20190221173303 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $countriesJson = file_get_contents(__DIR__."/../DataFixtures/countries.json");
        $countries = json_decode($countriesJson);
    
        foreach ($countries as $country) {
            $this->addSql('INSERT INTO country (name, code) VALUES (?, ?)', [$country->name, $country->code]);
        }

    }

    public function down(Schema $schema) : void
    {
        // Drop Country Table
        $this->addSql('DROP TABLE country');
    }
}
