<?php

/*
 * This file is part of the IRNewsBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\NewsBundle\Manager;

use IR\Bundle\NewsBundle\Model\ArticleInterface;

/**
 * Article Manager Interface.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface ArticleManagerInterface
{
    /**
     * Creates an empty article instance.
     * 
     * @return ArticleInterface
     */
    public function createArticle();
    
    /**
     * Updates an article.
     * 
     * @param ArticleInterface $article
     */
    public function updateArticle(ArticleInterface $article);
    
    /**
     * Deletes an article.
     * 
     * @param ArticleInterface $article
     */
    public function deleteArticle(ArticleInterface $article);
    
    /**
     * Finds an article by given criteria.
     * 
     * @param array $criteria
     * 
     * @return ArticleInterface|null
     */
    public function findArticleBy(array $criteria);

    /**
     * Finds articles by given criteria.
     * 
     * @param array $criteria
     * 
     * @return array
     */
    public function findArticlesBy(array $criteria);

    /**
     * Returns the article's fully qualified class name.
     * 
     * @return string
     */
    public function getClass();
}
