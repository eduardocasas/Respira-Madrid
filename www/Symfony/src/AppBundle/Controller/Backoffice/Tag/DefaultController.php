<?php

namespace AppBundle\Controller\Backoffice\Tag;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('backoffice/tag/index.html.twig', [
            'tags' => $this->getDoctrine()->getManager()->getRepository('AppBundle:Tag')->findAll(),
        ]);
    }
}
