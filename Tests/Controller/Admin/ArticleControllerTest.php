<?php

/*
 * This file is part of the IRNewsBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\NewsBundle\Tests\Controller\Admin;

use IR\Bundle\NewsBundle\Tests\Functional\WebTestCase;

/**
 * Article Controller Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ArticleControllerTest extends WebTestCase
{       
    const FORM_INTENTION = 'article';
    
    
    protected function setUp()
    {
        parent::setUp();
        
        $this->loadFixtures('article');
    } 
    
    public function testListAction()
    {
        $crawler = $this->client->request('GET', '/admin/articles/');

        $this->assertResponseStatusCode(200);
        $this->assertCount(3, $crawler->filter('table tbody tr'));
    }
    
    public function testShowAction()
    {
        $this->client->request('GET', '/admin/articles/1');
        
        $this->assertResponseStatusCode(200);
    }      
    
    public function testNewActionGetMethod()
    {
        $crawler = $this->client->request('GET', '/admin/articles/new');
        
        $this->assertResponseStatusCode(200);
        $this->assertCount(1, $crawler->filter('form'));
    }         
    
    public function testNewActionPostMethod()
    {        
        $this->client->request('POST', '/admin/articles/new', array(
            'ir_news_article_form' => array (
                'title' => 'Article 1',
                'content' => 'Some content...',
                '_token' => $this->generateCsrfToken(static::FORM_INTENTION),
            ) 
        ));  
        
        $this->assertResponseStatusCode(302);
        
        $this->client->followRedirect();
        
        $this->assertResponseStatusCode(200);
        $this->assertCurrentUri('/admin/articles/4');
    }     
    
    public function testEditActionGetMethod()
    {   
        $crawler = $this->client->request('GET', '/admin/articles/1/edit');
        
        $this->assertResponseStatusCode(200);
        $this->assertCount(1, $crawler->filter('form'));        
    }
    
    public function testEditActionPostMethod()
    {        
        $this->client->request('POST', '/admin/articles/1/edit', array(
            'ir_news_article_form' => array (
                'title' => 'Article 1',       
                'content' => 'Some content...',
                '_token' => $this->generateCsrfToken(static::FORM_INTENTION),
            ) 
        ));     
        
        $this->assertResponseStatusCode(302);
        
        $this->client->followRedirect();
        
        $this->assertResponseStatusCode(200);
        $this->assertCurrentUri('/admin/articles/1');
    }     
    
    public function testDeleteAction()
    {
        $this->client->request('GET', '/admin/articles/1/delete');
        
        $this->assertResponseStatusCode(302);
        
        $crawler = $this->client->followRedirect();
        
        $this->assertResponseStatusCode(200);
        $this->assertCurrentUri('/admin/articles/');
        $this->assertCount(2, $crawler->filter('table tbody tr'));
    }      
    
    public function testNotFoundHttpWhenArticleNotExist()
    {
        $this->client->request('GET', '/admin/articles/4');
        $this->assertResponseStatusCode(404);        
        
        $this->client->request('GET', '/admin/articles/4/edit');
        $this->assertResponseStatusCode(404);
        
        $this->client->request('GET', '/admin/articles/4/delete');
        $this->assertResponseStatusCode(404);        
    }       
}
