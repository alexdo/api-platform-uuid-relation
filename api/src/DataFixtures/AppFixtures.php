<?php

namespace App\DataFixtures;

use App\Entity\Greeter;
use App\Entity\Greeting;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $greeter1 = (new Greeter())->setGreeterName('Greeter #1');
        $greeting1 = (new Greeting())->setName('Greeting #1');
        $greeting2 = (new Greeting())->setName('Greeting #2');
        $greeting3 = (new Greeting())->setName('Greeting #3');
        $greeter1
            ->addGreeting($greeting1)
            ->addGreeting($greeting2)
            ->addGreeting($greeting3);

        $greeter2 = (new Greeter())->setGreeterName('Greeter #2');
        $greeter3 = (new Greeter())->setGreeterName('Greeter #3');
        $greeting4 = (new Greeting())->setName('Greeting #4');
        $greeting4
            ->addGreeter($greeter2)
            ->addGreeter($greeter3);

        $manager->persist($greeter1);
        $manager->persist($greeter2);
        $manager->persist($greeter3);
        $manager->persist($greeting1);
        $manager->persist($greeting2);
        $manager->persist($greeting3);
        $manager->persist($greeting4);
        $manager->flush();
    }
}
