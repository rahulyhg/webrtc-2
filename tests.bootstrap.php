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

// add real data
$em = $kernel->getContainer()->get('doctrine.orm.entity_manager');


/* add testdata / fixtures here */

/* User */
// User Flo
$user1 = new AppBundle\Entity\User();
$user1->setFirstname('Florian');
$user1->setLastname('Mößle');
$user1->addRole(AppBundle\Entity\User::ROLE_STUDENT);
$password = $kernel->getContainer()->get('security.password_encoder')
    ->encodePassword($user1, 'Test1234');
$user1->setPassword($password);
$user1->setUsername('41mofl1bwi');

$em->persist($user1);

// User Patrick
$user2 = new AppBundle\Entity\User();
$user2->setFirstname('Patrick');
$user2->setLastname('Beckedorf');
$user2->addRole(AppBundle\Entity\User::ROLE_STUDENT);
$password = $kernel->getContainer()->get('security.password_encoder')
    ->encodePassword($user2, 'Test1234');
$user2->setPassword($password);
$user2->setUsername('41bepa1bwi');

$em->persist($user2);

// User Marvin
$user3 = new AppBundle\Entity\User();
$user3->setFirstname('Marvin');
$user3->setLastname('Wiest');
$user3->addRole(AppBundle\Entity\User::ROLE_STUDENT);
$password = $kernel->getContainer()->get('security.password_encoder')
    ->encodePassword($user3, 'Test1234');
$user3->setPassword($password);
$user3->setUsername('41wima1bwi');

$em->persist($user3);

/* Profs */
$user4 = new AppBundle\Entity\User();
$user4->setFirstname('Oliver');
$user4->setLastname('Höß');
$user4->addRole(AppBundle\Entity\User::ROLE_PROF);
$password = $kernel->getContainer()->get('security.password_encoder')
    ->encodePassword($user4, 'Test1234');
$user4->setPassword($password);
$user4->setUsername('hoess');
$user4->setTitle('Prof. Dr.');

$user4->addStudyCourse($studycourse8);
$user4->addStudyCourse($studycourse9);

$em->persist($user4);

$user5 = new AppBundle\Entity\User();
$user5->setFirstname('Ralf');
$user5->setLastname('Kramer');
$user5->addRole(AppBundle\Entity\User::ROLE_PROF);
$password = $kernel->getContainer()->get('security.password_encoder')
    ->encodePassword($user5, 'Test1234');
$user5->setPassword($password);
$user5->setUsername('kramer');
$user5->setTitle('Prof. Dr.');

$user5->addStudyCourse($studycourse8);
$user5->addStudyCourse($studycourse9);

$em->persist($user5);

$user6 = new AppBundle\Entity\User();
$user6->setFirstname('Ulrike');
$user6->setLastname('Pado');
$user6->addRole(AppBundle\Entity\User::ROLE_PROF);
$password = $kernel->getContainer()->get('security.password_encoder')
    ->encodePassword($user6, 'Test1234');
$user6->setPassword($password);
$user6->setUsername('pado');
$user6->setTitle('Prof. Dr.');

$user6->addStudyCourse($studycourse8);

$em->persist($user6);

$em->flush();

