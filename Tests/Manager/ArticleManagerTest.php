<?php

/*
 * This file is part of the IRNewsBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\NewsBundle\Tests\Manager;

use IR\Bundle\NewsBundle\Manager\ArticleManager;

/**
 * Article Manager Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ArticleManagerTest extends \PHPUnit_Framework_TestCase
{
    const ARTICLE_CLASS = 'IR\Bundle\NewsBundle\Tests\TestArticle';
    
    /**
     * @var ArticleManager
     */
    protected $articleManager;
    
    
    public function setUp()
    {
        $this->articleManager = $this->getMockForAbstractClass('IR\Bundle\NewsBundle\Manager\ArticleManager');
        
        $this->articleManager->expects($this->any())
            ->method('getClass')
            ->will($this->returnValue(static::ARTICLE_CLASS));
    }
    
    public function testCreateArticle()
    {
        $article = $this->articleManager->createArticle();
        
        $this->assertInstanceOf(static::ARTICLE_CLASS, $article);
    }
}
