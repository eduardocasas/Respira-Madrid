<?php

namespace AppBundle\Controller\blog;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function articleAction($date, $slug)
    {
        $article = $this->getDoctrine()->getManager()->getRepository('AppBundle:Article')->findOneBy([
            'date' => \DateTime::createFromFormat('Y-m-d', $date),
            'slug' => $slug,
            'active' => true,
        ]);
        if (!$article) {
            throw $this->createNotFoundException('Unable to find Article.');
        }

        return $this->render('blog/article.html.twig', [
            'tags' => $this->getDoctrine()->getManager()->getRepository('AppBundle:Tag')->findAll(),
            'article' => $article,
        ]);
    }

    public function indexByTagAction($tagSlug)
    {
        $tag = $this->getDoctrine()->getManager()->getRepository('AppBundle:Tag')->findOneBySlug($tagSlug);
        if (!$tag) {
            throw $this->createNotFoundException('Unable to find Tag.');
        }

        return $this->render('blog/index.html.twig', [
            'selectedTag' => $tag,
            'tags' => $this->getDoctrine()->getManager()->getRepository('AppBundle:Tag')->findAll(),
            'articles' => $this->getArticleCollectionByTag($tagSlug),
        ]);
    }

    public function indexAction()
    {
        return $this->render('blog/index.html.twig', [
            'tags' => $this->getDoctrine()->getManager()->getRepository('AppBundle:Tag')->findAll(),
            'articles' => $this->getDoctrine()->getManager()->getRepository('AppBundle:Article')->findByActive(true),
            'section' => 'blog',
        ]);
    }

    private function getArticleCollectionByTag($tag)
    {
        $collection = [];
        foreach ($this->getDoctrine()->getManager()->getRepository('AppBundle:Article')->findByActive(true) as $article) {
            if (in_array($tag, $article->getTagSlugCollection())) {
                $collection[] = $article;
            }
        }

        return $collection;
    }
}
