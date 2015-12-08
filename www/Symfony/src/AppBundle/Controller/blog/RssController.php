<?php

namespace AppBundle\Controller\blog;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RssController extends Controller
{
 
    public function indexByTagAction($tagSlug)
    {
        return $this->render('blog/rss.xml.twig', [
            'selectedTag' => $this->getDoctrine()->getManager()->getRepository('AppBundle:Tag')->findOneBySlug($tagSlug),
            'tags' => $this->getDoctrine()->getManager()->getRepository('AppBundle:Tag')->findAll(),
            'articles' => $this->getArticleCollectionByTag($tagSlug)
        ]);
    }
    
    public function indexAction()
    {
        return $this->render('blog/rss.xml.twig', [
            'tags' => $this->getDoctrine()->getManager()->getRepository('AppBundle:Tag')->findAll(),
            'articles' => $this->getDoctrine()->getManager()->getRepository('AppBundle:Article')->findByActive(true)
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
