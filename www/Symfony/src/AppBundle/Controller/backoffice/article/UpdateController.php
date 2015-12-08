<?php

namespace AppBundle\Controller\backoffice\article;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\Type\ArticleType;

class UpdateController extends Controller
{

    public function deleteAction($articleId)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($em->getRepository('AppBundle:Article')->find($articleId));
        $em->flush(); 

        return new Response($this->generateUrl('backoffice_article'));
    }
    
    public function submitAction($articleId)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Article')->find($articleId);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Users entity.');
        }
        $editForm = $this->createForm(new ArticleType, $entity);
        $editForm->bind($this->getRequest());
        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('backoffice_article'));
        }

        return $this->render('backoffice/article:update.html.twig', [
            'article' => $entity,
            'form' => $editForm->createView()
        ]);
    }
    
    public function indexAction($articleId)
    {
        $article = $this->getDoctrine()->getManager()->getRepository('AppBundle:Article')->find($articleId);
        if (!$article) {
            throw $this->createNotFoundException('Unable to find Users entity.');
        }
        $form = $this->createForm(new ArticleType, $article);

        return $this->render('backoffice/article/update.html.twig', [
            'article' => $article,
            'form'   => $form->createView()
        ]);
    }
}
