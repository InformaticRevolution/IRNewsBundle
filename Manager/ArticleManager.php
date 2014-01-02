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

/**
 * Abstract Article Manager.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
abstract class ArticleManager implements ArticleManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function createArticle() 
    {
        $class = $this->getClass();
        
        return new $class();
    }
}
