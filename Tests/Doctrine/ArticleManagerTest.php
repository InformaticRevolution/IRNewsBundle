<?php

/*
 * This file is part of the IRNewsBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\NewsBundle\Tests\Doctrine;

use IR\Bundle\NewsBundle\Doctrine\ArticleManager;

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

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $objectManager;
    
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $repository;
    
    
    public function setUp()
    {   
        if (!interface_exists('Doctrine\Common\Persistence\ObjectManager')) {
            $this->markTestSkipped('Doctrine Common has to be installed for this test to run.');
        }  
                
        $class = $this->getMock('Doctrine\Common\Persistence\Mapping\ClassMetadata');
        $this->objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->repository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
                
        $this->objectManager->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo(static::ARTICLE_CLASS))
            ->will($this->returnValue($this->repository));        

        $this->objectManager->expects($this->any())
            ->method('getClassMetadata')
            ->with($this->equalTo(static::ARTICLE_CLASS))
            ->will($this->returnValue($class));        
        
        $class->expects($this->any())
            ->method('getName')
            ->will($this->returnValue(static::ARTICLE_CLASS));        
        
        $this->articleManager = new ArticleManager($this->objectManager, static::ARTICLE_CLASS);
    }    
    
    public function testUpdateArticle()
    {
        $article = $this->getArticle();
        
        $this->objectManager->expects($this->once())
            ->method('persist')
            ->with($this->equalTo($article));
        
        $this->objectManager->expects($this->once())
            ->method('flush');

        $this->articleManager->updateArticle($article);
    }    
    
    public function testDeleteArticle()
    {
        $article = $this->getArticle();
        
        $this->objectManager->expects($this->once())
            ->method('remove')
            ->with($this->equalTo($article));
        
        $this->objectManager->expects($this->once())
            ->method('flush');

        $this->articleManager->deleteArticle($article);
    }      
    
    public function testFindArticleBy()
    {
        $criteria = array("foo" => "bar");
        
        $this->repository->expects($this->once())
            ->method('findOneBy')
            ->with($this->equalTo($criteria))
            ->will($this->returnValue(array()));

        $this->articleManager->findArticleBy($criteria);
    }    
    
    public function testFindArticlesBy()
    {
        $criteria = array("foo" => "bar");
        
        $this->repository->expects($this->once())
            ->method('findBy')
            ->with($this->equalTo($criteria))
            ->will($this->returnValue(array()));

        $this->articleManager->findArticlesBy($criteria);
    }      
    
    public function testGetClass()
    {
        $this->assertEquals(static::ARTICLE_CLASS, $this->articleManager->getClass());
    }    
    
    protected function getArticle()
    {
        $class = static::ARTICLE_CLASS;

        return new $class();
    }     
}
