<?php

namespace AppBundle\Tests\Controller\contact;

use AppBundle\Tests\Controller\BaseControllerTest;

class DefaultControllerTest extends BaseControllerTest
{
    public function testIndex()
    {
        $client = $this->getClient();
        $crawler = $client->request('GET', '/contact');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Contacto | Respira Madrid', $crawler->filter('title')->text());
    }
}
