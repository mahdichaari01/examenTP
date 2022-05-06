<?php

namespace App\DataFixtures;

use App\Entity\Etudiant;
use App\Entity\Section;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class Exam extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //remplir la table section
        $sections = [
            "math", "physique", "sciences", "geography", "histoire", "arts", "economie", "infirmatique"
        ];
        $faker = Factory::create();
        foreach ($sections as $section) {
            $entry = new Section();
            $entry->setDesignation($section);
            $manager->persist($entry);
            $r = random_int(0, 30);
            for ($j = 0; $j < $r; $j++) {
                $entry2 = new Etudiant();
                $entry2->setPrenom($faker->firstName);
                $entry2->setNom($faker->lastName);
                if ($faker->randomDigit == 0) $entry2->setSection(null);
                else $entry2->setSection($entry);
                $manager->persist($entry2);
            }
        }

        //remplir la table etudiant


        $manager->flush();
    }
}
