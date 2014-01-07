<?php

/*
 * This file is part of the IRNewsBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\NewsBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use IR\Bundle\NewsBundle\IRNewsEvents;
use IR\Bundle\NewsBundle\Event\ArticleEvent;
use IR\Bundle\NewsBundle\Model\ArticleInterface;

/**
 * Admin controller managing the articles.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ArticleController extends ContainerAware
{
    /**
     * List all the articles.
     */
    public function listAction()
    {
        $articles = $this->container->get('ir_news.manager.article')->findArticlesBy(array(), array('createdAt' => 'DESC'));

        return $this->container->get('templating')->renderResponse('IRNewsBundle:Admin/Article:list.html.'.$this->getEngine(), array(
            'articles' => $articles,
        ));
    }     
    
    /**
     * Show article details.
     */
    public function showAction($id)
    {
        $article = $this->findArticleById($id);

        return $this->container->get('templating')->renderResponse('IRNewsBundle:Admin/Article:show.html.'.$this->getEngine(), array(
            'article' => $article
        ));
    }       
    
    /**
     * Create a new article: show the new form.
     */
    public function newAction(Request $request)
    {       
        /* @var $articleManager \IR\Bundle\NewsBundle\Manager\ArticleManagerInterface */
        $articleManager = $this->container->get('ir_news.manager.article');
        $article = $articleManager->createArticle();
        
        $form = $this->container->get('ir_news.form.article'); 
        $form->setData($article);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $articleManager->updateArticle($article);
            
            /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
            $dispatcher = $this->container->get('event_dispatcher');                      
            $dispatcher->dispatch(IRNewsEvents::ARTICLE_CREATE_COMPLETED, new ArticleEvent($article));
                
            return new RedirectResponse($this->container->get('router')->generate('ir_news_admin_article_show', array('id' => $article->getId())));                      
        }
        
        return $this->container->get('templating')->renderResponse('IRNewsBundle:Admin/Article:new.html.'.$this->getEngine(), array(
            'form' => $form->createView(),
        ));          
    }    
    
    /**
     * Edit an article: show the edit form.
     */
    public function editAction(Request $request, $id)
    {
        $article = $this->findArticleById($id);

        $form = $this->container->get('ir_news.form.article');      
        $form->setData($article);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $this->container->get('ir_news.manager.article')->updateArticle($article);
            
            /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
            $dispatcher = $this->container->get('event_dispatcher');               
            $dispatcher->dispatch(IRNewsEvents::ARTICLE_EDIT_COMPLETED, new ArticleEvent($article));
                
            return new RedirectResponse($this->container->get('router')->generate('ir_news_admin_article_show', array('id' => $article->getId())));                     
        }        
        
        return $this->container->get('templating')->renderResponse('IRNewsBundle:Admin/Article:edit.html.'.$this->getEngine(), array(
            'article' => $article,
            'form' => $form->createView(),
        ));          
    }       
    
    /**
     * Delete an article.
     */
    public function deleteAction($id)
    {
        $article = $this->findArticleById($id);
        $this->container->get('ir_news.manager.article')->deleteArticle($article);
        
        /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');          
        $dispatcher->dispatch(IRNewsEvents::ARTICLE_DELETE_COMPLETED, new ArticleEvent($article));
        
        return new RedirectResponse($this->container->get('router')->generate('ir_news_admin_article_list'));   
    }     
    
    /**
     * Finds an article by id.
     *
     * @param mixed $id
     *
     * @return ArticleInterface
     * 
     * @throws NotFoundHttpException When article does not exist
     */
    protected function findArticleById($id)
    {
        $article = $this->container->get('ir_news.manager.article')->findArticleBy(array('id' => $id));

        if (null === $article) {
            throw new NotFoundHttpException(sprintf('The article with id %s does not exist', $id));
        }

        return $article;
    }         
    
    /**
     * Returns the template engine.
     * 
     * @return string
     */    
   protected function getEngine()
    {
        return $this->container->getParameter('ir_news.template.engine');
    }    
}
