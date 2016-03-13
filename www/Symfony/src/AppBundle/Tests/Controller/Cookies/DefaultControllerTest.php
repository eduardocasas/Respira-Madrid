<?php

namespace AppBundle\Tests\Controller\Home;

use AppBundle\Tests\Controller\BaseControllerTest;

class DefaultControllerTest extends BaseControllerTest
{
    public function testIndex()
    {
        $client = $this->getClient();
        $crawler = $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Respira Madrid', $crawler->filter('title')->text());
    }
}
