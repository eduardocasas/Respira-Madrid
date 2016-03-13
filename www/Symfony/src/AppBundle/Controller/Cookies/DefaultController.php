<?php

namespace AppBundle\Controller\Cookies;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('cookies/index.html.twig');
    }
}
