<?php

/*
 * This file is part of the IRNewsBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\NewsBundle;

/**
 * Contains all events thrown in the IRNewsBundle.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
final class IRNewsEvents
{
    /**
     * The ARTICLE_CREATE_COMPLETED event occurs after saving the article in the article creation process.
     *
     * The event listener method receives a IR\Bundle\NewsBundle\Event\ArticleEvent instance.
     */
    const ARTICLE_CREATE_COMPLETED = 'ir_news.article.create.completed';
    
    /**
     * The ARTICLE_EDIT_COMPLETED event occurs after saving the article in the article edit process.
     *
     * The event listener method receives a IR\Bundle\NewsBundle\Event\ArticleEvent instance.
     */
    const ARTICLE_EDIT_COMPLETED = 'ir_news.article.edit.completed';
    
    /**
     * The ARTICLE_DELETE_COMPLETED event occurs after deleting the article.
     *
     * The event listener method receives a IR\Bundle\NewsBundle\Event\ArticleEvent instance.
     */
    const ARTICLE_DELETE_COMPLETED = 'ir_news.article.delete.completed'; 
}