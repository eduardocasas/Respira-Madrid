<?php

namespace AppBundle\Controller\backoffice\article;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('backoffice/article/index.html.twig', [
            'articles' => $this->getDoctrine()->getManager()->getRepository('AppBundle:Article')->findAll(),
        ]);
    }
}
