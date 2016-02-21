<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SitemapController extends Controller
{
    public function indexAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/xml');

        return $this->render('sitemap.xml.twig', [
            'tags' => $this->getDoctrine()->getManager()->getRepository('AppBundle:Tag')->findAll(),
            'articles' => $this->getDoctrine()->getManager()->getRepository('AppBundle:Article')->findByActive(true),
        ], $response);
    }
}
