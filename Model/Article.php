<?php

/*
 * This file is part of the IRNewsBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\NewsBundle\Model;

/**
 * Abstract Article implementation.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
abstract class Article implements ArticleInterface
{
    /**
     * @var mixed
     */
    protected $id;
    
    /**
     * @var string 
     */     
    protected $title;
    
    /**
     * @var string
     */
    protected $slug;
    
    /**
     * @var string
     */
    protected $content;
    
    /**
     * @var \DateTime
     */
    protected $createdAt;
    
    /**
     * @var \DateTime
     */
    protected $updatedAt;
    
    
    /**
     * {@inheritdoc}
     */
    public function getId() 
    {
        return $this->id;
    }
    
    /**
     * {@inheritdoc}
     */    
    public function getTitle() 
    {
        return $this->title;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setTitle($title) 
    {
        $this->title = $title;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getSlug() 
    {
        return $this->slug;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setSlug($slug) 
    {
        $this->slug = $slug;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getContent() 
    {
        return $this->content;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setContent($content) 
    {
        $this->content = $content;
    }
    
    /**
     * {@inheritdoc}
     */   
    public function getCreatedAt()
    {
        return $this->createdAt;
    }    

    /**
     * {@inheritdoc}
     */   
    public function setCreatedAt(\Datetime $createdAt)
    {
        $this->createdAt = $createdAt;        
    }        
    
    /**
     * {@inheritdoc}
     */   
    public function getUpdatedAt() 
    {
        return $this->updatedAt;
    }
    
    /**
     * {@inheritdoc}
     */   
    public function setUpdatedAt(\Datetime $updatedAt = null) 
    {
        $this->updatedAt = $updatedAt;
    }
}
