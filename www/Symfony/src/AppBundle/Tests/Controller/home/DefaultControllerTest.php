<?php

namespace AppBundle\Tests\Controller\cookies;

use AppBundle\Tests\Controller\BaseControllerTest;

class DefaultControllerTest extends BaseControllerTest
{

    public function testIndex()
    {
        $client = $this->getClient();
        $crawler = $client->request('GET', '/cookies');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Politica de Cookies | Respira Madrid', $crawler->filter('title')->text());              
    }

}
