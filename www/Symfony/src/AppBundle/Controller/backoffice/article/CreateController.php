<?php

namespace AppBundle\Controller\backoffice\article;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Article;
use AppBundle\Entity\ArticleExtend;
use AppBundle\Form\Type\ArticleType;

class CreateController extends Controller
{

    public function submitAction()
    {
        $article = new Article;
        $articleExtend = new ArticleExtend;
        $article->setArticleExtend($articleExtend);
        $form = $this->createForm(new ArticleType, $article);
        $form->bind($this->getRequest());
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $article->setDate(new \DateTime());
            $articleExtend->setArticle($article);
            $em->persist($article);
            $em->persist($articleExtend);
            $em->flush();

            return $this->redirect($this->generateUrl('backoffice_article'));
        }

        return ['entity' => $article, 'form' => $form->createView()];
    }
    
    public function indexAction()
    {
        $entity = new Article;
        $form = $this->createForm(new ArticleType, $entity);

        return $this->render('backoffice/article/create.html.twig', [
            'entity' => $entity, 'form' => $form->createView()
        ]);
    }
}
