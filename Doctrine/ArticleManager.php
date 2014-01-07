<?php

/*
 * This file is part of the IRNewsBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\NewsBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

use IR\Bundle\NewsBundle\Model\ArticleInterface;
use IR\Bundle\NewsBundle\Manager\ArticleManager as AbstractArticleManager;

/**
 * Doctrine Article Manager.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ArticleManager extends AbstractArticleManager
{
    /**
     * @var ObjectManager
     */          
    protected $objectManager;
    
    /**
     * @var ObjectRepository
     */           
    protected $repository;    

    /**
     * @var string
     */           
    protected $class;  
    
    
   /**
    * Constructor.
    *
    * @param ObjectManager $om
    * @param string        $class
    */        
    public function __construct(ObjectManager $om, $class)
    {           
        $this->objectManager = $om;
        $this->repository = $om->getRepository($class);
        
        $metadata = $om->getClassMetadata($class);
        $this->class = $metadata->getName();
    }     
    
    /**
     * Updates an article.
     *
     * @param ArticleInterface $article
     * @param Boolean          $andFlush Whether to flush the changes (default true)
     */ 
    public function updateArticle(ArticleInterface $article, $andFlush = true)
    {  
        $this->objectManager->persist($article);
        
        if ($andFlush) {
            $this->objectManager->flush();
        }   
    }

    /**
     * {@inheritdoc}
     */    
    public function deleteArticle(ArticleInterface $article) 
    {
        $this->objectManager->remove($article);
        $this->objectManager->flush();           
    }

    /**
     * {@inheritdoc}
     */    
    public function findArticleBy(array $criteria) 
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * {@inheritdoc}
     */    
    public function findArticlesBy(array $criteria, array $orderBy = null, $limite = null, $offset = null) 
    {
        return $this->repository->findBy($criteria, $orderBy, $limite, $offset);
    }

    /**
     * {@inheritdoc}
     */    
    public function getClass() 
    {
        return $this->class;
    }
}
