<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Pacient;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures implements ORMFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            date_default_timezone_set('UTC');
            $pacient = new Pacient();
            $pacient->setName('paciente '.$i);
            $pacient->setSurname('surname'.$i);
            $pacient->setAddress('calle'.$i);
            $pacient->setPhone((String) $i*100000);
            $pacient->setBirthdate(new \DateTime('today'));
            $pacient->setGender('1');
            $pacient->setDniNumber($i*100050);
            $pacient->setDeleted(false);
            $pacient->setIdObraSocial(1);
            $pacient->setIdTipoDoc(1);
            $manager->persist($pacient);
        }

        $manager->flush();
    }
}

?>