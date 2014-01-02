<?php

/*
 * This file is part of the IRNewsBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\NewsBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * News Extension.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class IRNewsExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load(sprintf('driver/%s/article.xml', $config['db_driver']));
        $loader->load('listeners.xml');

        $container->setParameter('ir_news.db_driver', $config['db_driver']);
        $container->setParameter('ir_news.model.article.class', $config['article_class']);
        $container->setParameter('ir_news.template.engine', $config['template']['engine']);
        $container->setParameter('ir_news.backend_type_' . $config['db_driver'], true);
        
        $container->setAlias('ir_news.manager.article', $config['article_manager']);
        
        if (!empty($config['article'])) {
            $this->loadArticle($config['article'], $container, $loader);
        }         
    }
    
    private function loadArticle(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {        
        $loader->load('article.xml');
        
        $container->setParameter('ir_news.form.name.article', $config['form']['name']);
        $container->setParameter('ir_news.form.type.article', $config['form']['type']);
        $container->setParameter('ir_news.form.validation_groups.article', $config['form']['validation_groups']);
    }     
}
