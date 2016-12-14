<?php

/**
 * @author Patrick Beckedorf
 * Prevent foreign key constraints to block tests and their fixtures
 */

require __DIR__.'/app/autoload.php';

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Input\ArrayInput;

$kernel = new AppKernel('test', true); // create a "test" kernel
$kernel->boot();
$application = new Application($kernel);
$application->setAutoExit(false);

$db_drop = new ArrayInput(array(
    'command' => 'doctrine:schema:drop',
    '--env' => 'test',
    '--force' => true
));
$application->run($db_drop, new ConsoleOutput());

$db_create = new ArrayInput(array(
    'command' => 'doctrine:schema:update',
    '--env' => 'test',
    '--force' => true
));
$application->run($db_create, new ConsoleOutput());




/* add testdata / fixtures here */

$em = $kernel->getContainer()->get('doctrine.orm.entity_manager');

// add studycourses
$studycourse1 = new AppBundle\Entity\Studycourse();
$studycourse1->setName("Architektur");

$studycourse2 = new AppBundle\Entity\Studycourse();
$studycourse2->setName("Innenarchitektur");

$studycourse3 = new AppBundle\Entity\Studycourse();
$studycourse3->setName("Klimaengineering");

$studycourse4 = new AppBundle\Entity\Studycourse();
$studycourse4->setName("Bauingenieurwesen");

$studycourse5 = new AppBundle\Entity\Studycourse();
$studycourse5->setName("Infrastrukturmanagement");

$studycourse6 = new AppBundle\Entity\Studycourse();
$studycourse6->setName("Wirtschaftsingenieruwesen");

$studycourse7 = new AppBundle\Entity\Studycourse();
$studycourse7->setName("Bauphysik");

$studycourse8 = new AppBundle\Entity\Studycourse();
$studycourse8->setName("Informatik");

$studycourse9 = new AppBundle\Entity\Studycourse();
$studycourse9->setName("Wirtschaftsinformatik");

$studycourse10 = new AppBundle\Entity\Studycourse();
$studycourse10->setName("Informationslogistik");

$studycourse11 = new AppBundle\Entity\Studycourse();
$studycourse11->setName("Mathematik");

$studycourse12 = new AppBundle\Entity\Studycourse();
$studycourse12->setName("Vermessung und Geoinformatik");

$studycourse13 = new AppBundle\Entity\Studycourse();
$studycourse13->setName("Betriebswirtschaft");

$studycourse14 = new AppBundle\Entity\Studycourse();
$studycourse14->setName("Wirtschaftspsychologie");

$em->persist($studycourse1);
$em->persist($studycourse2);
$em->persist($studycourse3);
$em->persist($studycourse4);
$em->persist($studycourse5);
$em->persist($studycourse6);
$em->persist($studycourse7);
$em->persist($studycourse8);
$em->persist($studycourse9);
$em->persist($studycourse10);
$em->persist($studycourse11);
$em->persist($studycourse12);
$em->persist($studycourse13);
$em->persist($studycourse14);

$em->flush();


// add user (students)
for($i=0; $i<=100; $i++)
{
    $user = new AppBundle\Entity\User();
    $user->setFirstname('Studentvorname' . $i);
    $user->addRole(AppBundle\Entity\User::ROLE_STUDENT);
    $user->setLastname('Studentnachname' . $i);
    $user->setPassword('Studentpassword' . $i);
    $user->setUsername('studentmail' . $i . "@hft-stuttgart.de");
    $user->setTitle('');

    if ($i<100) $studycourse1->addUser($user);
    if ($i<200 AND $i>100) $studycourse1->addUser($user);
    if ($i<200 AND $i>100) $studycourse2->addUser($user);
    if ($i<250 AND $i>200) $studycourse3->addUser($user);
    if ($i<300 AND $i>250) $studycourse4->addUser($user);
    if ($i<350 AND $i>300) $studycourse5->addUser($user);
    if ($i<400 AND $i>350) $studycourse5->addUser($user);
    if ($i<450 AND $i>400) $studycourse6->addUser($user);
    if ($i<500 AND $i>450) $studycourse7->addUser($user);
    if ($i<550 AND $i>500) $studycourse8->addUser($user);
    if ($i<600 AND $i>550) $studycourse9->addUser($user);
    if ($i<650 AND $i>600) $studycourse10->addUser($user);
    if ($i<700 AND $i>650) $studycourse11->addUser($user);
    if ($i<750 AND $i>700) $studycourse12->addUser($user);
    if ($i<800 AND $i>750) $studycourse13->addUser($user);
    if ($i<1001 AND $i>800) $studycourse14->addUser($user);

    $em->persist($user);
    $em->flush();
}

