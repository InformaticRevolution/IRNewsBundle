<?php

/*
 * This file is part of the IRNewsBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\NewsBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use IR\Bundle\NewsBundle\Model\ArticleInterface;

/**
 * Article Event.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ArticleEvent extends Event
{
    /**
     * @var ArticleInterface
     */        
    protected $article;
    
    
   /**
    * Constructor.
    *
    * @param ArticleInterface $article
    */         
    public function __construct(ArticleInterface $article)
    {
        $this->article = $article;
    }

    /**
     * Returns the article.
     * 
     * @return ArticleInterface
     */
    public function getArticle()
    {
        return $this->article;
    }
}