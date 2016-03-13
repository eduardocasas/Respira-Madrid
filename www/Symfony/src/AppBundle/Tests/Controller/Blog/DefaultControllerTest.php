<?php

namespace AppBundle\Tests\Controller\Blog;

use AppBundle\Tests\Controller\BaseControllerTest;

class DefaultControllerTest extends BaseControllerTest
{
    public function testIndex()
    {
        $client = $this->getClient();
        $crawler = $client->request('GET', '/blog');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Blog | Respira Madrid', $crawler->filter('title')->text());
    }
}
