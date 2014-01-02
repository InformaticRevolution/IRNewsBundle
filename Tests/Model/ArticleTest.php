<?php

/*
 * This file is part of the IRNewsBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\NewsBundle\Tests\Model;

use IR\Bundle\NewsBundle\Model\Article;

/**
 * Article Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ArticleTest extends \PHPUnit_Framework_TestCase
{  
    /**
     * @dataProvider getSimpleTestData
     */
    public function testSimpleSettersGetters($property, $value, $default)
    {   
        $getter = 'get'.$property;
        $setter = 'set'.$property;
        
        $article = $this->getArticle();

        $this->assertEquals($default, $article->$getter());
        $article->$setter($value);
        $this->assertEquals($value, $article->$getter());
    }
    
    public function getSimpleTestData()
    {
        return array(
            array('title', 'Test Article', null),
            array('slug', 'test-article', null),
            array('content', 'Some content...', null),
            array('createdAt', new \DateTime(), null),
            array('updatedAt', new \DateTime(), null),
        );
    }     
    
    /**
     * @return Article
     */
    protected function getArticle()
    {
        return $this->getMockForAbstractClass('IR\Bundle\NewsBundle\Model\Article');
    }      
}