/* Meeting Slots */
// Open Meeting for prof 'hoess'
$meeting01 = new AppBundle\Entity\Meeting();
$meeting01->setStartDate($date = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-'. 18 .' 15:00:00'));
$meeting01->setEndDate($date = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-' . 18 .' 16:30:00'));
$meeting01->setStatus(\AppBundle\Entity\Slot::STATUS_OPEN);
$meeting01->setProfessor($user4);
$em->persist($meeting01);

// Accepted Meeting for prof 'hoess'
$meeting02 = new AppBundle\Entity\Meeting();
$meeting02->setStartDate($date = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-'. 23 .' 13:00:00'));
$meeting02->setEndDate($date = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-' . 23 .' 14:30:00'));
$meeting02->setStatus(\AppBundle\Entity\Slot::STATUS_ACCEPTED);
$meeting02->setProfessor($user4);
$em->persist($meeting02);

// Canceled Meeting for prof 'hoess'
$meeting03 = new AppBundle\Entity\Meeting();
$meeting03->setStartDate($date = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-'. 15 .' 11:00:00'));
$meeting03->setEndDate($date = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-' . 15 .' 12:30:00'));
$meeting03->setStatus(\AppBundle\Entity\Slot::STATUS_CANCELED);
$meeting03->setProfessor($user4);
$em->persist($meeting03);

// Declined Meeting for prof 'hoess'
$meeting04 = new AppBundle\Entity\Meeting();
$meeting04->setStartDate($date = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-'. 24 .' 15:00:00'));
$meeting04->setEndDate($date = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-' . 24 .' 16:30:00'));
$meeting04->setStatus(\AppBundle\Entity\Slot::STATUS_DECLINED);
$meeting04->setProfessor($user4);
$em->persist($meeting04);


// Open Meeting for prof 'kramer'
$meeting05 = new AppBundle\Entity\Meeting();
$meeting05->setStartDate($date = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-'. 24 .' 15:00:00'));
$meeting05->setEndDate($date = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-' . 24 .' 16:30:00'));
$meeting05->setStatus(\AppBundle\Entity\Slot::STATUS_OPEN);
$meeting05->setProfessor($user5);
$em->persist($meeting05);

// Declined Meeting for prof 'kramer'
$meeting05 = new AppBundle\Entity\Meeting();
$meeting05->setStartDate($date = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-'. 25 .' 13:30:00'));
$meeting05->setEndDate($date = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-' . 25 .' 15:00:00'));
$meeting05->setStatus(\AppBundle\Entity\Slot::STATUS_DECLINED);
$meeting05->setProfessor($user5);
$em->persist($meeting05);


// Canceled Meeting for prof 'pado'
$meeting06 = new AppBundle\Entity\Meeting();
$meeting06->setStartDate($date = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-'. 13 .' 13:30:00'));
$meeting06->setEndDate($date = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-' . 13 .' 15:00:00'));
$meeting06->setStatus(\AppBundle\Entity\Slot::STATUS_DECLINED);
$meeting06->setProfessor($user6);
$em->persist($meeting06);


$em->flush();


/* Slots */
// ad slot to marvin on accepted meeting from hoess which starts on 23.01 - 13.00-14.30
$slot01 = new AppBundle\Entity\Slot();
$slot01->setMeeting($meeting02);
$slot01->setStudent($user3);
$slot01->setName('Bachelor-Thesis');
$slot01->setStatus(\AppBundle\Entity\Slot::STATUS_ACCEPTED);
$slot01->setDuration(30);
$slot01->setDate($meeting02->getStartDate());
$slot01->setComment('Student Bachelorthema Besprechung Nr. 1: ' . $user3->getFirstname() . ' ' . $user3->getLastname());
$em->persist($slot01);

// ad slot to flo on accepted meeting from hoess which starts on 23.01 - 13.00-14.30
$slot02 = new AppBundle\Entity\Slot();
$slot02->setMeeting($meeting02);
$slot02->setStudent($user1);
$slot02->setName('Vorlesung Nachfragen');
$slot02->setDuration(20);
$slot02->setDate($slot01->getDate()->add(new \DateInterval('PT' . $slot01->getDuration() . 'M')));
$slot02->setComment('Student hat Nachfragen zu Abbildung 5.X: ' . $user1->getFirstname() . ' ' . $user1->getLastname());
$em->persist($slot02);

// ad slot to patrick on accepted meeting from hoess which starts on 23.01 - 13.00-14.30
$slot03 = new AppBundle\Entity\Slot();
$slot03->setMeeting($meeting02);
$slot03->setStudent($user2);
$slot03->setName('Fragen zu BPMN');
$slot03->setDuration(30);
$slot03->setDate($slot02->getDate()->add(new \DateInterval('PT' . $slot02->getDuration() . 'M')));
$slot03->setComment('Student hat Nachfragen zu Thema BPMN: ' . $user2->getFirstname() . ' ' . $user2->getLastname());
$em->persist($slot03);

$em->flush();

/* Meetings */

// add user (students)
/*for($i=0; $i<=100; $i++)
{
    $user = new AppBundle\Entity\User();
    $user->setFirstname('Studentvorname' . $i);
    $user->addRole(AppBundle\Entity\User::ROLE_STUDENT);
    $user->setLastname('Studentnachname' . $i);

    $password = $kernel->getContainer()->get('security.password_encoder')
        ->encodePassword($user, 'Test1234');
    $user->setPassword($password);
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

    $password = $kernel->getContainer()->get('security.password_encoder')
        ->encodePassword($user, 'Test1234');
    $user->setPassword($password);
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

}*/
// meetings
/*$firstDate = 4;
for($i=1; $i<=10; $i++) {
    $user15 = $em->getRepository('AppBundle:User')
        ->findOneBy(['username' => 'professormail' . $i . '@hft-stuttgart.de']);
    for($j=1; $j<=10; $j++) {
        $meeting01 = new AppBundle\Entity\Meeting();
        $meeting01->setStartDate($date = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-'. $firstDate .' 10:00:00'));
        $meeting01->setEndDate($date = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-' . $firstDate .' 11:30:00'));

        if($j%2 == 0) {
            $meeting01->setStatus(\AppBundle\Entity\Slot::STATUS_OPEN);
        }else{
            $meeting01->setStatus(\AppBundle\Entity\Slot::STATUS_CANCELED);
        }

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
*/

// slots
/*$studentNr = 1;
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
        $slot01->setDuration(30);
        $slot01->setDate($date = $getMeetingFromId->getStartDate());
        $slot01->setComment('Student:' . $studentNr);

        if($j%2 == 0) {
            $slot01->setStatus(\AppBundle\Entity\Slot::STATUS_OPEN);
        }else{
            $slot01->setStatus(\AppBundle\Entity\Slot::STATUS_CANCELED);
        }

        $em->persist($slot01);
        $em->flush();

        $studentNr = $studentNr + 1;

    }
}

// Update slot for frontend
$student = $em->getRepository('AppBundle:User')
    ->findOneBy(['username' => 'studentmail1@hft-stuttgart.de']);

/** @var \AppBundle\Entity\Slot $slot1 */
/*$slot1 = $em->getRepository('AppBundle:Meeting')
    ->findOneBy(['id' => 10]);
$slot1->setStudent($student);
$em->persist($slot1);

/** @var \AppBundle\Entity\Slot $slot2 *//*
$slot2 = $em->getRepository('AppBundle:Meeting')
    ->findOneBy(['id' => 11]);
$slot2->setStudent($student);
$em->persist($slot2);

$em->flush();*/