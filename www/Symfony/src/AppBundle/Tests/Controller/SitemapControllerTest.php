<?php

namespace AppBundle\Tests\Controller;

class SitemapControllerTest extends BaseControllerTest
{
    public function testIndex()
    {
        $client = $this->getClient();
        $crawler = $client->request('GET', '/sitemap.xml');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('/', substr($crawler->children()->first()->text(), -1));
        $this->assertContains('/contact', $crawler->children()->eq(1)->text());
        $this->assertContains('/cookies', $crawler->children()->eq(2)->text());
        $this->assertContains('/blog', $crawler->children()->eq(3)->text());
    }
}