// add user (prof)

for($i=0; $i<=100; $i++)
{
    $user = new AppBundle\Entity\User();
    $user->setFirstname('Professorvorname' . $i);
    $user->addRole(AppBundle\Entity\User::ROLE_PROF);
    $user->setLastname('Professornachname' . $i);
    $user->setPassword('Professorpassword' . $i);
    $user->setUsername('professormail' . $i . "@hft-stuttgart.de");
    $user->setTitle('Prof');

    if ($i<10) {
        $studycourse1->addUser($user);
        $studycourse3->addUser($user);
    }
    if ($i<20 AND $i>10) $studycourse4->addUser($user);
    if ($i<30 AND $i>20) $studycourse5->addUser($user);
    if ($i<40 AND $i>30) $studycourse6->addUser($user);
    if ($i<50 AND $i>40) $studycourse7->addUser($user);
    if ($i<60 AND $i>50) $studycourse8->addUser($user);
    if ($i<65 AND $i>60) $studycourse9->addUser($user);
    if ($i<70 AND $i>65) $studycourse10->addUser($user);
    if ($i<75 AND $i>70) $studycourse11->addUser($user);
    if ($i<80 AND $i>75) $studycourse12->addUser($user);
    if ($i<85 AND $i>80) $studycourse13->addUser($user);
    if ($i<101 AND $i>85) $studycourse14->addUser($user);

    $em->persist($user);
    $em->flush();

}
// meetings
$firstDate = 4;
for($i=1; $i<=10; $i++) {
    $user15 = $em->getRepository('AppBundle:User')
        ->findOneBy(['username' => 'professormail' . $i . '@hft-stuttgart.de']);
    for($j=1; $j<=10; $j++) {
        $meeting01 = new AppBundle\Entity\Meeting();
        $meeting01->setStartDate($date = DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-'. $firstDate .' 10:00:00'));
        $meeting01->setEndDate($date = DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-' . $firstDate .' 11:30:00'));

        $meeting01->setProfessor($user15);
        $em->persist($meeting01);
        $em->flush();
        $firstDate = $firstDate +7;
    }
    if($firstDate >= 6) {
        $firstDate = 2;
    }
    else{
        $firstDate = $firstDate + 1;
    }
}


// slots
$studentNr = 1;
for($i=1; $i<=15; $i++) {
    $getMeetingFromId = $em->getRepository('AppBundle:Meeting')
        ->findOneBy(['id' => $studentNr]);
    for($j=1; $j<=3; $j++) {
        $user16 = $em->getRepository('AppBundle:User')
            ->findOneBy(['username' => 'studentmail' . $studentNr .'@hft-stuttgart.de']);

        $slot01 = new AppBundle\Entity\Slot();
        $slot01->setMeeting($getMeetingFromId);
        $slot01->setStudent($user16);
        $slot01->setName('Bachelorthesis');
        $slot01->setTime(30);
        $slot01->setDate($date = $getMeetingFromId->getStartDate());
        $slot01->setComment('Student:' . $studentNr);
        $slot01->setStatus('requested');

        $em->persist($slot01);
        $em->flush();

        $studentNr = $studentNr + 1;

    }

}






