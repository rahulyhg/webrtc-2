<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Test\EnhancedWebTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\BrowserKit\Cookie;

/**
 * @author Patrick Beckedorf
 */
class UserControllerTest extends EnhancedWebTestCase
{

    /** @var EntityManagerInterface */
    private $em;


    protected function setUp()
    {
        static::bootKernel();
        $container = static::$kernel->getContainer();
        $this->em = $container->get('doctrine.orm.entity_manager');
    }

    public function testProfessorsAction()
    {
        //

        $this->createUser('test7', 'Test1234', User::ROLE_PROF);
        $client = static::createClient();

        $token = $this->getAuthorizedToken('test7');
        $cookie = new Cookie('__token', $token);
        $client->getCookieJar()->set($cookie);

        $client->request('POST', '/hello');

        $response = $client->getResponse();
        $this->assertEquals(201, $response->getStatusCode());
        $this->asserter()->assertResponsePropertyEquals($response, 'key', 'hello');
    }

    public function testIndexMissingToken()
    {
        $client = static::createClient();

        $client->request('POST', '/hello');

        $response = $client->getResponse();

        $this->assertEquals(401, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->headers->get('Content-Type'));
        $this->asserter()->assertResponsePropertyExists($response, 'detail');
        $this->asserter()->assertResponsePropertyEquals($response, 'title', 'Unauthorized');
    }

    public function testIndexFalseToken()
    {
        $client = static::createClient();

        $token = $this->getFalseToken();
        $cookie = new Cookie('__token', $token);
        $client->getCookieJar()->set($cookie);

        $client->request('POST', '/hello');

        $response = $client->getResponse();

        $this->assertEquals(401, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->headers->get('Content-Type'));
        $this->asserter()->assertResponsePropertyExists($response, 'detail');
        $this->asserter()->assertResponsePropertyEquals($response, 'title', 'Unauthorized');
    }
}