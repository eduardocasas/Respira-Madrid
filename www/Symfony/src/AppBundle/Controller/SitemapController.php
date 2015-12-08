<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SitemapController extends Controller
{

    public function indexAction()
    {
        return $this->render('sitemap.xml.twig', [
            'tags' => $this->getDoctrine()->getManager()->getRepository('AppBundle:Tag')->findAll(),
            'articles' => $this->getDoctrine()->getManager()->getRepository('AppBundle:Article')->findByActive(true)
        ]);
    }

}
