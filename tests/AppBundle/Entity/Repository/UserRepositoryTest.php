<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 21.12.2016
 * Time: 11:34
 */

namespace tests\AppBundle\Entity\Repository;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine.orm.entity_manager');
    }

    public function testUserFindByRole()
    {
        $profs = $this->em->getRepository('AppBundle:User')
            ->findByRole(User::ROLE_PROF);

        $this->assertNotNull($profs);
        $this->assertCount(5, $profs);
    }
}