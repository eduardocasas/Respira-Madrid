<?php

namespace AppBundle\Controller\backoffice\article;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Article;
use AppBundle\Entity\ArticleExtend;
use AppBundle\Form\Type\ArticleType;

class CreateController extends Controller
{

    public function submitAction(Request $request)
    {
        $article = new Article;
        $articleExtend = new ArticleExtend;
        $article->setArticleExtend($articleExtend);
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
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
        $form = $this->createForm(ArticleType::class, $entity);

        return $this->render('backoffice/article/create.html.twig', [
            'entity' => $entity, 'form' => $form->createView()
        ]);
    }
}
