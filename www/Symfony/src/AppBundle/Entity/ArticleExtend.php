<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArticleExtend.
 *
 * @ORM\Table(name="article_extend")
 * @ORM\Entity
 */
class ArticleExtend
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="html", type="text")
     */
    private $html;

    /**
     * @var string
     *
     * @ORM\Column(name="markdown", type="text")
     */
    private $markdown;

    /**
     * @ORM\OneToOne(targetEntity="Article", inversedBy="article_extend")
     * @ORM\JoinColumn(name="id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $article;

    public function setArticle(Article $article)
    {
        $this->article = $article;
    }

    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set html.
     *
     * @param string $html
     *
     * @return ArticleExtend
     */
    public function setHtml($html)
    {
        $this->html = $html;

        return $this;
    }

    /**
     * Get html.
     *
     * @return string
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * Set markdown.
     *
     * @param string $markdown
     *
     * @return ArticleExtend
     */
    public function setMarkdown($markdown)
    {
        $this->markdown = $markdown;

        return $this;
    }

    /**
     * Get markdown.
     *
     * @return string
     */
    public function getMarkdown()
    {
        return $this->markdown;
    }
}
