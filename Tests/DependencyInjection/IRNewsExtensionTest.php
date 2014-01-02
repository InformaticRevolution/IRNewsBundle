<?php

/*
 * This file is part of the IRNewsBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\NewsBundle\Tests\DependencyInjection;

use Symfony\Component\Yaml\Parser;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use IR\Bundle\NewsBundle\DependencyInjection\IRNewsExtension;

/**
 * News Extension Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class IRNewsExtensionTest extends \PHPUnit_Framework_TestCase
{
    /** 
     * @var ContainerBuilder
     */
    protected $configuration;
    
    
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testNewsLoadThrowsExceptionUnlessDatabaseDriverSet()
    {
        $loader = new IRNewsExtension();
        $config = $this->getEmptyConfig();
        unset($config['db_driver']);
        $loader->load(array($config), new ContainerBuilder());
    }
    
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testNewsLoadThrowsExceptionUnlessDatabaseDriverIsValid()
    {
        $loader = new IRNewsExtension();
        $config = $this->getEmptyConfig();
        $config['db_driver'] = 'foo';
        $loader->load(array($config), new ContainerBuilder());
    }         
    
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testNewsLoadThrowsExceptionUnlessArticleModelClassSet()
    {
        $loader = new IRNewsExtension();
        $config = $this->getEmptyConfig();
        unset($config['article_class']);
        $loader->load(array($config), new ContainerBuilder());
    }      
    
    public function testDisableArticle()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new IRNewsExtension();
        $config = $this->getEmptyConfig();
        $config['article'] = false;
        $loader->load(array($config), $this->configuration);
        $this->assertNotHasDefinition('ir_news.form.name.article');
    }     
    
    public function testNewsLoadModelClassWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('Acme\NewsBundle\Entity\Article', 'ir_news.model.article.class');
    }       
    
    public function testNewsLoadModelClass()
    {
        $this->createFullConfiguration();

        $this->assertParameter('Acme\NewsBundle\Entity\Article', 'ir_news.model.article.class');
    }        
    
    public function testNewsLoadManagerClassWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('orm', 'ir_news.db_driver');
        $this->assertAlias('ir_news.manager.article.default', 'ir_news.manager.article');
    }           
    
    public function testNewsLoadManagerClass()
    {
        $this->createFullConfiguration();

        $this->assertParameter('orm', 'ir_news.db_driver');
        $this->assertAlias('acme_news.manager.article', 'ir_news.manager.article');
    }    
    
    public function testNewsLoadFormClassWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('ir_news_article', 'ir_news.form.type.article');
    }         
    
    public function testNewsLoadFormClass()
    {
        $this->createFullConfiguration();

        $this->assertParameter('acme_news_article', 'ir_news.form.type.article');
    }        
    
    public function testNewsLoadFormNameWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('ir_news_article_form', 'ir_news.form.name.article');
    }       
    
    public function testNewsLoadFormName()
    {
        $this->createFullConfiguration();

        $this->assertParameter('acme_news_article_form', 'ir_news.form.name.article');
    }      
    
    public function testNewsLoadFormServiceWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertHasDefinition('ir_news.form.article');
    }      
    
    public function testNewsLoadFormService()
    {
        $this->createFullConfiguration();

        $this->assertHasDefinition('ir_news.form.article');
    }        
    
    public function testNewsLoadTemplateConfigWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('twig', 'ir_news.template.engine');
    }     
    
    public function testNewsLoadTemplateConfig()
    {
        $this->createFullConfiguration();

        $this->assertParameter('php', 'ir_news.template.engine');
    }      
    
    protected function createEmptyConfiguration()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new IRNewsExtension();
        $config = $this->getEmptyConfig();
        $loader->load(array($config), $this->configuration);
        $this->assertTrue($this->configuration instanceof ContainerBuilder);
    }      
    
    protected function createFullConfiguration()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new IRNewsExtension();
        $config = $this->getFullConfig();
        $loader->load(array($config), $this->configuration);
        $this->assertTrue($this->configuration instanceof ContainerBuilder);
    }     
    
    /**
     * @return array
     */
    protected function getEmptyConfig()
    {
        $parser = new Parser();
        
        return $parser->parse(file_get_contents(__DIR__.'/Fixtures/minimal_config.yml'));
    }    
    
    /**
     * @return array
     */    
    protected function getFullConfig()
    {
        $parser = new Parser();

        return $parser->parse(file_get_contents(__DIR__.'/Fixtures/full_config.yml'));
    }         
    
    /**
     * @param string $value
     * @param string $key
     */
    private function assertAlias($value, $key)
    {
        $this->assertEquals($value, (string) $this->configuration->getAlias($key), sprintf('%s alias is correct', $key));
    }         
    
    /**
     * @param mixed  $value
     * @param string $key
     */
    private function assertParameter($value, $key)
    {
        $this->assertEquals($value, $this->configuration->getParameter($key), sprintf('%s parameter is incorrect', $key));
    }   
    
    /**
     * @param string $id
     */
    private function assertHasDefinition($id)
    {
        $this->assertTrue(($this->configuration->hasDefinition($id) ?: $this->configuration->hasAlias($id)));
    }          
    
    /**
     * @param string $id
     */
    private function assertNotHasDefinition($id)
    {
        $this->assertFalse(($this->configuration->hasDefinition($id) ?: $this->configuration->hasAlias($id)));
    }      
    
    protected function tearDown()
    {
        unset($this->configuration);
    }        
}
