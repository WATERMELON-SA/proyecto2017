<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Pacient;
use AppBundle\Entity\Site;
use AppBundle\Entity\User;
use AppBundle\Entity\Role;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures implements ORMFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $this->patients($manager);
        $this->site($manager);
        $adminRole = $this->roles($manager);

        $this->users($adminRole, $manager);

        $manager->flush();
    }

    private function patients($manager){
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
    }

    private function site($manager){
        $site = new Site();
        $site-> setTitulo('Hospital Gutierrez');
        $site-> setDescripcion('Hospital');
        $site-> setEmail('hpgutierrez@gmail.com');
        $site-> setElementosPagina(5);
        $site-> setSitioHabilitado(true);

        $manager->persist($site);
    }

    private function roles($manager){
        $role1 = new Role();
        $role1-> setName('ROLE_Administrador');
        $manager-> persist($role1);

        $role2 = new Role();
        $role2-> setName('ROLE_Pediatra');
        $manager-> persist($role2);
        
        $role3 = new Role();
        $role3-> setName('ROLE_Recepcionista');
        $manager-> persist($role3);

        return $role1;
    }

    private function users($role, $manager){
        $manager-> persist($this->create_user($role,'julian','julian','julian@gmail.com'));
        $manager-> persist($this->create_user($role,'nacho','nacho','nacho@gmail.com'));
        $manager-> persist($this->create_user($role,'santi','santi','santi@gmail.com'));
    }

    private function create_user($role, $username, $password, $email ){
        $user = new User();
        $user-> setUsername($username);
        $user-> setPassword(md5($password));
        $user-> setEmail($email);
        $user-> setActive(true);
        $user-> setName('name');
        $user-> setSurname('surname');
        $user-> setDeleted(false);
        $user-> setRoles([$role]);

        return $user;
    }
}

?>