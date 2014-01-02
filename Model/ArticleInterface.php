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
 * Article Interface.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface ArticleInterface 
{
    /**
     * Returns the id.
     * 
     * @return mixed
     */
    public function getId();    
    
    /**
     * Returns the title.
     * 
     * @return string
     */
    public function getTitle();
    
    /**
     * Sets the title.
     * 
     * @param string $title
     */
    public function setTitle($title);
    
    /**
     * Returns the slug.
     * 
     * @return string
     */
    public function getSlug();
    
    /**
     * Sets the slug.
     * 
     * @param string $slug
     */
    public function setSlug($slug);
    
    /**
     * Returns the content.
     * 
     * @return string
     */
    public function getContent();
    
    /**
     * Sets the content.
     * 
     * @param string $content
     */
    public function setContent($content);
    
    /**
     * Returns the creation time.
     *
     * @return \Datetime
     */
    public function getCreatedAt();   
    
    /**
     * Sets the creation time.
     * 
     * @param \Datetime $createdAt
     */
    public function setCreatedAt(\Datetime $createdAt);  
    
    /**
     * Returns the last update time.
     *
     * @return \Datetime
     */
    public function getUpdatedAt();  
    
    /**
     * Sets the last update time.
     * 
     * @param \Datetime|null $updatedAt
     */
    public function setUpdatedAt(\Datetime $updatedAt = null);     
}
